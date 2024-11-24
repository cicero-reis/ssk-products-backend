<?php

namespace Catalog\Infrastructure;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseConnectionFactory
{
    /**
     * Método connect
     *
     * Este método é responsável por criar a conexão com o banco de dados.
     *
     * @param \Slim\App $app A instância da aplicação Slim.
     *
     * @return void
     */
    public function connect($app)
    {
        $capsule = new Capsule();

        $capsule->addConnection(
            [
                'driver' => config('database.connections.mysql.driver'),
                'host' => config('database.connections.mysql.host'),
                'database' => config('database.connections.mysql.database'),
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
                'charset' => config('database.connections.mysql.charset'),
                'collation' => config('database.connections.mysql.collation'),
                'prefix' => config('database.connections.mysql.prefix'),
            ]
        );

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        try {
            $capsule->getConnection()->getPdo();
        } catch (\Exception $e) {
            die('Não foi possível conectar ao banco de dados.');
        }
        
        $app->getContainer()->set('db', $capsule);
    }
}
