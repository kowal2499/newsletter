<?php
require_once __DIR__.'/vendor/autoload.php';
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app_config = include(__DIR__ . '/config/config.php');
// Doctrine provider
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/app/Models'], true);
$entityManager = EntityManager::create($app_config['database'], $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

/*
$smModuleArg = false;
foreach ($_SERVER['argv'] as $key => $val) {
    if (preg_match('/--sm-module/', $val)) {
        $smModuleArg = $val;
        unset( $_SERVER['argv'][$key] );
        $_SERVER['argc'] = $_SERVER['argc']-1;
    }
}
if ($smModuleArg) {
    $paths = array(__DIR__ . '/app/' . explode(':', $smModuleArg)[1]);
} else {
    $paths = array(__DIR__ . '/app/');
}
print_r($paths);
$isDevMode = true;
$dbParams = include(__DIR__ . '/config/config.php')['database'];
$config = Setup::createAnnotationMetadataConfiguration(__DIR__ . '/app/models/Users', $isDevMode);
$entityManager = EntityManager::create($dbParams['database'], $config);
return ConsoleRunner::createHelperSet($entityManager);
*/