<?php

namespace App\Repositories;

use App\Models\Farm;

class FarmRepository extends BaseRepository
{
    public function __construct(Farm $model)
    {
        $this->model = $model;
    }
}
