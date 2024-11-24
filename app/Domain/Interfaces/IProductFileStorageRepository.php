<?php

namespace Catalog\Domain\Interfaces;

interface IProductFileStorageRepository
{
    public function uploadFile(string $path, string $fileContent): string;
    public function getFile(int $productId): string;
    public function deleteFile(string $path): bool;
}
