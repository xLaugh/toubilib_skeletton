<?php

return [
    'toubiauth' => [
        'host' => 'toubiauth.db',
        'port' => 5432,
        'database' => 'toubiauth',
        'username' => 'toubiauth',
        'password' => 'toubiauth',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    'toubiprat' => [
        'host' => 'toubiprati.db',
        'port' => 5432,
        'database' => 'toubiprat',
        'username' => 'toubiprat',
        'password' => 'toubiprat',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    'toubipat' => [
        'host' => 'toubipat.db',
        'port' => 5432,
        'database' => 'toubipat',
        'username' => 'toubipat',
        'password' => 'toubipat',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    'toubirdv' => [
        'host' => 'toubirdv.db',
        'port' => 5432,
        'database' => 'toubirdv',
        'username' => 'toubirdv',
        'password' => 'toubirdv',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ]
];
