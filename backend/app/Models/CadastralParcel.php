<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastralParcel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parcel_number',
        'parcel_area',
        'soil_Ph'
    ];

    /**
     * The fields that belong to the cadastral parcel.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('area')->withTimestamps();
    }

    public function sumParcelArea()
    {
        return $this->fields->sum('pivot.area');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00',
    ];
}
