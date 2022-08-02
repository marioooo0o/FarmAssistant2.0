<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_name', 'field_area',
    ];

    /**
     * Get the farm that owns the field.
     */
    public function farm()
    {
        return $this->belongsTo('App\Models\Farm');
    }

    /**
     * The cadastral parcels that belong to the field.
     */
    public function cadastralParcels()
    {
        return $this->belongsToMany(CadastralParcel::class)->withPivot('area')->withTimestamps();
    }

    public function sumFieldArea()
    {
        return $this->cadastralParcels->sum('pivot.area');
    }
}
