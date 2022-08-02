<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'street_number',
        'postal_code',
        'city',
        'area'
    ];
    /**
     * Get the user that owns the farm.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fields for the farm.
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
