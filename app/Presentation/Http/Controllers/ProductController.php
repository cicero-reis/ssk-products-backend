<?php

namespace Catalog\Presentation\Http\Controllers;

use Catalog\Application\DTOs\ProductCreateDTO;
use Catalog\Application\DTOs\ProductUpdateDTO;
use Catalog\Application\Services\Product\Interfaces\IProductService;
use Catalog\Exception\MensagemDetails;
use Catalog\Exception\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController
{
    private $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request, Response $response)
    {
        try {
            $bodyContent = $request->getBody()->getContents();

            $body = json_decode($bodyContent, true) ?? [];

            $defaultValues = [
                'per_page' => 5,
                'page' => 1,
                'name' => '',
                'category_id' => '',
            ];

            $body = array_merge($defaultValues, array_filter($body, fn ($value) => $value !== null));

            // Valide os valores recebidos
            $body['per_page'] = intval($body['per_page']) > 0 ? intval($body['per_page']) : $defaultValues['per_page'];
            $body['page'] = intval($body['page']) > 0 ? intval($body['page']) : $defaultValues['page'];
            $body['category_id'] = isset($body['category_id']) ?
                intval($body['category_id']) : $defaultValues['category_id'];

            $products = $this->productService->all($body);

            $response->getBody()->write(json_encode($products));

            return $response;
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'No content', $e->getMessage());

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));

            return $response->withStatus(500);
        }
    }

    public function show($request, $response, $args)
    {
        try {
            $id = $args['id'];

            $product = $this->productService->find($id);

            $response->getBody()->write(json_encode($product));

            return $response;
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'Not Found', $e->getMessage());

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));

            return $response->withStatus(500);
        }
    }

    public function create($request, $response)
    {
        try {
            $body = $request->getBody()->getContents();

            if (!$body) {
                throw new NotFoundException(
                    'Request body parsing failed or body is empty'
                );
            }

            $body = json_decode($body, true);

            $productCreateDTO = new ProductCreateDTO(
                isset($body['name']) ? $body['name'] : '',
                isset($body['description']) ? $body['description'] : '',
                isset($body['price']) ? $body['price'] : 0.0,
                isset($body['stock']) ? $body['stock'] : 0,
                isset($body['category_id']) ? $body['category_id'] : 0
            );

            $productDto = $this->productService->create($productCreateDTO);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 200,
                        'message' => 'Product created',
                        'data' => $productDto,
                    ]
                )
            );

            return $response->withStatus(200);
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(
                400,
                'Bad Request',
                $e->getMessage()
            );

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (Exception $e) {
            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 500,
                        'message' => $e->getMessage(),
                    ]
                )
            );

            return $response->withStatus(500);
        }
    }

    public function update($request, $response, $args)
    {
        try {
            $id = $args['id'];

            $body = $request->getBody()->getContents();

            if (!$body) {
                throw new NotFoundException(
                    'Request body parsing failed or body is empty'
                );
            };

            $body = json_decode($body, true);

            $productId = isset($body['id']) ? $body['id'] : 0;

            if ($id != $productId) {
                throw new NotFoundException('No products found');
            }

            $productUpdateDTO = new ProductUpdateDTO(
                $productId,
                isset($body['name']) ? $body['name'] : '',
                isset($body['description']) ? $body['description'] : '',
                isset($body['price']) ? $body['price'] : 0.0,
                isset($body['quantity']) ? $body['quantity'] : 0,
                isset($body['category_id']) ? $body['category_id'] : 0,
                isset($body['image']) ? $body['image'] : ''
            );

            $productDto = $this->productService->update($id, $productUpdateDTO);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 200,
                        'message' => 'Product updated',
                        'data' => $productDto,
                    ]
                )
            );

            return $response->withStatus(200);
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(
                400,
                'Bad Request',
                $e->getMessage()
            );
            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(400);
        } catch (Exception $e) {
            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 500,
                        'message' => $e->getMessage(),
                    ]
                )
            );

            return $response->withStatus(500);
        }
    }

    public function delete($request, $response, $args)
    {
        try {
            $id = $args['id'];

            $this->productService->delete($id);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 200,
                        'message' => 'Product deleted',
                    ]
                )
            );

            return $response->withStatus(200);
        } catch (NotFoundException $e) {
            $errorDetails = new MensagemDetails(404, 'Not Found', $e->getMessage());

            $response->getBody()->write(json_encode($errorDetails));

            return $response->withStatus(404);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));

            return $response->withStatus(500);
        }
    }
}
