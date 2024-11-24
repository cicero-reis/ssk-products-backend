<?php

namespace Catalog\Domain\Exceptions;

use Exception;

class DomainExceptionValidation extends Exception
{
    public static function assertTrue(bool $condition, string $errorMessage): void
    {
        if (!$condition) {
            throw new self($errorMessage);
        }
    }
}
