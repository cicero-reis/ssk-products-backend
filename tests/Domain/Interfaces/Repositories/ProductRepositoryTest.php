<?php

namespace Tests\Interfaces\Repositories;

use Catalog\Domain\Entities\Product;
use Catalog\Domain\Interfaces\IProductRepository;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(IProductRepository::class);
    }

    public function testProductGetAll()
    {
        $parameter = ['some_parameter' => 'value'];

        $this->repositoryMock->method('all')
         ->with($parameter)
         ->willReturn([
                 Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1),
                 Product::create('Smartphone', 'A powerful smartphone', 800.00, 20, 1),
                 Product::create('Tablet', 'A powerful tablet', 500.00, 30, 1),
             ]);

        $products = $this->repositoryMock->all($parameter);

        $this->assertCount(3, $products);
    }

    public function testProductGetById()
    {
        $this->repositoryMock->method('find')->willReturn(Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1));

        $product = $this->repositoryMock->find(1);

        $this->assertEquals('Laptop', $product->name);
    }

    public function testProductCreate()
    {
        $product = Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1);

        $this->repositoryMock->method('create')->willReturn($product);

        $productCreated = $this->repositoryMock->create($product);

        $this->assertEquals('Laptop', $productCreated->name);
    }

    public function testProductUpdate()
    {
        $product = Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1);

        $this->repositoryMock->method('update')->willReturn($product);

        $productUpdated = $this->repositoryMock->update(1, $product);

        $this->assertEquals('Laptop', $productUpdated->name);
    }

    public function testProductDelete()
    {
        $this->repositoryMock->method('delete')->willReturn(true);

        $productDeleted = $this->repositoryMock->delete(1);

        $this->assertTrue($productDeleted);
    }

    public function testProductDeleteNotFound()
    {
        $this->repositoryMock->method('delete')->willReturn(false);

        $productDeleted = $this->repositoryMock->delete(1);

        $this->assertFalse($productDeleted);
    }
}
