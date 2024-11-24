<?php

namespace Catalog\Application\DTOs;

use Carbon\Carbon;
use JsonSerializable;

class ProductDTO implements JsonSerializable
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public int $quantity;
    public string $category_name;
    public int $category_id;
    public string $created_at;
    public string $image;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        int $quantity,
        string $category_name,
        int $category_id,
        string $created_at,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_name = $category_name;
        $this->category_id = $category_id;
        $this->created_at = $created_at;
        $this->image = $image;
    }

    public function jsonSerialize(): array
    {
        $this->created_at = Carbon::parse($this->created_at)->format('d/m/Y H:i:s');

        return get_object_vars($this);
    }
}
