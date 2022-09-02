<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFarmRequest;
use App\Http\Resources\FarmResource;
use App\Services\FarmService;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource_;

class FarmController extends Controller
{
    private FarmService $farmService;

    /**
     * Create a new FarmController instance.
     *
     * @return void
     */
    public function __construct(FarmService $farmService)
    {
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
    public function store(StoreFarmRequest $request)
    {
        $data = $request->only(
            'name',
            'street',
            'street_number',
            'postal_code',
            'city',
        );
        $farm = $this->farmService->create($data, $request->user()->id);

        return response()->json([
            "success" => true,
            "message" => "Farm created successfully.",
            'farm' => new FarmResource($farm)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $farm = $this->farmService->find($id);
        if (auth()->user()->id == $farm->user_id) {
            return response()->json([
                "success" => true,
                "message" => "Farm retrieved successfully.",
                'farm' => new FarmResource($farm)
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
    public function update(Request $request, $id)
    {
        $farm = $this->farmService->find($id);
        if (auth()->user()->id == $farm->user_id) {
            $data = $request->only(
                'name',
                'street',
                'street_number',
                'postal_code',
                'city',
            );
            $farm = $this->farmService->update($data, $id);
            return response()->json([
                "success" => true,
                "message" => "Farm updated successfully.",
                'farm' => new FarmResource($farm),
            ]);
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
    public function destroy($id)
    {
        $farm = $this->farmService->find($id);
        if (auth()->user()->id == $farm->user_id) {
            $this->farmService->delete($id);
            return response()->json([
                "success" => true,
                "message" => "Farm deleted successfully.",
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
