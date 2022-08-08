<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantProtectionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permit_number',
        'permit_deadline',
        'sale_deadline',
        'term_for_use',
        'type',
        'active_substance',
        'plant',
        'pest',
        'dose',
        'recommended_dose',
        'maximum_dose',
        'unit',
        'deadline',
        'group_name',
        'small_area',
        'application',
    ];

    protected $casts = [
        'type' => 'array',
        'plant' => 'array',
        'pest' => 'array',
        'group_name' => 'array',


    ];
}
