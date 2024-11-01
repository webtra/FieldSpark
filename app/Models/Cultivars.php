<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivars extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'growth_season',
        'maturity_days',
        'yield_potential',
        'water_requirements',
        'soil_type',
        'plant_spacing',
        'root_depth',
        'notes'
    ];

    public function crops()
    {
        return $this->hasMany(Crops::class);
    }
}
