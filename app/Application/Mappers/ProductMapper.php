<?php

namespace Catalog\Application\Mappers;

use Catalog\Application\DTOs\ProductDTO;
use Catalog\Domain\Enums\ProductCategory;
use Illuminate\Support\Collection;
use stdClass;

class ProductMapper
{
    private static function mapToDTO(stdClass $product): ProductDTO
    {
        return new ProductDTO(
            $product->id,
            $product->name,
            $product->description,
            $product->price,
            $product->quantity,
            ProductCategory::getLabel($product->category_id),
            $product->category_id,
            $product->created_at,
            $product->image
        );
    }

    public static function mapDTOCollection(Collection $products): array
    {
        return $products->map(
            function ($product) {
                return self::mapToDTO($product);
            }
        )->toArray();
    }
}
