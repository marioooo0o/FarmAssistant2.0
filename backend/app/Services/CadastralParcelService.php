<?php

namespace App\Services;

use App\Models\CadastralParcel;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Exception;

class CadastralParcelService
{
    public function create($parcelAtributes, Field $field)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $cadastralParcel = CadastralParcel::firstOrCreate([
                'parcel_number' => $parcelAtributes['parcel_number']
            ]);

            $pivotData = array('area' => $parcelAtributes['area']);
            $field->cadastralParcels()->attach($cadastralParcel->id, $pivotData);

            $cadastralParcel->parcel_area = $cadastralParcel->sumParcelArea();
            $cadastralParcel->save();


            //calcualate field area
            $field->field_area = $field->cadastralParcels->sum('pivot.area');

            if ($field->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $cadastralParcel;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }
}
