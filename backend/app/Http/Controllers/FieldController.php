<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Services\FarmService;
use App\Services\FieldService;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    private FieldService $fieldService;
    private FarmService $farmService;
    /**
     * Create a new FieldController instance.
     *
     * @return void
     */
    public function __construct(FieldService $fieldService, FarmService $farmService)
    {
        $this->fieldService = $fieldService;
        $this->farmService = $farmService;
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
        $data = $request->only('field_name', 'cadastral_parcels', 'crop');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $field = $this->fieldService->create($data, $farmId);
            if ($field instanceof Field) {
                return response()->json([
                    "success" => true,
                    "message" => "Field created successfully.",
                    'field' => new FieldResource($field)
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $field,
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
