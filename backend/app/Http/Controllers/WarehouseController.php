<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Warehouse as ResourcesWarehouse;
use App\Http\Resources\WarehouseResource;
use App\Models\Farm;
use App\Models\Warehouse;
use App\Services\WarehouseService;
use App\Models\User;
use App\Services\FarmService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function store(StoreProductRequest $request, $farmId)
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
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $warehouse,
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
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
            $warehouseWithProducts = $this->warehouseService->getAllWarehouseProducts($warehouse);
            return response()->json([
                "success" => true,
                "message" => "Warehouse retrieved successfully.",
                // 'warehouse' => new WarehouseResource($warehouse)
                'warehouse' => $warehouseWithProducts
            ], Response::HTTP_OK);
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
    public function update(UpdateProductRequest $request, $farmId, $id)
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
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $warehouse,
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
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

    public function getAllWarehouseProducts($id){
        $warehouse = $this->warehouseService->find($id);
        if (auth()->user()->id == $warehouse->farm->user_id) {
            $warehouseWithProducts = $this->warehouseService->getAllWarehouseProducts($warehouse, false);
            return response()->json([
                "success" => true,
                "message" => "Warehouse retrieved successfully.",
                // 'warehouse' => new WarehouseResource($warehouse)
                'warehouse' => $warehouseWithProducts
            ], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
