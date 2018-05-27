<?php
    
    ini_set('session.gc_maxlifetime', 43200);
    session_start();

    require_once __DIR__ . '/vendor/autoload.php';
    include __DIR__  . '/config/config.php';

    $app = new \Newsletter\Core\App();
