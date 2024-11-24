<?php

namespace Catalog\Tests\Domain\Entities;

use Catalog\Domain\Entities\Product;
use Catalog\Domain\Exceptions\DomainExceptionValidation;
use PHPUnit\Framework\TestCase;

class ProductUpdateTest extends TestCase
{
    public function testUpdateProductWithInvalidId(): void
    {
        Product::create('Laptop', 'A powerful laptop', 1500.00, 10, 1);

        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Id is required');

        Product::update(0, 'Laptop', 'A powerful laptop', 1500.00, 10, 1);
    }

    public function testUpdateProductWithValidParameters(): void
    {
        $updateProduct = Product::update(1, 'Laptop', 'A powerful laptop', 1500.00, 10, 1);

        $this->assertEquals(1, $updateProduct->id);
        $this->assertEquals('Laptop', $updateProduct->name);
        $this->assertEquals('A powerful laptop', $updateProduct->description);
        $this->assertEquals(1500.00, $updateProduct->price);
        $this->assertEquals(10, $updateProduct->quantity);
        $this->assertEquals(1, $updateProduct->category_id);
    }

    public function testUpdateProductWithInvalidName(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name is required');

        Product::update(1, '', 'A powerful laptop', 1500.00, 10, 1);
    }

    public function testUpdateProductWithInvalidNameLength(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name needs to have at least 3 characters');

        Product::update(1, 'La', 'A powerful laptop', 1500.00, 10, 1);
    }

    public function testUpdateProductWithInvalidNameLength2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Name needs to have a maximum of 100 characters');

        Product::update(
            1,
            "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
            'A powerful laptop',
            1500.00,
            10,
            1
        );
    }

    public function testUpdateProductWithInvalidDescription(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description is required');

        Product::update(1, 'Laptop', '', 1500.00, 10, 1);
    }

    public function testUpdateProductWithInvalidDescriptionLength(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description needs to have at least 3 characters');

        Product::update(1, 'Laptop', 'Ap', 1500.00, 10, 1);
    }

    public function testUpdateProductWithInvalidDescriptionLength2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Description needs to have a maximum of 250 characters');

        Product::update(
            1,
            'Laptop',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            1500.00,
            10,
            1
        );
    }

    public function testUpdateProductWithInvalidPrice(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Price is required');

        Product::update(1, 'Laptop', 'A powerful laptop', 0, 10, 1);
    }

    public function testUpdateProductWithInvalidQuantity(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Quantity is required');

        Product::update(1, 'Laptop', 'A powerful laptop', 1500.00, 0, 1);
    }

    public function testUpdateProductWithInvalidquantity2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Quantity needs to be greater than or equal to 0');

        Product::update(1, 'Laptop', 'A powerful laptop', 1500.00, -1, 1);
    }

    public function testUpdateProductWithInvalidCategory(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Category is required');

        Product::update(1, 'Laptop', 'A powerful laptop', 1500.00, 10, 0);
    }

    public function testUpdateProductWithInvalidPrice2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Price needs to be greater than 0');

        Product::update(1, 'Laptop', 'A powerful laptop', -1, 10, 1);
    }

    public function testUpdateProductWithInvalidCategory2(): void
    {
        $this->expectException(DomainExceptionValidation::class);
        $this->expectExceptionMessage('Category id needs to be greater than or equal to 0');

        Product::update(1, 'Laptop', 'A powerful laptop', 1500.00, 10, -1);
    }

}
