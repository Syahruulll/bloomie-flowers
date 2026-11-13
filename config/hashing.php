<?php

return [
    'driver' => env('HASH_DRIVER', 'bcrypt'),

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
        // The current database contains valid legacy $2a$ bcrypt hashes.
        // PHP can verify them, but reports their algorithm as "unknown".
        'verify' => env('HASH_VERIFY', false),
        'limit' => env('BCRYPT_LIMIT'),
    ],

    'argon' => [
        'memory' => env('ARGON_MEMORY', 65536),
        'threads' => env('ARGON_THREADS', 1),
        'time' => env('ARGON_TIME', 4),
        'verify' => env('HASH_VERIFY', true),
    ],

    'rehash_on_login' => true,
];
