<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlantProtectionProductResource;
use App\Models\PlantProtectionProduct;
use Illuminate\Http\Request;

class PlantProtectionProductController extends Controller
{
    /**
     * Create a new PlantProtectionProductController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Plant Protection Products retrieved successfully.',
            'plant_protection_products' => PlantProtectionProductResource::collection(PlantProtectionProduct::all()),
        ]);
    }
}
