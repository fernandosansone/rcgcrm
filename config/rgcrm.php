<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Modules
    |--------------------------------------------------------------------------
    | Activa o desactiva la visualización en el menú de los módulos.
    |--------------------------------------------------------------------------
    */

    'modules' => [
        // CRM
        'dashboard'     => env('RCGCRM_SHOW_DASHBOARD', true),
        'agenda'        => env('RCGCRM_SHOW_AGENDA', true),
        'contacts'      => env('RCGCRM_SHOW_CONTACTS', true),
        'opportunities' => env('RCGCRM_SHOW_OPPORTUNITIES', true),
        'reports'       => env('RCGCRM_SHOW_REPORTS', true),

        // Administración
        'users'         => env('RCGCRM_SHOW_USERS', true),
        'roles'         => env('RCGCRM_SHOW_ROLES', true),
        'permissions'   => env('RCGCRM_SHOW_PERMISSIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | UI · Badge variants
    |--------------------------------------------------------------------------
    | Clases Tailwind para badges del sidebar y otras vistas.
    | Centraliza colores y estilos visuales.
    |--------------------------------------------------------------------------
    */

    'badge_variants' => [
        'red' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'green' => 'bg-green-50 text-green-700 ring-1 ring-green-200',
        'gray' => 'bg-gray-50 text-gray-700 ring-1 ring-gray-200',
        'default' => 'bg-gray-50 text-gray-700 ring-1 ring-gray-200',
    ],

    /*
    |--------------------------------------------------------------------------
    | Usuarios
    |--------------------------------------------------------------------------
    */

    'default_role' => env('RCGCRM_DEFAULT_ROLE', 'Ejecutivo'),

];
