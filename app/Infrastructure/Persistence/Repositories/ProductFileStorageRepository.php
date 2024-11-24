<?php

namespace Catalog\Infrastructure\Persistence\Repositories;

use Aws\S3\S3Client;
use Catalog\Domain\Interfaces\IProductFileStorageRepository;
use Illuminate\Database\Capsule\Manager as DB;

class ProductFileStorageRepository implements IProductFileStorageRepository
{
    private $s3Client;
    private $bucketName;

    public function __construct(S3Client $s3Client, string $bucketName)
    {
        $this->s3Client = $s3Client;
        $this->bucketName = $bucketName;
    }

    public function uploadFile(string $path, string $fileContent): string
    {
        $this->s3Client->putObject(
            [
            'Bucket' => $this->bucketName,
            'Key' => $path,
            'Body' => $fileContent,
            'ACL' => 'public-read',
            ]
        );

        return $this->s3Client->getObjectUrl($this->bucketName, $path);
    }


    public function getFile(int $productId): string
    {
        $product = DB::table('product')
            ->where('id', $productId)
            ->where('deleted_at', null)
            ->first();

        return sprintf('%s/%s/%s', config('filesystems.s3.endpoint'), $this->bucketName, $product->image);
    }

    public function deleteFile(string $path): bool
    {
        $this->s3Client->deleteObject(
            [
            'Bucket' => $this->bucketName,
            'Key' => $path,
            ]
        );

        return true;
    }
}
