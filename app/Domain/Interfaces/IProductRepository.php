<?php

namespace Catalog\Domain\Interfaces;

use Catalog\Domain\Entities\Product;

interface IProductRepository
{
    public function all(array $parameters);
    public function find(int $id);
    public function create(Product $entity);
    public function update(int $id, Product $entity);
    public function delete(int $id);
}
