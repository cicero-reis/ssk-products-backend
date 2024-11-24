<?php

return [
    'app' => [
        'timezone' => 'America/Sao_Paulo',
        'displayErrorDetails' => env('DISPLAY_ERROR_DETAILS', true),
    ],
    'logging' => [
        'logErrorDetails' => env('LOG_ERROR_DETAILS', true),
        'logErrors' => env('LOG_ERRORS', true),
    ],
    'openapi' => [
        'openapiServerURL' => env('OPENAPI_SERVER_URL', 'http://localhost:5000/api'),
    ],
];
