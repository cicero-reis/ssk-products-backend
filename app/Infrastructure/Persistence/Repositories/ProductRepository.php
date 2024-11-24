<?php

namespace Catalog\Infrastructure\Persistence\Repositories;

use Catalog\Domain\Entities\Product;
use Catalog\Domain\Interfaces\IProductFilterBuilder;
use Catalog\Domain\Interfaces\IProductRepository;
use DateTime;
use Illuminate\Database\Capsule\Manager as DB;

class ProductRepository implements IProductRepository
{
    private $productFilterBuilder;

    public function __construct(IProductFilterBuilder $productFilterBuilder)
    {
        $this->productFilterBuilder = $productFilterBuilder;
    }

    public function all(array $parameters)
    {
        return $this->productFilterBuilder
            ->filterName($parameters['name'])
            ->filterCategoryId($parameters['category_id'])
            ->limit($parameters['per_page'])
            ->offset(($parameters['page'] - 1) * $parameters['per_page'])
            ->get();
    }

    public function find(int $id)
    {
        return DB::table('product')
            ->where('id', $id)
            ->where('deleted_at', null)
            ->first();
    }

    public function create(Product $entity)
    {
        $newProduct = DB::table('product')->insertGetId(
            [
                'name' => $entity->name,
                'description' => $entity->description,
                'price' => $entity->price,
                'quantity' => $entity->quantity,
                'category_id' => $entity->category_id,
            ]
        );

        return DB::table('product')->find($newProduct);
    }

    public function update(int $id, Product $entity)
    {
        DB::table('product')->where('id', $id)->update(
            [
                'name' => $entity->name,
                'description' => $entity->description,
                'price' => $entity->price,
                'quantity' => $entity->quantity,
                'image' => $entity->image,
                'category_id' => $entity->category_id,
            ]
        );

        return DB::table('product')->find($id);
    }

    public function delete(int $id)
    {
        return DB::table('product')
            ->where('id', $id)
            ->update(['deleted_at' => new DateTime()]);
    }
}
