<?php

namespace Catalog\Domain\Entities;

use DateTime;

abstract class Entity
{
    public int $id;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $deleted_at;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }
}
