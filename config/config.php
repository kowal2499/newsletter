<?php

return [
    'defines' => [
        'URL' => isset($_SERVER['HTTP_HOST']) ? ('http://' . $_SERVER['HTTP_HOST'] . '/') : null,
        'DS' => DIRECTORY_SEPARATOR,
        'SALT' => 'TsyZj!QFFaF6+GD|-+NDQ!F>#Zk+$jHQ-X;v.e9P=%7+BZxG[hUudQX>S]O#%4+c'
    ],

    'twig' => [
        'dir' => __DIR__ . '/../app/views',
        'cache' => __DIR__ . '/../app/cache',
        'manifest' => __DIR__ . '/../dist/rev-manifest.json',
        'assetsDir' => '/dist/'
    ],

    'database' => [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'newsletter'
    ]
];
