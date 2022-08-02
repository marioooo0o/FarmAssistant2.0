<?php

namespace App\Repositories;

use App\Models\Field;

class FieldRepository extends BaseRepository
{
    private $farmRepository;

    public function __construct(Field $model, FarmRepository $farmRepository)
    {
        $this->model = $model;
        $this->farmRepository = $farmRepository;
    }

    public function createWithFarm($data, $farmId)
    {
        $farm = $this->farmRepository->find($farmId);
        return $farm->fields()->create($data);
    }
}
