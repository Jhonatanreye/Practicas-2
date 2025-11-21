<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class EmpleadoController extends Controller
{
    /**
     * Muestra el listado de empleados
     */
    public function index(Request $request)
    {
        try {
            Log::info('===== INICIO PROCESAMIENTO DE FILTROS =====');
            Log::info('Método HTTP: ' . $request->method());
            Log::info('URL completa: ' . $request->fullUrl());
            Log::info('Todos los parámetros recibidos:', $request->all());
            
            // Verificar si hay parámetros específicos
            if ($request->has('curp')) {
                Log::info('CURP recibido [' . $request->input('curp') . ']');
            } else {
                Log::info('No se recibió parámetro CURP');
            }
            
            // Verificar headers
            Log::info('Headers relevantes:', [
                'Content-Type' => $request->header('Content-Type'),
                'Accept' => $request->header('Accept'),
                'X-CSRF-TOKEN' => $request->header('X-CSRF-TOKEN') ? 'Presente' : 'Ausente'
            ]);
            
            // Registrar el inicio de la operación para medir el tiempo
            $tiempoInicio = microtime(true);
            
            // Iniciar consulta
            $query = Empleado::query();
            
            // Aplicar filtros si existen
            if ($request->filled('curp')) {
                $curp = trim($request->curp);
                // Eliminar cualquier coma que pueda estar al final
                $curp = rtrim($curp, ',');
                // Para CURP hacemos búsqueda exacta
                $query->where('curp', $curp);
                Log::info('Filtro CURP aplicado (exacto):', ['curp' => $curp]);
            }
            
            if ($request->filled('apellido_paterno')) {
                $apellidoPaterno = trim($request->apellido_paterno);
                $query->where('apellido_paterno', 'like', '%' . $apellidoPaterno . '%');
                Log::info('Filtro apellido paterno aplicado:', ['apellido_paterno' => $apellidoPaterno]);
            }
            
            if ($request->filled('apellido_materno')) {
                $apellidoMaterno = trim($request->apellido_materno);
                $query->where('apellido_materno', 'like', '%' . $apellidoMaterno . '%');
                Log::info('Filtro apellido materno aplicado:', ['apellido_materno' => $apellidoMaterno]);
            }
            
            if ($request->filled('nombre')) {
                $nombre = trim($request->nombre);
                $query->where('nombre', 'like', '%' . $nombre . '%');
                Log::info('Filtro nombre aplicado:', ['nombre' => $nombre]);
            }
            
            if ($request->filled('num_empleado')) {
                $numEmpleado = trim($request->num_empleado);
                $query->where('num_empleado', 'like', '%' . $numEmpleado . '%');
                Log::info('Filtro número de empleado aplicado:', ['num_empleado' => $numEmpleado]);
            }
            
            if ($request->filled('puesto')) {
                $puesto = trim($request->puesto);
                $query->where('puesto', 'like', '%' . $puesto . '%');
                Log::info('Filtro puesto aplicado:', ['puesto' => $puesto]);
            }
            
            if ($request->filled('dependencia')) {
                $dependencia = trim($request->dependencia);
                $query->where('dependencia', 'like', '%' . $dependencia . '%');
                Log::info('Filtro dependencia aplicado:', ['dependencia' => $dependencia]);
            }
            
            if ($request->filled('email')) {
                $email = trim($request->email);
                $query->where('email', 'like', '%' . $email . '%');
                Log::info('Filtro email aplicado:', ['email' => $email]);
            }
            
            if ($request->filled('telefono')) {
                $telefono = trim($request->telefono);
                $query->where('telefono', 'like', '%' . $telefono . '%');
                Log::info('Filtro teléfono aplicado:', ['telefono' => $telefono]);
            }
            
            if ($request->filled('status')) {
                $status = trim($request->status);
                $query->where('status', $status);
                Log::info('Filtro status aplicado:', ['status' => $status]);
            }
            
            // Limitar consulta a un máximo de 30 segundos para evitar bloqueos
            try {
                // Añadir un límite de tiempo para la consulta (no funciona en todos los drivers)
                if (DB::connection()->getDriverName() === 'mysql') {
                    DB::statement('SET SESSION MAX_EXECUTION_TIME=30000');
                }
                
                // Ejecutar la consulta con un timeout de 30 segundos
                $empleados = $query->get();
                $total = $empleados->count();
                
                // Registrar el tiempo de ejecución
                $tiempoFin = microtime(true);
                $tiempoEjecucion = round(($tiempoFin - $tiempoInicio) * 1000, 2); // en milisegundos
                
                Log::info('Búsqueda completada en ' . $tiempoEjecucion . ' ms. Empleados encontrados:', ['count' => $total]);
                
                if ($total > 0) {
                    Log::info('Muestra del primer empleado:', $empleados->first()->toArray());
                }
            } catch (\Exception $e) {
                Log::error('Error en la consulta de empleados: ' . $e->getMessage());
                throw new \Exception('La consulta ha excedido el tiempo límite o ha ocurrido un error: ' . $e->getMessage());
            }

            if ($request->ajax()) {
                return response()->json([
                    'data' => $empleados,
                    'total' => $total,
                    'filtros_aplicados' => $request->all(),
                    'tiempo_ejecucion' => isset($tiempoEjecucion) ? $tiempoEjecucion : null,
                    'mensaje' => 'Datos recuperados correctamente'
                ]);
            }

            return view('usuarios', compact('empleados'));
        } catch (\Exception $e) {
            Log::error('Error al obtener empleados: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'filtros' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Error al obtener los empleados',
                    'mensaje' => $e->getMessage(),
                    'filtros' => $request->all()
                ], 500);
            }
            
            return back()->with('error', 'Error al obtener los empleados: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para crear un nuevo empleado
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Almacena un nuevo empleado
     */
    public function store(Request $request)
    {
        $request->validate([
            'curp' => 'nullable|unique:empleados,curp',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'nombre' => 'required',
            'num_empleado' => 'required|unique:empleados,num_empleado',
            'puesto' => 'required',
            'dependencia' => 'required',
            'email' => 'required|email|unique:empleados,email',
            'telefono' => 'required'
        ]);

        // Asegurar que la solicitud comience como pendiente
        $data = $request->all();
        $data['solicitud_status'] = 'Pendiente';
        $data['status'] = 'Inactivo';
        
        $empleado = Empleado::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => url('/empleados/confirmacion/' . $empleado->curp)
            ]);
        }

        return view('empleados.confirmacion', compact('empleado'));
    }

    /**
     * Muestra un empleado específico
     */
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    /**
     * Muestra el formulario para editar un empleado
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Actualiza un empleado específico
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'anio_ingreso' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'num_expediente' => 'required|string|max:50',
            'num_empleado' => 'required|string|max:50|unique:empleados,num_empleado,' . $id,
            'puesto' => 'required|string|max:100',
            'adscripcion' => 'required|string|max:100',
            'dependencia' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|string|max:20',
            'datos_biometricos' => 'nullable|file|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('datos_biometricos')) {
            $data['datos_biometricos'] = $request->file('datos_biometricos')->get();
        }

        $empleado->update($data);

        return response()->json([
            'message' => 'Empleado actualizado exitosamente',
            'empleado' => $empleado
        ]);
    }

    /**
     * Elimina un empleado específico
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json([
            'message' => 'Empleado eliminado exitosamente'
        ]);
    }

    /**
     * Cambia el estado de un empleado
     */
    public function cambiarEstado(Empleado $empleado)
    {
        $empleado->status = $empleado->status === 'Activo' ? 'Inactivo' : 'Activo';
        $empleado->save();

        return response()->json([
            'message' => 'Estado del empleado actualizado exitosamente',
            'empleado' => $empleado
        ]);
    }

    /**
     * Exporta los empleados a Excel
     */
    public function exportarExcel()
    {
        $empleados = Empleado::all();
        // Aquí iría la lógica para exportar a Excel
        // Puedes usar paquetes como Maatwebsite/Excel
        return response()->json(['message' => 'Exportación a Excel no implementada']);
    }

    /**
     * Exporta los empleados a PDF
     */
    public function exportarPDF()
    {
        $empleados = Empleado::all();
        // Aquí iría la lógica para exportar a PDF
        // Puedes usar paquetes como barryvdh/laravel-dompdf
        return response()->json(['message' => 'Exportación a PDF no implementada']);
    }

    /**
     * Obtiene los empleados más recientes
     */
    public function recientes()
    {
        try {
            // Verificar conexión a la base de datos primero
            DB::connection()->getPdo();
            
            // Verificar si la tabla existe
            if (!DB::getSchemaBuilder()->hasTable('empleados')) {
                Log::error('La tabla empleados no existe en la base de datos');
                return response()->json([
                    'error' => 'La tabla de empleados no existe',
                    'mensaje' => 'Error de configuración: La tabla empleados no se encuentra en la base de datos. Por favor, ejecute las migraciones.',
                    'data' => [],
                    'total' => 0
                ], 500);
            }
            
            // Intentar obtener los empleados
            $empleados = Empleado::orderBy('updated_at', 'desc')
                                ->paginate(20);
            
            Log::info('Empleados recientes obtenidos correctamente', [
                'total' => $empleados->total(),
                'items' => count($empleados->items())
            ]);
            
            return response()->json([
                'data' => $empleados->items(),
                'total' => $empleados->total()
            ]);
        } catch (\PDOException $e) {
            Log::error('Error de conexión a la base de datos al obtener empleados recientes: ' . $e->getMessage(), [
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Error de conexión a la base de datos',
                'mensaje' => 'No se pudo conectar a la base de datos. Verifique la configuración en el archivo .env',
                'data' => [],
                'total' => 0
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error al obtener empleados recientes: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Error al obtener los empleados recientes',
                'mensaje' => $e->getMessage(),
                'data' => [],
                'total' => 0
            ], 500);
        }
    }

    /**
     * Verifica la disponibilidad de los datos y diagnóstica posibles problemas
     */
    public function checkData()
    {
        try {
            $totalEmpleados = Empleado::count();
            
            return response()->json([
                'success' => true,
                'total_empleados' => $totalEmpleados,
                'hay_datos' => $totalEmpleados > 0
            ]);
        } catch (\Exception $e) {
            Log::error('Error en checkData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 