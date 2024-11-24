<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/migrations.php';

use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;

// Bootstrap o aplicativo, que inclui a inicialização da conexão com o banco
$app = require_once __DIR__ . '/../init.php';

// Recupera o Capsule já configurado no App
$capsule = $app->getContainer()->get('db');

// Instanciar FileSystem e Repositório de Migrações
$filesystem = new Filesystem();
$repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');

// Criar o objeto Migrator para gerenciar as migrações
$migrator = new Migrator($repository, $capsule->getDatabaseManager(), $filesystem);

// Verificar se o repositório de migrações existe, caso contrário, criá-lo
if (!$repository->repositoryExists()) {
    $repository->createRepository();
}

// Processar os argumentos passados via linha de comando
if ($argc > 1) {
    switch ($argv[1]) {
        case 'migrate':
            runMigrations($migrator);
            break;
        case 'rollback':
            rollbackMigrations($migrator);
            break;
        case 'reset':
            resetMigrations($migrator);
            break;
        case 'refresh':
            refreshMigrations($migrator);
            break;
        case 'status':
            checkMigrations($migrator);
            break;
        default:
            echo 'Invalid command. Use migrate, rollback, reset, refresh, or status.' . PHP_EOL;
            break;
    }
} else {
    echo 'Invalid command. Use migrate, rollback, reset, refresh, or status.' . PHP_EOL;
}

// Rodar as migrações
// try {
//     $migrator->run(__DIR__ . '/../database/migrations');
//     echo 'Migrações executadas com sucesso.' . PHP_EOL;
// } catch (Exception $e) {
//     echo 'Erro ao executar as migrações: ' . $e->getMessage() . PHP_EOL;
// }
