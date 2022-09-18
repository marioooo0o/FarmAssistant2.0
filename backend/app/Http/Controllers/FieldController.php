<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Http\Resources\FieldCollection;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Services\FarmService;
use App\Services\FieldService;
use App\Support\Collection;
use Illuminate\Http\Response;

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
    public function index($farmId)
    {
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $farmFields = $this->fieldService->getAllFarmFields($farm);
            if ($farmFields) {
                return response()->json([
                    "success" => true,
                    "message" => "Fields retrieved successfully.",
                    'fields' =>  $farmFields,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $farmFields,
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldRequest $request, $farmId)
    {
        $data = $request->only('field_name', 'cadastral_parcels', 'crop');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $field = $this->fieldService->create($data, $farm);
            if ($field instanceof Field) {
                return response()->json([
                    "success" => true,
                    "message" => "Field created successfully.",
                    'field' => new FieldResource($field)
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $field,
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
    public function show($farmId, $id)
    {
        $field = $this->fieldService->find($id);
        if (auth()->user()->id == $field->farm->user_id) {
            return response()->json([
                "success" => true,
                "message" => "Field retrieved successfully.",
                'field' => new FieldResource($field)
            ], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, $farmId, $id)
    {
        $data = $request->only('field_name', 'cadastral_parcels', 'crop');
        $field = Field::findOrFail($id);
        if (auth()->user()->id == $field->farm->user_id) {
            $field = $this->fieldService->update($data, $field);
            if ($field instanceof Field) {
                return response()->json([
                    "success" => true,
                    "message" => "Field updated successfully.",
                    'field' => new FieldResource($field)
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $field,
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
        $field = Field::findOrFail($id);
        if (auth()->user()->id == $field->farm->user_id) {
            $field = $this->fieldService->delete($field);
            if ($field) {
                return response()->json([
                    "success" => true,
                    "message" => "Field deleted successfully."
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $field,
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
