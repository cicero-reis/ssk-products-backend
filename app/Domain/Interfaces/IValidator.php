<?php

namespace Catalog\Domain\Interfaces;

interface IValidator
{
    public static function validate($entity): array;
}
