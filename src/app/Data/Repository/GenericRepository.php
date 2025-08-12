<?php

declare(strict_types=1);

namespace App\Data\Repository;

use App\Core\App;
use App\Data\DB;
use App\Domain\Interfaces\GenericRepositoryInterface;

class GenericRepository implements GenericRepositoryInterface
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}
