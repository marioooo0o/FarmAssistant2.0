<?php

namespace App\Services;

use App\Models\Farm;
use App\Models\Field;
use App\Models\CadastralParcel;
use App\Models\Crop;
use App\Repositories\CadastralParcelRepository;
use App\Repositories\FarmRepository;
use App\Repositories\FieldRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function getAllFarmFields($farm)
    {
        try {
            $fields = $farm->fields()->with('cadastralParcels')->with('crop')->paginate(5)->toArray();
            $fields['data'] = array_map(function ($field) {
                if ($field['crop']['image_path']) {
                    $field['crop']['image_path'] = Storage::url($field['crop']['image_path']);
                }
                return $field;
            }, $fields['data']);
            return collect($fields);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($fieldAtributes, Farm $farm)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $crop = Crop::where('name', $fieldAtributes['crop'])->firstOrFail();
            //create field
            $newField = Field::create([
                'farm_id' => $farm->id,
                'crop_id' => $crop->id,
                'field_name' =>  $fieldAtributes['field_name'],
            ]);

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
            throw $e;
        }

        if ($success) {
            DB::commit();
            return $newField;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function find($fieldId)
    {
        return Field::findOrFail($fieldId);
    }

    public function update($fieldAtributes, Field $field)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $crop = Crop::where('name', $fieldAtributes['crop'])->firstOrFail();
            //update field
            $field->update([
                'crop_id' => $crop->id,
                'field_name' =>  $fieldAtributes['field_name'],
            ]);
            $this->foo($field);
            //remove all parcels from a field
            $field->cadastralParcels()->detach();
            foreach ($fieldAtributes['cadastral_parcels'] as $singleParcel) {
                //find first parcel with equal parcel number or create new record in db
                $parcel = CadastralParcel::firstOrCreate([
                    'parcel_number' => $singleParcel['parcel_number']
                ]);
                $pivotData = array('area' => $singleParcel['area']);
                //add data and ids to pivot table 
                $field->cadastralParcels()->attach($parcel->id, $pivotData);
                //calculate parcel area from pivot
                $parcel->parcel_area = $parcel->sumParcelArea();
                $parcel->save();
            }
            //calculate field area from pivot
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
            return $field;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function delete(Field $field)
    {
        $success = false;
        DB::beginTransaction();
        try {
            $this->foo($field);
            //remove all parcels from a field
            $field->cadastralParcels()->detach();
            if ($field->delete()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return true;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }
    //TODO: wymyślić normalną nazwe xd
    public function foo(Field $field)
    {
        $parcels = $field->cadastralParcels()->get();
        foreach ($parcels as $parcel) {
            $parcel->parcel_area -= $parcel->pivot->area;
            $parcel->save();
        }
    }
}
