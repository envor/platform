<?php

return [
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'connection' => env('PLATFORM_DATABASE_CONNECTION', 'platform_sqlite'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
