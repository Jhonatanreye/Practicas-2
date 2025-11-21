<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Autentificación de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">

    <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/telerik-ui/css/bootstrap-4.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/telerik-ui/css/sonora-ui-2023.css') }}" rel="stylesheet">
    <link href="https://kendo.cdn.telerik.com/2023.3.1114/styles/kendo.bootstrap-v4.min.css" rel="stylesheet">
    <link href="https://kendo.cdn.telerik.com/2023.3.1114/styles/kendo.default-v2.min.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body class=" auth">
    <div id="app" class="app auth-wrapp">
        <div class="auth-pattern"></div>
        <div class="auth-bg auth-bg-scroll" style="background-image: url({{ asset('images/login-bg.jpg') }});">
            <div class="auth-mask"></div>
        </div>
        <div class="auth-content">
            <div class="container-fluid">
                <div class="row g-0">
                    <div class="col-sm-7 auth-border">
                        <div class="auth-info">
                            <header class="mb-5">
                                <div class="row justify-content-center align-items-center m-0 mb-sm-5 mb-md-3">
                                    <div class="col-sm-3 d-none d-sm-inline-block">
                                        <a class="auth-logo logo-1" href="https://www.sonora.gob.mx" title="">
                                            <img src="{{ asset('images/logo-sonora-white.svg') }}" class="" alt="Gobierno del Estado de Sonora">
                                        </a>
                                    </div>
                                    <!-- <div class="col-6 col-sm-3 offset-0 offset-sm-1 ">
                                        <a class="auth-logo logo-2" href="{{ url('/') }}" title="Declaranet Sonora">
                                            <img src="{{ asset('images/logo-white.svg') }}" class="" alt="Declaranet Sonora">
                                        </a>
                                    </div> -->
                                    <div class="col-6 col-sm-3 offset-0 offset-sm-1 ">
                                        <a class="auth-logo logo-3" href="https://om.sonora.gob.mx" title="">
                                            <img src="{{ asset('images/logo-gobierno-digital-white.svg') }}" class="" alt="Subsecretaría de Gobierno Digital">
                                        </a>
                                    </div>
                                </div>
                            </header>
                            <div class="row my-auto justify-content-center mb-0 mb-sm-5 mb-md-3 ">
                                <div class="col-12 col-sm-8 col-md-10 text-center">
                                    <!-- <h1 class="text-uppercase">Declaranet</h1> -->
                                    <h2 class="mb-3">Sistema de Nombramientos</h2>
                                    <p class="">
                                    Plataforma digital para la gestión integral de los nombramientos de los servidores públicos del Gobierno del Estado de Sonora. Este sistema permite registrar, consultar y dar seguimiento a la trayectoria de los funcionarios de manera eficiente y segura
                                    </p>
                                </div>
                            </div>
                            <footer>
                                <div class="auth-footer d-none d-sm-block">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 col-md-10 text-center">
                                            <p class=" text-light-400 mb-0">
                                                Centro de Gobierno, Edificio Hermosillo 2do. piso. Blvd. Paseo Río Sonora y Comonfort. Col. Villa de Seris. C.P. 83280, Hermosillo, Sonora, México.
                                            </p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p class="text-center mt-3">
                                                <a href="javascript:void(0);" class="btn   btn btn-link py-0 px-0 link-white  " title="Aviso de Privacidad" data-bs-toggle="modal" data-bs-target="#termsModal">
                                                    <span class="text"> Aviso de Privacidad</span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="auth-form">
                            <section class="system-messages">
                                <div class="container-fluid">
                                    <div>
                                    </div>
                                </div>
                            </section>
                            <section class="system-error-messages">
                            </section>
                            <h3 class="text-uppercase text-white"><span class="mdi mdi-account-circle-outline"></span> Inicio de Sesión</h3>
                            <form method="POST" action="{{ route('login.submit') }}" id="loginForm" autocomplete="off">
                                @csrf
                                <div class="my-3">
                                    <div class="form-floating outline outline-white">
                                        <input type="text"
                                            class="form-control form-control-lg fs-15px @error('curp') is-invalid @enderror"
                                            placeholder="Ingresa tu CURP" name="curp" value="{{ old('curp') }}" required
                                            autofocus />
                                        <label for="curp">CURP</label>
                                        @error('curp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating outline outline-white">
                                        <input type="password" 
                                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required 
                                               placeholder="Ingresa tu contraseña">
                                        <label for="password">Contraseña</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-5 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label text-white" for="remember">
                                                Recordarme
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-6 text-end">
                                        <a class="link-light" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button type="submit" class="btn btn-white btn-lg shadow-sm rounded-pill">
                                        Iniciar Sesión
                                    </button>
                                </div>
                            </form>
                            <!-- <p class="text-center text-white mt-5 mb-5 mb-sm-0">¿No tienes una cuenta? <a class="link-warning" href="{{ route('empleados.registro') }}" title="registrar">Regístrate</a>
                            </p> -->
                            <div class="d-sm-none w-50 m-auto d-block text-center">
                                <a class="" href="https://www.sonora.gob.mx" title="">
                                    <img src="{{ asset('images/logo-sonora-white.svg') }}" class="" alt="Gobierno del Estado de Sonora">
                                </a>
                                <p class="text-center mt-3">
                                    <a href="javascript:void(0);" class="btn   btn btn-link py-0 px-0 link-white  " title="Aviso de Privacidad" data-bs-toggle="modal" data-bs-target="#termsModal">
                                        <span class="text"> Aviso de Privacidad</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn  btn-circle btn-warning btn-phone  " title="Información de Contacto" data-bs-toggle="modal" data-bs-target="#phoneModal">
                        <span class="mdi mdi-chat-processing-outline"></span> <span class="text"> Información de Contacto</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2023.3.1114/js/kendo.all.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2023.3.1114/js/kendo.aspnetmvc.min.js"></script>
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Inicializar el stepper
            try {
                var stepper = $("#kendoStepper").kendoStepper({
                    linear: true,
                    steps: [{
                        label: "Buscar",
                    }, {
                        label: "Registrar",
                    }, {
                        label: "Validar",
                    }],
                    select: function(e) {
                        let index = e.step.options.index;
                        $('.steps > div').hide();
                        $('.steps > div').eq(index).show();
                    }
                }).data("kendoStepper");

                // Mostrar el primer paso por defecto
                $('.steps > div').hide();
                $('.steps > div:first').show();

                // Manejar el botón de búsqueda
                $('.step-1 button[type="submit"]').click(function(e) {
                    e.preventDefault();
                    // Aquí iría la lógica de búsqueda
                    stepper.next();
                });

                // Manejar el botón de registro
                $('.step-2 button[type="submit"]').click(function(e) {
                    e.preventDefault();
                    // Aquí iría la lógica de registro
                    stepper.next();
                });

                // Resetear el stepper cuando se cierra el modal
                $('#registerModal').on('hidden.bs.modal', function () {
                    stepper.select(0);
                    $('.steps > div').hide();
                    $('.steps > div:first').show();
                });
            } catch (error) {
                console.error('Error al inicializar el stepper:', error);
            }

            // Asegurarse de que el modal se abra correctamente
            $('[data-bs-toggle="modal"]').on('click', function(e) {
                e.preventDefault();
                var targetModal = $(this).data('bs-target');
                var modal = new bootstrap.Modal(document.querySelector(targetModal));
                modal.show();
            });
        });
    </script>

    <script>
        const elem = document.querySelector(".alert-test-1");
        elem.addEventListener("click", () => {

            Swal.fire({
                title: 'Correcto!',
                text: 'Deseas continuar',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Si',
                enyButtonText: "Cancelar"
            });
        });


        const elem2 = document.querySelector(".alert-test-2");
        elem2.addEventListener("click", () => {

            Swal.fire({
                title: 'Error!',
                text: 'Ocurrio un error',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: "Cancelar"
            });

        });


        const elem3 = document.querySelector(".alert-test-3");
        elem3.addEventListener("click", () => {

            Swal.fire({
                title: 'Advertencia!',
                text: 'Esta seguro de continuar',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: "Cancelar"
            });

        });

        const elem4 = document.querySelector(".alert-test-4");
        elem4.addEventListener("click", () => {

            Swal.fire({
                title: 'Confirmar!',
                text: 'Esta seguro de continuar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: "Cancelar"
            });

        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Aviso Importante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="sppb-addon-content">
                        <p style="text-align: justify;"><strong data-uw-styling-context="true">Todas y Todos los Servidores Públicos Presentarán</strong></p>
                        <p style="text-align: justify;"><strong data-uw-styling-context="true">Declaración Patrimonial de Modificación 2021</strong></p>
                        <div style="text-align: justify;">
                            <p data-uw-styling-context="true">Atención servidores públicos, del 01 de mayo al 30 de Septiembre de 2021 debes actualizar&nbsp;tu declaración patrimonial.</p>
                            <p><strong data-uw-styling-context="true">Se te recuerda:</strong></p>
                            <div id=":mb" class="a3s aiL">
                                <div dir="ltr">
                                    <ul>
                                        <li data-uw-styling-context="true"><strong data-uw-styling-context="true">¿Quiénes presentan declaración INICIAL?</strong><br> Dentro de los 60 días naturales siguientes a la toma de posesión con motivo:
                                            <ul>
                                                <li data-uw-styling-context="true">Ingreso al servicio público por primera vez.</li>
                                                <li data-uw-styling-context="true">Reingreso al servicio público después de 60 días naturales de la conclusión de su último encargo.</li>
                                            </ul>
                                        </li>
                                        <li data-uw-styling-context="true"><strong data-uw-styling-context="true">¿Quiénes presentan declaración de MODIFICACIÓN 2021?</strong><br> Todos los servidores públicos durante el mes de mayo de cada año, siempre y cuando hayan laborado al menos un día del año inmediato anterior (2020).</li>
                                    </ul>
                                    <ul>
                                        <li data-uw-styling-context="true"><strong data-uw-styling-context="true">¿Quiénes presentan declaración de CONCLUSIÓN?<br></strong>Quienes concluyan con su encargo, dentro de los 60 días naturales siguientes a la conclusión.</li>
                                    </ul>
                                    <ul>
                                        <li data-uw-styling-context="true"><strong data-uw-styling-context="true">¿Quiénes darán AVISO?<br></strong>Quienes cambien de Dependencia o Entidad en el mismo orden de Gobierno dentro de los 60 días naturales posteriores a la fecha de toma de posesión del nuevo encargo, y no será necesario presentar declaración Inicial ni la de Conclusión.</li>
                                    </ul>
                                </div>
                            </div>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Todos los servidores públicos en el ámbito federal estatal y municipal deberán rendir declaración de situación patrimonial y de intereses bajo protesta de decir verdad, de conformidad con el artículo 108 de la Constitución General, 143 de la Constitución Política del Estado Libre y Soberano de Sonora, en relación con 33 y 47 de la Ley Estatal de Responsabilidades, y conforme a los acuerdos emitidos por el Comité Coordinador del Sistema Nacional Anticorrupción y publicados en el Diario Oficial el 23 de Septiembre de 2019 y 24 de diciembre del 2019.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Conforme al artículo 34 fracción II de la Ley Estatal de Responsabilidades la declaración de modificación patrimonial se presenta durante el mes de mayo de cada año.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Liga para ingresar al sistema todos los servidores públicos estatales es <a href="https://declaranet.sonora.gob.mx"></a><a href="https://declaranet.sonora.gob.mx" data-uw-styling-context="true">https://declaranet.sonora.gob.mx</a> .</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Los declarantes que ya presentaban declaración en el sistema Declaranet Sonora ingresarán de la misma forma utilizando su RFC y su contraseña. Sin embargo una vez que ingresen al sistema y empiecen con el llenado en el apartado de Datos Generales y capturen su RFC y su homoclave, el sistema de manera automática una vez que deseen reingresar para continuar con el llenado de su declaración, lo deberán hacer con su RFC con homoclave y su contraseña.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Los declarantes que presenten declaración por primera vez deberán registrarse desde un inicio con su RFC con homoclave y ellos mismos generarán su contraseña (con las características indicadas en el propio sistema).</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Todos los servidores públicos que ya presentaban declaración patrimonial, como los que presentarán por primera vez la realizarán en el formato de Modificación 2021.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">El período a declarar para todos los servidores públicos en la declaración de situación patrimonial y de intereses de modificación 2021, es el año inmediato anterior <strong data-uw-styling-context="true">es decir del 01 de enero al 31 de diciembre del 2020.</strong></li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1"><strong data-uw-styling-context="true">Declaración de modificación en el formato completo, si el nivel jerárquico es igual o mayor a jefe de departamento u homólogos, o bien su sueldo tabular mensual es igual o mayor a $19,330.96.</strong></li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1"><strong data-uw-styling-context="true">Declaración simplificada, si el nivel jerárquico es menor al jefe de departamento (operativos), o bien su sueldo tabular mensual es igual o menor a $19,330.95.</strong></li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">El sueldo tabular a considerarse en dichos rangos es el autorizado para el ejercicio fiscal 2020.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">No presentarán declaración de modificación, los servidores públicos que tomen posesión del empleo, cargo o comisión durante los primeros cinco meses del año y presenten su declaración patrimonial de inicio. Así mismo no presentarán declaración de modificación aquellos servidores públicos que concluyan su empleo, cargo o comisión en el mes de mayo y hubieren cumplido con la presentación de su declaración de conclusión en el mismo mes.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Todo el personal docente y del sector salud que se encuentren en el organigrama estatal, con independencia de que su pago se cubra con partida federal (ejemplo FONE), presentarán su declaración de situación patrimonial en el sistema Declaranet Sonora.</li>
                            </ul>
                            <ul>
                                <li data-mce-word-list="1" data-uw-styling-context="true">Personal contratado por honorarios, con cargo a la partida de sueldos deberán presentar declaración de situación patrimonial.</li>
                            </ul>
                            <strong data-uw-styling-context="true">Atentamente:</strong>
                        </div>
                        <div style="text-align: justify;">&nbsp;</div>
                        <p style="text-align: justify;" data-uw-styling-context="true">Coordinación Ejecutiva de Sustanciación y Resolución de Responsabilidades y Situación Patrimonial</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro de Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 w-sm-75 mx-auto my-3">
                        <h2 class="text-tertiary text-uppercase fw-700 text-center mb-3">
                            Registro de Empleado
                        </h2>
                        <p class="text-center fs-5 mb-0">
                            Por favor complete todos los campos requeridos para registrar su solicitud.
                        </p>
                    </div>

                    <form id="registerForm" class="w-90 w-sm-50 mx-auto" novalidate autocomplete="off">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="text-dark fw-700 mb-3 fs-5">Datos Generales</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <span class="text-danger">Campos obligatorios *</span>
                            </div>
                        </div>

                        <div class="card card-body p-5">
                            <div class="row g-4">
                                <div class="col-sm-12">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="curp" 
                                               name="curp" 
                                               required 
                                               pattern="[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]"
                                               style="text-transform: uppercase;"
                                               placeholder="Clave Única de Registro de Población">
                                        <label for="curp">Clave Única de Registro de Población (CURP) <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="apellido_paterno" 
                                               name="apellido_paterno" 
                                               required
                                               placeholder="Primer apellido">
                                        <label for="apellido_paterno">Primer apellido <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="apellido_materno" 
                                               name="apellido_materno" 
                                               required
                                               placeholder="Segundo apellido">
                                        <label for="apellido_materno">Segundo apellido <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="nombre" 
                                               name="nombre" 
                                               required
                                               placeholder="Nombre(s)">
                                        <label for="nombre">Nombre(s) <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-8">
                                <h3 class="text-dark fw-700 mb-3 fs-5">Datos Laborales</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <span class="text-danger">Campos obligatorios *</span>
                            </div>
                        </div>

                        <div class="card card-body p-5">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="num_empleado" 
                                               name="num_empleado" 
                                               required
                                               placeholder="Número de Empleado">
                                        <label for="num_empleado">Número de Empleado <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="puesto" 
                                               name="puesto" 
                                               required
                                               placeholder="Puesto">
                                        <label for="puesto">Puesto <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-floating outline">
                                        <input type="text" 
                                               class="form-control form-control-lg" 
                                               id="dependencia" 
                                               name="dependencia" 
                                               required
                                               placeholder="Dependencia">
                                        <label for="dependencia">Dependencia <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-8">
                                <h3 class="text-dark fw-700 mb-3 fs-5">Datos de Contacto</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <span class="text-danger">Campos obligatorios *</span>
                            </div>
                        </div>

                        <div class="card card-body p-5">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-floating outline">
                                        <input type="email" 
                                               class="form-control form-control-lg" 
                                               id="email" 
                                               name="email" 
                                               required
                                               placeholder="Correo electrónico">
                                        <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-floating outline">
                                        <input type="tel" 
                                               class="form-control form-control-lg" 
                                               id="telefono" 
                                               name="telefono" 
                                               required
                                               placeholder="Teléfono">
                                        <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <span>Cancelar</span>
                            </button>
                            <button type="submit" class="btn btn-success">
                                <span>Enviar Solicitud</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Manejar el formulario de registro
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                
                // Validar CURP
                const curp = $('#curp').val();
                if (!validateCURP(curp)) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor ingrese un CURP válido',
                        icon: 'error'
                    });
                    return;
                }
                
                // Enviar solicitud
                $.ajax({
                    url: '/api/empleados/solicitud',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: '¡Solicitud Enviada!',
                            text: 'Tu solicitud de registro ha sido enviada correctamente. Te notificaremos cuando sea aprobada.',
                            icon: 'success'
                        }).then(() => {
                            $('#registerModal').modal('hide');
                            $('#registerForm')[0].reset();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al enviar la solicitud: ' + (xhr.responseJSON?.message || 'Error desconocido'),
                            icon: 'error'
                        });
                    }
                });
            });

            // Función para validar CURP
            function validateCURP(curp) {
                const regex = /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]$/;
                return regex.test(curp);
            }

            // Resetear el formulario cuando se cierra el modal
            $('#registerModal').on('hidden.bs.modal', function () {
                $('#registerForm')[0].reset();
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="phoneModalLabel">Teléfonos de Atención</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Atención Servidores Públicos</strong></p>
                    <p>A fin de poder asesorarte sobre la presentación de tu declaración patrimonial y de intereses, la Secretaría de la Contrarloría General a través de la Coordinación Ejecutiva de Sustanciación y Resolución de Responsabilidades y Situación Patrimonial
                        pone a su servicio de lunes a viernes de 08:00 a 16:00 horas los siguientes canales de atención:</p>

                    <div class="row">
                        <div class="col-sm-6">
                            <p>Los números teléfonicos</p>
                            <ul class="list-group">
                                <li class="list-group-item"><span class="mdi mdi-phone"></span> 662 2172168</li>
                                <li class="list-group-item"><span class="mdi mdi-phone"></span> 662 2136207</li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <p>En las siguientes extensiones:</p>
                            <ul class="list-group">
                                <li class="list-group-item">1299, 1297, 1300, 1301, 1303, 1304, 1305, 1306, 1328, 1330.</li>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Removed AJAX login submission to use standard form submission
        });
    </script>
</body>
</html>
