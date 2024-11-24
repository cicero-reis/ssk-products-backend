<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Interfaces\IValidator;

class ProductQuantityValidator implements IValidator
{
    public static function validate($product): array
    {
        $errors = [];

        if (empty($product->quantity)) {
            $errors[] = 'Quantity is required';
        } elseif ($product->quantity < 0) {
            $errors[] = 'Quantity needs to be greater than or equal to 0';
        }

        return $errors;
    }
}
