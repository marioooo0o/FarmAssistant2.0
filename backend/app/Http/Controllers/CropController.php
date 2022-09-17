<?php

namespace App\Http\Controllers;

use App\Http\Resources\CropCollection;
use Illuminate\Http\Request;
use App\Services\CropService;
use App\Models\Crop;

class CropController extends Controller
{

    private CropService $cropService;
    public function __construct(CropService $cropService)
    {
        $this->cropService = $cropService;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crops = $this->cropService->getAll();
        return response()->json([
            'success' => true,
            'message' => 'All crops get successfully',
            'crops' => new CropCollection($crops),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $crop = new Crop();
        $crop->name = $request->name;
        if ($request->file('crop')) {
            $imageFullName = $request->file('crop')->getClientOriginalName();
            $crop->image_path = $request->file('crop')->storeAs('crops', $imageFullName);
        }
        $crop->save();
        return response()->json([
            "success" => true,
            "message" => "Crop created successfully.",
            'crop' => $crop
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
