<?php

namespace App\Services;

use App\Models\Warehouse;
use Exception;
use Illuminate\Support\Facades\DB;

class WarehouseService
{
    public function create($data, Warehouse $warehouse)
    {
        $success = false;
        DB::beginTransaction();

        try {
            $hasProduct = $warehouse->plantProtectionProducts()->where('plant_protection_product_id', $data['ppp_id'])->exists();
            $pivotData = array('quantity' => $data['quantity']);
            if (!$hasProduct) {
                $warehouse->plantProtectionProducts()->attach($data['ppp_id'], $pivotData);
            } else {
                $warehouse->plantProtectionProducts()->updateExistingPivot($data['ppp_id'], $pivotData);
            }
            if ($warehouse->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $warehouse;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function find($warehouseId)
    {
        return Warehouse::findOrFail($warehouseId);
    }

    public function update($data, Warehouse $warehouse, $productId)
    {
        $success = false;
        DB::beginTransaction();
        try {
            $hasProduct = $warehouse->plantProtectionProducts()->where('plant_protection_product_id', $productId)->exists();
            $pivotData = array('quantity' => $data['quantity']);
            if ($hasProduct) {
                $warehouse->plantProtectionProducts()->updateExistingPivot($productId, $pivotData);
            }
            if ($warehouse->save()) {
                $success = true;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        if ($success) {
            DB::commit();
            return $warehouse;
        } else {
            DB::rollback();
            return "Something goes wrong";
        }
    }

    public function delete(Warehouse $warehouse, $productId)
    {
        $success = false;
        DB::beginTransaction();
        try {
            $hasProduct = $warehouse->plantProtectionProducts()->where('plant_protection_product_id', $productId)->exists();
            if ($hasProduct) {
                $product = $warehouse->plantProtectionProducts()->detach($productId);
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
