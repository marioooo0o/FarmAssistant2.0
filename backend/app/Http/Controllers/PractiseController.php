<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePractise;
use App\Http\Resources\PractiseResource;
use App\Models\Practise;
use App\Services\FarmService;
use Illuminate\Http\Request;
use App\Services\PractiseService;
use Symfony\Component\HttpFoundation\Response;

class PractiseController extends Controller
{
    private PractiseService $practiseService;
    private FarmService $farmService;

    public function __construct(PractiseService $practiseService, FarmService $farmService)
    {
        $this->practiseService = $practiseService;
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
            return PractiseResource::collection(Practise::with('fields')->where('farm_id', $farmId)->paginate(5));
            // $farmPractises = $this->practiseService->getAllFarmPractises($farm);
            // if ($farmPractises) {
            //     return response()->json([
            //         "success" => true,
            //         "message" => "Fields retrieved successfully.",
            //         'practises' => $farmPractises
            //     ], Response::HTTP_OK);
            // } else {
            //     return response()->json([
            //         "success" => false,
            //         "message" => $farmPractises,
            //     ], Response::HTTP_BAD_REQUEST);
            // }
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
    public function store(StorePractise $request, $farmId)
    {
        $data = $request->only('fields', 'products', 'water', 'start_date', 'name');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $practise = $this->practiseService->create($data, $farm);
            return response()->json([
                "success" => true,
                "message" => "Practise created successfully.",
                'practise' => new PractiseResource($practise)
            ], Response::HTTP_CREATED);
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
    public function show($farmId, $practiseId)
    {
        $practise = $this->practiseService->find($practiseId);
        if (auth()->user()->id == $practise->farm->user_id) {
            return response()->json([
                "success" => true,
                "message" => "Practise retrieved successfully.",
                'practise' => new PractiseResource($practise)
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
    public function update(StorePractise $request, $farmId, $id)
    {
        $data = $request->only('fields', 'products', 'water', 'start_date', 'name');
        $farm = $this->farmService->find($farmId);
        $practise = $this->practiseService->find($id);
        if (auth()->user()->id == $farm->user_id) {
            $practise = $this->practiseService->update($data, $farm, $practise);
            return response()->json([
                "success" => true,
                "message" => "Practise updated successfully.",
                'practise' => new PractiseResource($practise)
            ], Response::HTTP_OK);
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
    public function destroy($id)
    {
        //
    }
}
