<?php

namespace App\Services;

use App\Models\Crop;

class CropService
{
    public function getAll()
    {
        return Crop::all();
    }
}
