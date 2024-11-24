<?php

namespace Catalog\Domain\Enums;

enum ProductCategory: int
{
    case Hamburguer = 1;
    case Salads = 2;
    case Drinks = 3;
    case Desserts = 4;

    public static function getLabel(int $category): string
    {
        return match (self::from($category)) {
            self::Hamburguer => 'Hamburguer',
            self::Salads => 'Salads',
            self::Desserts => 'Desserts',
            self::Drinks => 'Drinks',
            default => 'Invalid category',
        };
    }
}
