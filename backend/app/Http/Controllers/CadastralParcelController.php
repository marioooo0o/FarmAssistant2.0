<?php

namespace App\Http\Controllers;

use App\Models\CadastralParcel;
use App\Services\FarmService;
use App\Services\FieldService;
use App\Services\CadastralParcelService;
use App\Http\Resources\CadastralParcelResource;
use Illuminate\Http\Request;

class CadastralParcelController extends Controller
{
    private FieldService $fieldService;
    private FarmService $farmService;
    private CadastralParcelService $cadastralParcelService;
    /**
     * Create a new CadastralParcelController instance.
     *
     * @return void
     */
    public function __construct(FieldService $fieldService, FarmService $farmService, CadastralParcelService $cadastralParcelService)
    {
        $this->fieldService = $fieldService;
        $this->farmService = $farmService;
        $this->cadastralParcelService = $cadastralParcelService;
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
    public function store(Request $request, $farmId, $fieldId)
    {
        $data = $request->only('parcel_number', 'area');
        $field = $this->fieldService->find($fieldId);
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $parcel = $this->cadastralParcelService->create($data, $field);
            if ($parcel instanceof CadastralParcel) {
                return response()->json([
                    "success" => true,
                    "message" => "Cadastral parcel created successfully.",
                    'cadastral_parcel' => new CadastralParcelResource($parcel)
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $parcel,
                ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
