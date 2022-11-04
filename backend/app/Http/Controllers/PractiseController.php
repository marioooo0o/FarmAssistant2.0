<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePractise;
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
    public function store(StorePractise $request, $farmId)
    {
        $data = $request->only('fields', 'products', 'water', 'start_date', 'name');
        $farm = $this->farmService->find($farmId);
        if (auth()->user()->id == $farm->user_id) {
            $practise = $this->practiseService->create($data, $farm);
            return response()->json([
                "success" => true,
                "message" => "Practise created successfully.",
                'field' => $practise
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
