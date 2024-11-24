<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Interfaces\IValidator;

class ProductPriceValidator implements IValidator
{
    public static function validate($product): array
    {
        $errors = [];

        if (empty($product->price)) {
            $errors[] = 'Price is required';
        } elseif ($product->price <= 0) {
            $errors[] = 'Price needs to be greater than 0';
        }

        return $errors;
    }
}
