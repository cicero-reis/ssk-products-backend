<?php

namespace Catalog\Infrastructure\Observers;

class ProductObserver
{
    public static function creating($product): void
    {
        // tratar a criação do produto
    }

    public static function created($product)
    {
        // tratar a criação do produto
    }

    public static function updating($product)
    {
        // tratar a criação do produto
    }

    public static function updated($productId): void
    {
        // tratar a atualização do produto
    }

    public static function deleting($product)
    {
        // tratar a criação do produto
    }

    public static function deleted($product)
    {
        // tratar a criação do produto
    }
}
