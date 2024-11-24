<?php

use Catalog\Presentation\Http\Controllers\ProductController;
use Catalog\Presentation\Http\Controllers\ProductFileStorageController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    $app->group(
        '/api',
        function ($app) {

            $app->post('/products/search', ProductController::class . ':index');
            $app->get('/products/{id}', ProductController::class . ':show');
            $app->post('/product', ProductController::class . ':create');
            $app->put('/products/{id}', ProductController::class . ':update');
            $app->delete('/products/{id}', ProductController::class . ':delete');

            $app->post('/products/{productId}/file', ProductFileStorageController::class . ':uploadFile');
            $app->get('/products/{productId}/file', ProductFileStorageController::class . ':getFile');
            $app->delete('/products/{productId}/file', ProductFileStorageController::class . ':deleteFile');
        }
    );

    //Diagrama de sequência
    $app->get(
        '/catalog-sequence',
        function ($request, $response) {
            $path = __DIR__ . '/../../../public/sequence-diagrams/index.html';
            $response->getBody()->write(file_get_contents($path));

            return $response->withHeader('Content-Type', 'text/html');
        }
    );
    $app->get(
        '/catalog-product-sequence',
        function ($request, $response) {
            $path = __DIR__ .
            '/../../../public/sequence-diagrams/catalog-product-sequence.html';
            $response->getBody()->write(file_get_contents($path));

            return $response->withHeader('Content-Type', 'text/html');
        }
    );

    //Swagger UI
    $app->get(
        '/docs',
        function (Request $request, Response $response, $args) {
            $path = __DIR__ . '/../../../public/swagger/index.html';
            $response->getBody()->write(file_get_contents($path));

            return $response->withHeader('Content-Type', 'text/html');
        }
    );

    // File OpenAPI
    $app->get(
        '/docs/openapi.json',
        function (Request $request, Response $response, $args) {
            $path = __DIR__ . '/../../../public/swagger/openapi.json';
            $openapiJson = file_get_contents($path);
            $openapiData = json_decode($openapiJson, true);
            $serverUrl = config('settings.openapi.openapiServerURL');
            $openapiData['servers'][0]['url'] = $serverUrl;
            $modifiedJson = json_encode($openapiData, JSON_PRETTY_PRINT);
            $response->getBody()->write($modifiedJson);
            return $response->withHeader('Content-Type', 'application/json');
        }
    );
};
