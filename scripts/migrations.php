<?php

function runMigrations($migrator)
{
    try {
        $migrator->run(__DIR__ . '/../database/migrations');
        echo 'Migrações executadas com sucesso.' . PHP_EOL;
    } catch (Exception $e) {
        echo 'Erro ao executar as migrações: ' . $e->getMessage() . PHP_EOL;
    }
}

function rollbackMigrations($migrator)
{
    try {
        $migrator->rollback(__DIR__ . '/../database/migrations');
        echo 'Migrações revertidas com sucesso.' . PHP_EOL;
    } catch (Exception $e) {
        echo 'Erro ao reverter as migrações: ' . $e->getMessage() . PHP_EOL;
    }
}

function resetMigrations($migrator)
{
    try {
        $migrator->reset(__DIR__ . '/../database/migrations');
        echo 'Migrações resetadas com sucesso.' . PHP_EOL;
    } catch (Exception $e) {
        echo 'Erro ao resetar as migrações: ' . $e->getMessage() . PHP_EOL;
    }
}

function refreshMigrations($migrator)
{
    try {
        $migrator->refresh(__DIR__ . '/../database/migrations');
        echo 'Migrações atualizadas com sucesso.' . PHP_EOL;
    } catch (Exception $e) {
        echo 'Erro ao atualizar as migrações: ' . $e->getMessage() . PHP_EOL;
    }
}

function checkMigrations($migrator)
{
    try {
        $migrations = $migrator->getMigrationRepository()->getRan();
        echo 'Migrações aplicadas: ' . implode(', ', $migrations) . PHP_EOL;
    } catch (Exception $e) {
        echo 'Erro ao verificar status das migrações: ' . $e->getMessage() . PHP_EOL;
    }
}