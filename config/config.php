<?php

return [
    'defines' => [
        'URL' => isset($_SERVER['HTTP_HOST']) ? ('http://' . $_SERVER['HTTP_HOST'] . '/') : null
    ],

    'twig' => [
        'dir' => __DIR__ . '/../app/views',
        'cache' => __DIR__ . '/../app/cache'
    ],

    'database' => [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'newsletter'
    ]
];
