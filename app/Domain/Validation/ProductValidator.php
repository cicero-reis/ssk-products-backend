<?php

namespace Catalog\Domain\Validation;

use Catalog\Domain\Entities\Product;
use Catalog\Domain\Exceptions\DomainExceptionValidation;

class ProductValidator
{
    public function validate($product): void
    {
        if (!($product instanceof Product)) {
            throw new DomainExceptionValidation('Invalid entity');
        }

        $errors = [];

        $errors[] = collect(ProductNameValidator::validate($product))
                        ->first();
        $errors[] = collect(ProductDescriptionValidator::validate($product))
                        ->first();
        $errors[] = collect(ProductPriceValidator::validate($product))
                        ->first();
        $errors[] = collect(ProductQuantityValidator::validate($product))
                        ->first();
        $errors[] = collect(ProductCategoryIdValidator::validate($product))
                        ->first();

        $errors = collect($errors)->filter()->toArray();

        if (!empty($errors)) {
            throw new DomainExceptionValidation(implode(', ', $errors));
        }
    }
}
