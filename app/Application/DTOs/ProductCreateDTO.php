<?php

namespace Catalog\Application\DTOs;

use JsonSerializable;

class ProductCreateDTO implements JsonSerializable
{
    public string $name;
    public string $description;
    public float $price;
    public int $quantity;
    public int $category_id;

    public function __construct(
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $category_id
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
