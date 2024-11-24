<?php

namespace Catalog\Application\Services\Product\Interfaces;

use Catalog\Application\DTOs\ProductCreateDTO;
use Catalog\Application\DTOs\ProductUpdateDTO;

interface IProductService
{
    public function all(array $parameters);
    public function find($id);
    public function create(ProductCreateDTO $entity);
    public function update($id, ProductUpdateDTO $entity);
    public function delete($id);
}
