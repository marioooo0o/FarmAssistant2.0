<?php

namespace App\Http\Controllers;

use App\Http\Resources\Magazine as ResourcesMagazine;
use App\Http\Resources\MagazineResource;
use App\Models\Farm;
use App\Models\Magazine;
use App\Services\MagazineService;
use App\Models\User;
use App\Services\FarmService;
use Illuminate\Http\Request;

class MagazineController extends Controller
{
    private FarmService $farmService;
    private MagazineService $magazineService;


    /**
     * Create a new MagazineController instance.
     *
     * @return void
     */
    public function __construct(FarmService $farmService, MagazineService $magazineService)
    {
        $this->farmService = $farmService;
        $this->magazineService = $magazineService;
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
            $userMagazine = $farm->magazine;
            $magazine = $this->magazineService->create($data, $userMagazine);
            if ($magazine instanceof Magazine) {
                return response()->json([
                    "success" => true,
                    "message" => "Product added successfully.",
                    'magazine' => new MagazineResource($magazine),
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $magazine,
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
        $magazine = $this->magazineService->find($id);
        if (auth()->user()->id == $magazine->farm->user_id) {
            return response()->json([
                "success" => true,
                "message" => "Magazine retrieved successfully.",
                'magazine' => new MagazineResource($magazine)
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
            $userMagazine = $farm->magazine;
            $magazine = $this->magazineService->update($data, $userMagazine, $id);
            if ($magazine instanceof Magazine) {
                return response()->json([
                    "success" => true,
                    "message" => "Product updated successfully.",
                    'magazine' => new MagazineResource($magazine),
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $magazine,
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
            $userMagazine = $farm->magazine;
            $magazine = $this->magazineService->delete($userMagazine, $id);
            if ($magazine) {
                return response()->json([
                    "success" => true,
                    "message" => "Field deleted successfully."
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => $magazine,
                ], 400);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
