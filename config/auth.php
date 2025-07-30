<?php

return [

    'defaults' => [
        'guard' => 'web', // ✅ CHANGER DE 'dev' VERS 'web'
        'passwords' => null,
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        
        'dev' => [
            'driver' => 'session',
            'provider' => 'devs',
        ],

        'entreprise' => [
            'driver' => 'session',
            'provider' => 'entreprises',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],  

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'devs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Dev::class,
        ],

        'entreprises' => [
            'driver' => 'eloquent',
            'model' => App\Models\Entreprise::class,
        ]
    ],

];