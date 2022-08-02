<?php

namespace App\Services;

use App\Models\CadastralParcel;
use App\Repositories\CadastralParcelRepository;
use App\Repositories\FarmRepository;
use App\Repositories\FieldRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FieldService
{
    private UserRepository $userRepository;
    private FarmRepository $farmRepository;
    private FieldRepository $fieldRepository;
    private CadastralParcelRepository $cadastralParcelRepository;

    public function __construct(UserRepository $userRepository, FarmRepository $farmRepository, FieldRepository $fieldRepository, CadastralParcelRepository $cadastralParceldRepository)
    {
        $this->userRepository = $userRepository;
        $this->farmRepository = $farmRepository;
        $this->fieldRepository = $fieldRepository;
        $this->cadastralParcelRepository = $cadastralParceldRepository;
    }

    public function create($fieldAtributes, $farmId)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $farm = $this->farmRepository->find($farmId);
            $fieldData = array('field_name' => $fieldAtributes['field_name']);
            //create field
            $newField = $farm->fields()->create($fieldData);
            foreach ($fieldAtributes['cadastral_parcels'] as $singleParcel) {
                //find first parcel with equal parcel number or create new record in db
                $parcel = CadastralParcel::firstOrCreate([
                    'parcel_number' => $singleParcel['parcel_number']
                ]);
                $pivotData = array('area' => $singleParcel['area']);
                //add data and ids to pivot table 
                $newField->cadastralParcels()->attach($parcel->id, $pivotData);
                //calculate parcel area from pivot
                $parcel->parcel_area = $parcel->sumParcelArea();
                $parcel->save();
            }
            //calculate field area from pivot
            $newField->field_area = $newField->cadastralParcels->sum('pivot.area');
            if ($newField->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $newField;
        } else {
            DB::rollback();
        }
    }
}
