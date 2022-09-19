<?php

namespace App\Http\Controllers;

use App\Http\Resources\Warehouse as ResourcesWarehouse;
use App\Http\Resources\WarehouseResource;
use App\Models\Farm;
use App\Models\Warehouse;
use App\Services\WarehouseService;
use App\Models\User;
use App\Services\FarmService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private FarmService $farmService;
    private WarehouseService $warehouseService;


    /**
     * Create a new WarehouseController instance.
     *
     * @return void
     */
    public function __construct(FarmService $farmService, WarehouseService $warehouseService)
    {
        $this->farmService = $farmService;
        $this->warehouseService = $warehouseService;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $farmId)
    {
        $data = $request->only('ppp_id', 'quantity');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $userWarehouse = $farm->warehouse;
            $warehouse = $this->warehouseService->create($data, $userWarehouse);
            if ($warehouse instanceof Warehouse) {
                return response()->json([
                    "success" => true,
                    "message" => "Product added successfully.",
                    'warehouse' => new WarehouseResource($warehouse),
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $warehouse,
                ], 400);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = $this->warehouseService->find($id);
        if (auth()->user()->id == $warehouse->farm->user_id) {
            return response()->json([
                "success" => true,
                "message" => "Warehouse retrieved successfully.",
                'warehouse' => new WarehouseResource($warehouse)
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $farmId, $id)
    {
        $data = $request->only('quantity');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $userWarehouse = $farm->warehouse;
            $warehouse = $this->warehouseService->update($data, $userWarehouse, $id);
            if ($warehouse instanceof Warehouse) {
                return response()->json([
                    "success" => true,
                    "message" => "Product updated successfully.",
                    'warehouse' => new WarehouseResource($warehouse),
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $warehouse,
                ], 400);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($farmId, $id)
    {
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $userWarehouse = $farm->warehouse;
            $warehouse = $this->warehouseService->delete($userWarehouse, $id);
            if ($warehouse) {
                return response()->json([
                    "success" => true,
                    "message" => "Field deleted successfully."
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $warehouse,
                ], 400);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
