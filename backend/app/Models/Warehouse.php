<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [];
    /**
     * Get the farm that owns the warehouse.
     */
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * The cadastral parcels that belong to the field.
     */
    public function plantProtectionProducts()
    {
        return $this->belongsToMany(PlantProtectionProduct::class)->withPivot('quantity')->withTimestamps()->orderBy('quantity');
    }
}
