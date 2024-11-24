<?php

namespace Catalog\Domain\Entities;

use Catalog\Domain\Exceptions\DomainExceptionValidation;
use Catalog\Domain\Validation\ProductValidator;

class Product extends Entity
{
    public string $name;
    public string $description;
    public float $price;
    public int $quantity;
    public int $category_id;
    public string $image;
    private ProductValidator $validator;

    private function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id,
        string $image = ''
    ) {
        parent::__construct($id);
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->image = $image;
        $this->validator = new ProductValidator();
    }

    public static function createBind(
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id
    ) {
        return new self(0, $name, $description, $price, $quantity, $category_id);
    }

    public static function create(
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id
    ): self {
        $product = new self(
            0,
            $name,
            $description,
            $price,
            $quantity,
            $category_id
        );
        $product->validate();

        return $product;
    }

    public static function update(
        int $id,
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id
    ): self {
        DomainExceptionValidation::assertTrue($id > 0, 'Id is required');
        $product = new self($id, $name, $description, $price, $quantity, $category_id);
        $product->validate();

        return $product;
    }

    private function validate(): void
    {
        $this->validator->validate($this);
    }
}
