<?php

namespace App\Services;

use App\Models\Practise;
use App\Models\Farm;
use App\Models\Field;
use App\Models\PlantProtectionProduct;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class PractiseService
{
    public function getAllFarmPractises(Farm $farm)
    {
        try {
            $practises = $farm->practises()->with('fields')->paginate(5);
            return $practises;
        } catch (Exception $e) {
            throw $e;
        }
    }

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
                    $errors['products'][$i]['quantity'] = "Nie posiadasz wystarczającą ilość środka w magazynie";
                    // $errors['products.' . $i . '.quantity'] = "Nie posiadasz wystarczającą ilość środka w magazynie";
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

    public function find($id)
    {
        return Practise::findOrFail($id);
    }

    public function update($data, Farm $farm, Practise $practise)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $errors = array();
            $practise->update([
                'name' => $data['name'],
                'water' => $data['water'],
                'start' => $data['start_date']
            ]);
            $warehouse = $farm->warehouse;
            $warehouseProducts = $warehouse->plantProtectionProducts;
            if (!$warehouseProducts->count()) {
                throw new Exception("You don't have any plant protection products");
            }
            //remove all fields from practise
            $practise->fields()->detach();
            foreach ($data['fields'] as $singleProduct) {
                $field = Field::findOrFail($singleProduct['id']);
                $practise->fields()->attach($singleProduct['id']);
            }

            //zmienna przechowująca listę środków które zostały uzyte do zabiegu
            // $practiseProducts = $practise->plantProtectionProducts;
            // $formProducts = $data['products'];
            // $this->restoreToOrginal($practiseProducts, $warehouse, $warehouseProducts);
            $practise->plantProtectionProducts()->detach();
            foreach ($data['products'] as $singleProduct){
                $product = PlantProtectionProduct::findOrFail($singleProduct['id']);
                $pivotData = array('quantity' => $singleProduct['quantity']);
                $practise->plantProtectionProducts()->attach($product->id, $pivotData);
            }
            // for ($i = 0; $i < count($formProducts); $i++) {
            //     //sprawdzanie czy w magazynie jest środek który dodano w formularzu
            //     if (!$product = $warehouseProducts->where('id', $formProducts[$i]['id'])->first()) {
            //         throw new Exception("You don't have this product in your warehouse");
            //     }
            //     //sprawdzenie czy magazyn posiada wystarczającą ilość środka do wykonania zabiegu
            //     if ($product->pivot->quantity >= $formProducts[$i]['quantity']) {
            //         $pivotData = array('quantity' => $formProducts[$i]['quantity']);
            //         $practise->plantProtectionProducts()->attach($product->id, $pivotData);
            //         $warehousePivot = array('quantity' => ($product->pivot->quantity - $formProducts[$i]['quantity']));
            //         $warehouse->plantProtectionProducts()->updateExistingPivot($formProducts[$i]['id'], $warehousePivot);
            //     } else {
            //         $errors['products'][$i]['quantity'] = "Nie posiadasz wystarczającą ilość środka w magazynie";
            //     }
            // }
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

    public function delete(Practise $practise)
    {
        $success = false;
        DB::beginTransaction();
        try {
            if($practise->delete()){
                $success = true;
            }
        }
        catch (Exception $e) {
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

    public function restoreToOrginal($practiseProducts, $warehouse, $warehouseProducts)
    {
        try {
            foreach ($practiseProducts as $product) {
                $warehouseProduct = $warehouseProducts->where('id', $product->id)->first();
                $quantityBefore = $product->pivot->quantity + $warehouseProduct->pivot->quantity;
                $warehouse->plantProtectionProducts()->updateExistingPivot($product->id, ['quantity' => $quantityBefore]);
                $warehouse->save();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
