<?php

namespace Catalog\Domain\Interfaces;

interface IProductFilterBuilder
{
    public function filterName(?string $name): self;
    public function filterCategoryId(?int $categoryId): self;
    public function limit(int $limit): self;
    public function offset(int $offset): self;
    public function get();
}
