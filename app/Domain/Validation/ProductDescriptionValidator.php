<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Interfaces\IValidator;

class ProductDescriptionValidator implements IValidator
{
    public static function validate($product): array
    {
        $errors = [];

        if (empty($product->description)) {
            $errors[] = 'Description is required';
        } elseif (strlen($product->description) < 3) {
            $errors[] = 'Description needs to have at least 3 characters';
        } elseif (strlen($product->description) >= 250) {
            $errors[] = 'Description needs to have a maximum of 250 characters';
        }

        return $errors;
    }
}
