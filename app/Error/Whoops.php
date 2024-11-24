<?php

namespace Catalog\Error;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Monolog\Logger;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Whoops
{
    private $app;
    private $whoops;
    private $logger;

    public function __construct($app)
    {
        $this->app = $app;
        $this->whoops = new Run();
        $this->logger = new Logger('app_logger');

        $this->logger->pushHandler(
            new RotatingFileHandler(
                '/var/www/storage/logs/log.log',
                7,
                Level::Debug,
                true
            )
        );
    }

    /**
     * Registra os manipuladores de erro
     *
     * @return void
     */
    private function registerErrorHandlers()
    {
        $this->whoops->pushHandler(new PrettyPageHandler());

        $this->whoops->pushHandler(
            function ($exception, $inspector, $run) {

                $errorMessage = $exception->getMessage();
                $stackTrace = $exception->getTraceAsString();

                // Registrando a mensagem e a stack trace no log
                $this->logger->error(
                    "Erro: {$errorMessage}\nStack Trace:\n{$stackTrace}"
                );
            }
        );

        $this->whoops->register();
    }

    /**
     * Executa o tratamento de erros
     *
     * @return void
     */
    public function run()
    {
        $this->registerErrorHandlers();
    }
}
