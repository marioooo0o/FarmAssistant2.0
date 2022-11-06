<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity', 'water', 'start'
    ];

    /**
     * The fields that belong to the practise.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

    /**
     * The plant protection products that belong to the practise.
     */
    public function plantProtectionProducts()
    {
        return $this->belongsToMany(PlantProtectionProduct::class)->withPivot('quantity')->withTimestamps();
    }

    /**
     * Get the farm that owns the practise.
     */
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
