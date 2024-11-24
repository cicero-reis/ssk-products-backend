<?php

return [
    's3' => [
        'driver' => 's3',
        'endpoint' => env('AWS_ENDPOINT', 'http://localhost:4566'),
        'use_path_style_endpoint' => true,
        'key' => env('AWS_ACCESS_KEY_ID', 'test'),  // Use 'test' para o LocalStack
        'secret' => env('AWS_SECRET_ACCESS_KEY', 'test'),  // Use 'test' para o LocalStack
        'region' => env('AWS_REGION', 'us-east-1'),
        'bucket' => env('FILESYSTEM_S3_BUCKET', 'catalogapibucket'),
    ],
];
