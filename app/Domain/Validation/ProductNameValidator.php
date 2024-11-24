<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Interfaces\IValidator;

class ProductNameValidator implements IValidator
{
    public static function validate($product): array
    {
        $errors = [];

        if (empty($product->name)) {
            $errors[] = 'Name is required';
        } elseif (strlen($product->name) < 3) {
            $errors[] = 'Name needs to have at least 3 characters';
        } elseif (strlen($product->name) >= 100) {
            $errors[] = 'Name needs to have a maximum of 100 characters';
        }

        return $errors;
    }
}
