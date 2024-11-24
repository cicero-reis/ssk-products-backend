<?php

namespace Catalog\Application\Services\Product;

use Catalog\Application\Services\Product\Interfaces\IProductFileStorageService;
use Catalog\Domain\Interfaces\IProductFileStorageRepository;

class ProductFileStorageService implements IProductFileStorageService
{
    private $productFileStorageRepository;

    public function __construct(IProductFileStorageRepository $productFileStorageRepository)
    {
        $this->productFileStorageRepository = $productFileStorageRepository;
    }

    public function uploadFile(string $path, string $fileContent): string
    {
        return $this->productFileStorageRepository->uploadFile($path, $fileContent);
    }

    public function getFile(int $productId): string
    {
        return $this->productFileStorageRepository->getFile($productId);
    }

    public function deleteFile(string $path): bool
    {
        return $this->productFileStorageRepository->deleteFile($path);
    }
}
