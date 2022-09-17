<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Crop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image_path'
    ];

    /**
     * Get the fields for the crop.
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    /**
     * The plant protection products that belong to the crop.
     */
    public function plantProtectionProducts()
    {
        return $this->belongsToMany(PlantProtectionProduct::class)->withTimestamps();
    }

    public function getCropAttribute($value)
    {
        return Storage::url('crops/' . $value);
    }
}
