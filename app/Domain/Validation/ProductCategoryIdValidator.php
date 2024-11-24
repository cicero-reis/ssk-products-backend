<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Interfaces\IValidator;

class ProductCategoryIdValidator implements IValidator
{
    public static function validate($product): array
    {
        $errors = [];

        if (empty($product->category_id)) {
            $errors[] = 'Category is required';
        } elseif ($product->category_id < 0) {
            $errors[] = 'Category id needs to be greater than or equal to 0';
        }

        return $errors;
    }
}
