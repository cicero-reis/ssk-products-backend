<?php

namespace Catalog\Application\Services\Product\Interfaces;

interface IProductFileStorageService
{
    public function uploadFile(string $path, string $fileContent): string;
    public function getFile(int $productId): string;
    public function deleteFile(string $path): bool;
}
