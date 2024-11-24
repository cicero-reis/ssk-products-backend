<?php

namespace Catalog\IoC;

use Aws\S3\S3Client;
use Catalog\Application\Services\Product\Interfaces\IProductFileStorageService;
use Catalog\Application\Services\Product\Interfaces\IProductService;
use Catalog\Application\Services\Product\ProductFileStorageService;
use Catalog\Application\Services\Product\ProductService;
use Catalog\Domain\Interfaces\IProductFileStorageRepository;
use Catalog\Domain\Interfaces\IProductFilterBuilder;
use Catalog\Domain\Interfaces\IProductRepository;
use Catalog\Infrastructure\Filters\ProductFilterBuilder;
use Catalog\Infrastructure\Persistence\Repositories\ProductFileStorageRepository;
use Catalog\Infrastructure\Persistence\Repositories\ProductRepository;
use Catalog\Presentation\Http\Controllers\ProductController;
use Catalog\Presentation\Http\Controllers\ProductFileStorageController;
use DI\Container;

class DependencyInjection
{
    public static function buildContainer()
    {
        $container = new Container();

        $container->set(
            IProductFilterBuilder::class,
            function () {
                return new ProductFilterBuilder();
            }
        );

        $container->set(
            IProductRepository::class,
            function (Container $container) {
                return new ProductRepository(
                    $container->get(IProductFilterBuilder::class)
                );
            }
        );

        $container->set(
            IProductFileStorageRepository::class,
            function (Container $container) {
                return new ProductFileStorageRepository(
                    $container->get('s3Client'),
                    $container->get('bucketName')
                );
            }
        );

        $container->set(
            IProductService::class,
            function (Container $container) {
                return new ProductService(
                    $container->get(IProductRepository::class)
                );
            }
        );

        $container->set(
            IProductFileStorageService::class,
            function (Container $container) {
                return new ProductFileStorageService(
                    $container->get(IProductFileStorageRepository::class)
                );
            }
        );

        $container->set(
            ProductController::class,
            function (Container $container) {
                return new ProductController(
                    $container->get(IProductService::class)
                );
            }
        );

        $container->set(
            ProductFileStorageController::class,
            function (Container $container) {
                return new ProductFileStorageController(
                    $container->get(IProductFileStorageService::class),
                    $container->get(IProductService::class)
                );
            }
        );

        $container->set(
            's3Client',
            function () {
                return new S3Client(
                    [
                    'version' => 'latest',
                    'region' => config('filesystems.s3.region'),
                    'endpoint' => config('filesystems.s3.endpoint'),
                    'use_path_style_endpoint' => true,
                    'credentials' => [
                    'key' => config('filesystems.s3.key'),
                    'secret' => config('filesystems.s3.secret'),
                    ],
                    ]
                );
            }
        );

        $container->set(
            IProductFileStorageRepository::class,
            function (Container $container) {
                return new ProductFileStorageRepository(
                    $container->get('s3Client'),
                    config('filesystems.s3.bucket')
                );
            }
        );

        return $container;
    }
}
