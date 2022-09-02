<?php

namespace App\Services;

use App\Models\Magazine;
use Exception;
use Illuminate\Support\Facades\DB;

class MagazineService
{
    public function create($data, Magazine $magazine)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $hasProduct = $magazine->plantProtectionProducts()->where('plant_protection_product_id', $data['ppp_id'])->exists();
            $pivotData = array('quantity' => $data['quantity']);
            if (!$hasProduct) {
                $magazine->plantProtectionProducts()->attach($data['ppp_id'], $pivotData);
            } else {
                $magazine->plantProtectionProducts()->updateExistingPivot($data['ppp_id'], $pivotData);
            }
            if ($magazine->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $magazine;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function find($magazineId)
    {
        return Magazine::findOrFail($magazineId);
    }

    public function update($data, Magazine $magazine, $productId)
    {
        $success = false;
        DB::beginTransaction();
        try {
            $hasProduct = $magazine->plantProtectionProducts()->where('plant_protection_product_id', $productId)->exists();
            $pivotData = array('quantity' => $data['quantity']);
            if ($hasProduct) {
                $magazine->plantProtectionProducts()->updateExistingPivot($productId, $pivotData);
            }
            if ($magazine->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $magazine;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function delete(Magazine $magazine, $productId)
    {
        $success = false;
        DB::beginTransaction();
        try {
            $hasProduct = $magazine->plantProtectionProducts()->where('plant_protection_product_id', $productId)->exists();
            if ($hasProduct) {
                $product = $magazine->plantProtectionProducts()->detach($productId);
                if ($product) {
                    $success = true;
                }
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
}
