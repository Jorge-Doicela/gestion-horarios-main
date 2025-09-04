<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de tu aplicación, se usará cuando el framework
    | necesite mostrar el nombre en notificaciones u otros elementos de UI.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor determina el "entorno" en el que se ejecuta la aplicación.
    | Se configura en tu archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo Debug
    |--------------------------------------------------------------------------
    |
    | Cuando la aplicación está en modo debug, se muestran mensajes detallados
    | de error con trace. Si está deshabilitado, se mostrará una página genérica.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Esta URL se usa en Artisan y generación de URLs. Configúrala al dominio
    | raíz de tu aplicación.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona Horaria
    |--------------------------------------------------------------------------
    |
    | Especifica la zona horaria por defecto para tu aplicación.
    | Ejemplo: 'America/Guayaquil' para Ecuador.
    |
    */

    'timezone' => 'America/Guayaquil',

    /*
    |--------------------------------------------------------------------------
    | Configuración de Idioma
    |--------------------------------------------------------------------------
    |
    | El locale determina el idioma por defecto que usará Laravel para
    | traducciones. Aquí se pone 'es' para español.
    |
    */

    'locale' => env('APP_LOCALE', 'es'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'es'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'es_ES'),

    /*
    |--------------------------------------------------------------------------
    | Clave de Encriptación
    |--------------------------------------------------------------------------
    |
    | Esta clave es usada por los servicios de encriptación de Laravel y debe
    | ser de 32 caracteres aleatorios.
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Modo Mantenimiento
    |--------------------------------------------------------------------------
    |
    | Configura el driver para controlar el modo mantenimiento de Laravel.
    | Drivers soportados: "file", "cache".
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
