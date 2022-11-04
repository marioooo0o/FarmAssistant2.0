<?php

namespace App\Services;

use App\Models\Practise;
use App\Models\Farm;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class PractiseService
{
    public function create($data, Farm $farm)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $errors = array();
            $practise = $farm->practises()->create([
                'name' => $data['name'],
                'water' => $data['water'],
                'start' => $data['start_date']
            ]);
            $warehouse = $farm->warehouse;
            $warehouseProducts = $warehouse->plantProtectionProducts;
            if (!$warehouseProducts->count()) {
                throw new Exception("You don't have any plant protection products");
            }

            foreach ($data['fields'] as $singleProduct) {
                $field = Field::findOrFail($singleProduct['id']);
                $practise->fields()->attach($singleProduct['id']);
            }

            $formProducts = $data['products'];
            for ($i = 0; $i < count($formProducts); $i++) {
                if (!$product = $warehouseProducts->where('id', $formProducts[$i]['id'])->first()) {
                    throw new Exception("You don't have this product in your warehouse");
                }
                if ($product->pivot->quantity >= $formProducts[$i]['quantity']) {
                    $pivotData = array('quantity' => $formProducts[$i]['quantity']);
                    $practise->plantProtectionProducts()->attach($product->id, $pivotData);
                    $warehousePivot = array('quantity' => ($product->pivot->quantity - $formProducts[$i]['quantity']));
                    $warehouse->plantProtectionProducts()->updateExistingPivot($formProducts[$i]['id'], $warehousePivot);
                } else {
                    $errors['products.' . $i . '.quantity'] = "Nie posiadasz wystarczającą ilość środka w magazynie";
                }
            }
            if ($errors) {
                throw ValidationException::withMessages($errors);
            }

            if ($practise->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            if ($e->getMessage() == "You don't have any plant protection products") {
                abort(400, $e->getMessage());
            } else if ($e->getMessage() == "You don't have this product in your warehouse") {
                abort(400, $e->getMessage());
            } else {
                throw $e;
            }
        }

        if ($success) {
            DB::commit();
            return $practise;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }
}
