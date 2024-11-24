<?php

namespace Catalog\Presentation\Http\Controllers;

use Catalog\Application\DTOs\ProductUpdateDTO;
use Catalog\Application\Services\Product\Interfaces\IProductFileStorageService;
use Catalog\Application\Services\Product\Interfaces\IProductService;
use Catalog\Exception\MensagemDetails;
use Catalog\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductFileStorageController
{
    private $productFileStorageService;
    private $productService;

    public function __construct(IProductFileStorageService $productFileStorageService, IProductService $productService)
    {
        $this->productFileStorageService = $productFileStorageService;
        $this->productService = $productService;
    }

    public function uploadFile(Request $request, Response $response, array $args): Response
    {
        try {
            $productId = intval($args['productId']);
            $uploadedFile = $request->getUploadedFiles()['file'] ?? null;

            if (!$uploadedFile || $productId < 1) {
                throw new NotFoundException('Invalid file or productId');
            }

            $fileName = $uploadedFile->getClientFilename();
            $fileExtencion = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $filesize = $uploadedFile->getSize();
            $maxFileSize = 200 * 1024; // 200KB

            if ($filesize > $maxFileSize) {
                throw new NotFoundException('File size exceeds the limit of 200KB');
            }

            $fileName = sanitizeFileName($fileName);

            $fileContent = file_get_contents($uploadedFile->getFilePath());

            $path = $productId . '/' . $fileName . '.' . $fileExtencion;

            $url = $this->productFileStorageService->uploadFile($path, $fileContent);

            $product = $this->productService->find($productId);

            $productUpdateDTO = new ProductUpdateDTO(
                (string) $product[0]->id,
                $product[0]->name,
                $product[0]->description,
                $product[0]->price,
                (string) $product[0]->quantity,
                $product[0]->category_id,
                $product[0]->image = $path
            );

            $this->productService->update($productId, $productUpdateDTO);

            $response->getBody()->write(json_encode(['url' => $url]));

            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'No content', $e->getMessage());
            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));

            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }


    public function getFile(Request $request, Response $response, $args)
    {
        try {
            $productId = $args['productId'];

            $url = (string) $this->productFileStorageService->getFile($productId);

            $response->getBody()->write(json_encode(['url' => $url]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'No content', $e->getMessage());

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (\Exception $e) {
            return $response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteFile(Request $request, Response $response, string $path): bool
    {
        try {
            return $this->productFileStorageService->deleteFile($path);
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'No content', $e->getMessage());

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (\Exception $e) {
            return $response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
