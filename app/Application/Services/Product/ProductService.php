<?php

namespace Catalog\Application\Services\Product;

use Catalog\Application\DTOs\ProductCreateDTO;
use Catalog\Application\DTOs\ProductUpdateDTO;
use Catalog\Application\Mappers\ProductMapper;
use Catalog\Application\Services\Product\Interfaces\IProductService;
use Catalog\Domain\Entities\Product;
use Catalog\Domain\Exceptions\DomainExceptionValidation;
use Catalog\Domain\Interfaces\IProductRepository;
use Catalog\Exception\NotFoundException;
use Exception;

class ProductService implements IProductService
{
    private $productRepository;
    private $productMapper;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->productMapper = new ProductMapper();
    }

    public function all(array $parameters): array
    {
        $products = $this->productRepository->all($parameters);

        if (!$products) {
            throw new NotFoundException('No products found');
        }

        $productsMapper = $this->productMapper->mapDTOCollection($products);

        return $productsMapper;
    }

    public function find($id)
    {
        if (!is_numeric($id)) {
            throw new NotFoundException('Invalid ID');
        }

        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new NotFoundException('No products found');
        }

        $productCollection = collect([$product]);

        $productMapper = $this->productMapper->mapDTOCollection($productCollection);

        return $productMapper;
    }

    public function create(ProductCreateDTO $dto): array
    {
        try {
            $product = Product::create(
                $dto->name,
                $dto->description,
                $dto->price,
                $dto->quantity,
                $dto->category_id
            );

            $newProduct = $this->productRepository->create($product);

            $productCollection = collect([$newProduct]);

            return $this->productMapper->mapDTOCollection($productCollection);
        } catch (DomainExceptionValidation  $e) {
            throw new NotFoundException($e->getMessage());
        } catch (Exception $e) {
            throw new \Exception(
                'An error occurred while creating the product: ' . $e
            );
        }
    }

    public function update($id, ProductUpdateDTO $dto): array
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new NotFoundException('No products found');
        }

        try {
            $product = Product::update(
                $dto->id,
                $dto->name,
                $dto->description,
                $dto->price,
                $dto->quantity,
                $dto->category_id,
                $dto->image
            );

            $productUpdate = $this->productRepository->update($id, $product);

            $productCollection = collect([$productUpdate]);

            return $this->productMapper->mapDTOCollection($productCollection);
        } catch (DomainExceptionValidation  $e) {
            throw new NotFoundException($e->getMessage());
        } catch (Exception $e) {
            throw new \Exception(
                'An error occurred while updating the product: ' . $e
            );
        }
    }

    public function delete($id)
    {
        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                throw new NotFoundException('No products found');
            }

            return $this->productRepository->delete($id);
        } catch (NotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        } catch (Exception $e) {
            throw new \Exception(
                'An error occurred while deleting the product: ' . $e
            );
        }
    }
}
