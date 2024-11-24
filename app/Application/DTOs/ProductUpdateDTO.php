<?php

namespace Catalog\Application\DTOs;

use JsonSerializable;

class ProductUpdateDTO implements JsonSerializable
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public int $quantity;
    public int $category_id;
    public string $image;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->image = $image;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
