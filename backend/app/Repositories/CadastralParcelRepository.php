<?php

namespace App\Repositories;

use App\Models\CadastralParcel;
use App\Models\Field;

class CadastralParcelRepository extends BaseRepository
{
    private $fieldRepository;

    public function __construct(CadastralParcel $model, FieldRepository $fieldRepository)
    {
        $this->model = $model;
        $this->fieldRepository = $fieldRepository;
    }

    public function createWithField($data, $fieldId)
    {
        $field = $this->fieldRepository->find($fieldId);
        return $field->cadastralParcels()->create($data);
    }
}
