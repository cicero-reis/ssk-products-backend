<?php

namespace Catalog\Presentation\Http\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

class CorsMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        // Adicionando cabeçalhos CORS à resposta
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')
            ->withHeader('Access-Control-Allow-Headers', 'Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');

        // Para requisições OPTIONS, retornar JSON
        if ($request->getMethod() === 'OPTIONS') {
            $jsonResponse = [
                'message' => 'CORS preflight response',
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                'allowed_headers' => ['X-Requested-With', 'Content-Type', 'Accept', 'Origin', 'Authorization'],
            ];

            $response = new SlimResponse();
            $response->getBody()->write(json_encode($jsonResponse));

            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(200); // OK
        }

        // Certifique-se de definir o cabeçalho Content-Type para JSON na resposta
        if ($response->getHeaderLine('Content-Type') === '') {
            $response = $response->withHeader('Content-Type', 'application/json');
        }

        return $response;
    }
}
