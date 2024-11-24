<?php

namespace Catalog\Core;

use Catalog\Error\Whoops;
use Catalog\Infrastructure\DatabaseConnectionFactory;
use Catalog\Presentation\Http\Middlewares\AuthenticationMiddleware;
use Catalog\Presentation\Http\Middlewares\CorsMiddleware;

class AppInitializer
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function run()
    {
        // Registra o Whoops para tratamento de erros
        $this->registerErrorHandlers();
        // Registra os middlewares
        $this->registerMiddleware();
        // Registra a conexão com o banco de dados
        $this->registerDatabase();
        // Registra as rotas
        $this->registerRoutes();
    }

    /**
     * Registra os middlewares
     *
     * @return void
     */
    private function registerMiddleware()
    {
        $this->app->add(new CorsMiddleware());
        $this->app->add(new AuthenticationMiddleware());
    }

    /**
     * Registra as rotas
     *
     * @return void
     */
    private function registerRoutes()
    {
        $routes = include __DIR__ . '/../Presentation/Routes/routes.php';
        $routes($this->app);
    }

    /**
     * Registra o Whoops para tratamento de erros
     *
     * @return void
     */
    private function registerErrorHandlers()
    {
        $errorHandler = new Whoops($this->app);
        $errorHandler->run();
    }

    /**
     * Registra a conexão com o banco de dados
     *
     * @return void
     */
    private function registerDatabase()
    {
        (new DatabaseConnectionFactory())->connect($this->app);
    }
}
