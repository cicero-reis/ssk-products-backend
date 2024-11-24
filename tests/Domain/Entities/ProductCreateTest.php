<?php

namespace Catalog\Tests\Domain\Entities;

use Catalog\Domain\Entities\Product;
use Catalog\Domain\Exceptions\DomainExceptionValidation;
use PHPUnit\Framework\TestCase;

class ProductCreateTest extends TestCase
{
    public function testeCreateProductWithValidParameters(): void
    {
        $product = Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1);

        $this->assertEquals('Laptop', $product->name);
        $this->assertEquals('A powerful laptop', $product->description);
        $this->assertEquals(1500.00, $product->price);
        $this->assertEquals(10, $product->quantity);
        $this->assertEquals(1, $product->category_id);
    }

    public function testCreateProductWithInvalidName(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name is required');

        Product::create('', 'A powerful laptop', 1500.00, 10, 1);
    }

    public function testCreateProductWithInvalidNameLength(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name needs to have at least 3 characters');

        Product::create('La', 'A powerful laptop', 1500.00, 10, 1);
    }

    public function testCreateProductWithInvalidNameLength2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name needs to have a maximum of 100 characters');

        Product::create(
            "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
            'A powerful laptop',
            1500.00,
            10,
            1
        );
    }

    public function testCreateProductWithInvalidDescription(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description is required');

        Product::create('Laptop', '', 1500.00, 10, 1);
    }

    public function testCreateProductWithInvalidDescriptionLeast(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description needs to have at least 3 characters');

        Product::create('Laptop', 'Ap', 1500.00, 10, 1);
    }

    public function testCreateProductWithInvalidDescriptionMaximumOf(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description needs to have a maximum of 250 characters');

        Product::create(
            'Laptop',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            1500.00,
            10,
            1
        );
    }

    public function testCreateProductWithInvalidPrice(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Price is required');

        Product::create('Laptop', 'A powerful laptop', 0, 10, 1);
    }

    public function testCreateProductWithInvalidPrice2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Price needs to be greater than 0');

        Product::create('Laptop', 'A powerful laptop', -1, 10, 1);
    }

    public function testCreateProductWithInvalidQuantity(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Quantity is required');

        Product::create('Laptop', 'A powerful laptop', 1500.00, 0, 1);
    }

    public function testCreateProductWithInvalidQuantity2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Quantity needs to be greater than or equal to 0');

        Product::create('Laptop', 'A powerful laptop', 1500.00, -1, 1);
    }

    public function testCreateProductWithInvalidCategory(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Category is required');

        Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 0);
    }

    public function testCreateProductWithInvalidCategoryNot(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Category id needs to be greater than or equal to 0');

        Product::create('Laptop', 'A powerful laptop', 1500.00, 10, -1);
    }
}
