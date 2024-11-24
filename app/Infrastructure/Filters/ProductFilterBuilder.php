<?php

namespace Catalog\Infrastructure\Filters;

use Catalog\Domain\Interfaces\IProductFilterBuilder;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Collection;

class ProductFilterBuilder implements IProductFilterBuilder
{
    protected $query;

    public function __construct()
    {
        $this->query = DB::table('product');
    }

    public function filterName(?string $name): self
    {
        if ($name) {
            $this->query->where('name', 'like', "%$name%");
        }

        return $this;
    }

    public function filterCategoryId(?int $categoryId): self
    {
        if ($categoryId) {
            $this->query->where('category_id', $categoryId);
        }

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->query->limit($limit);

        return $this;
    }

    public function offset(int $offset): self
    {
        $this->query->offset($offset);

        return $this;
    }

    public function get(): Collection
    {
        return $this->query
            ->where('deleted_at', null)
            ->get();
    }
}
