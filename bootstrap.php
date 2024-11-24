<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Utils/helpers.php';

use Catalog\Core\AppInitializer;
use Catalog\IoC\DependencyInjection;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

$dotenv = Dotenv::createImmutable('/var/www');
$dotenv->load();

date_default_timezone_set(config('settings.app.timezone'));

$container = DependencyInjection::buildContainer();
AppFactory::setContainer($container);

$app = AppFactory::create();

try {
    $appInitializer = new AppInitializer($app);
    $appInitializer->run();
} catch (Exception $e) {
    echo 'Erro ao incializar a aplicação: ' . $e->getMessage();
}

return $app;
