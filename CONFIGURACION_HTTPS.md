# Configuración de HTTPS para el Sistema

Este documento explica cómo configurar HTTPS para eliminar la advertencia de "conexión no segura" en el navegador.

## Cambios Realizados

Se han realizado los siguientes cambios en el código para soportar HTTPS:

1. **AppServiceProvider**: Configurado para forzar HTTPS en producción
2. **TrustProxies**: Actualizado para confiar en proxies (necesario si está detrás de un load balancer)
3. **.htaccess**: Agregada opción para redirigir HTTP a HTTPS (comentada por defecto)

## Pasos para Configurar HTTPS

### 1. Obtener un Certificado SSL

Tienes varias opciones:

#### Opción A: Let's Encrypt (Gratuito y Recomendado)
```bash
# Instalar Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-apache

# Obtener certificado para Apache
sudo certbot --apache -d tudominio.com -d www.tudominio.com

# Obtener certificado para Nginx
sudo certbot --nginx -d tudominio.com -d www.tudominio.com
```

#### Opción B: Certificado Comercial
- Comprar un certificado SSL de un proveedor comercial
- Instalarlo según las instrucciones del proveedor

### 2. Configurar el Archivo .env

Edita el archivo `.env` en el servidor y asegúrate de tener estas configuraciones:

```env
APP_ENV=production
APP_URL=https://tudominio.com
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

**Importante**: 
- Cambia `tudominio.com` por tu dominio real
- Asegúrate de que `APP_URL` use `https://` no `http://`

### 3. Activar la Redirección HTTP a HTTPS

Una vez que tengas el certificado SSL instalado, edita el archivo `public/.htaccess` y descomenta estas líneas:

```apache
# Descomentar estas líneas:
RewriteCond %{HTTPS} off
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 4. Configurar Cookies Seguras

En el archivo `.env`, asegúrate de tener:

```env
SESSION_SECURE_COOKIE=true
```

Esto asegura que las cookies de sesión solo se envíen a través de conexiones HTTPS.

### 5. Limpiar la Caché

Después de hacer los cambios, ejecuta estos comandos:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 6. Verificar la Configuración

1. Accede a tu sitio usando `https://tudominio.com`
2. Verifica que no aparezca la advertencia de conexión no segura
3. Verifica que el candado verde aparezca en la barra de direcciones del navegador

## Si Estás Detrás de un Load Balancer o Proxy

Si tu aplicación está detrás de un load balancer (como AWS ELB, Cloudflare, etc.), el middleware `TrustProxies` ya está configurado para confiar en todos los proxies. Esto es necesario para que Laravel detecte correctamente las conexiones HTTPS.

## Solución de Problemas

### El sitio sigue mostrando la advertencia

1. Verifica que el certificado SSL esté instalado correctamente
2. Verifica que `APP_URL` en `.env` use `https://`
3. Verifica que `FORCE_HTTPS=true` en `.env`
4. Limpia la caché de Laravel
5. Verifica que el servidor web (Apache/Nginx) esté configurado para usar HTTPS

### Error 500 después de activar HTTPS

1. Verifica los logs de Laravel: `storage/logs/laravel.log`
2. Verifica que el certificado SSL sea válido
3. Verifica que el servidor web esté configurado correctamente
4. Si estás detrás de un proxy, asegúrate de que `TrustProxies` esté configurado

### Las cookies no funcionan

1. Verifica que `SESSION_SECURE_COOKIE=true` en `.env`
2. Limpia las cookies del navegador
3. Verifica que la sesión esté configurada correctamente en `config/session.php`

## Notas Importantes

- **No actives HTTPS sin tener un certificado SSL instalado**, ya que esto causará errores
- Si estás en desarrollo local, puedes usar `APP_ENV=local` y `FORCE_HTTPS=false`
- En producción, siempre usa HTTPS para proteger los datos de los usuarios
- Los certificados Let's Encrypt expiran cada 90 días, configúralos para renovarse automáticamente

## Renovación Automática de Certificados Let's Encrypt

Para configurar la renovación automática:

```bash
# Probar la renovación
sudo certbot renew --dry-run

# El certificado se renovará automáticamente si está configurado con systemd timer
# Verificar el timer
sudo systemctl status certbot.timer
```

