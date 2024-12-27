<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Varieties extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'team_id',
        'type_id',
        'yield_potential',
        'water_requirements',
        'soil_type',
        'plant_spacing',
        'row_spacing',
        'root_depth',
        'growth_season',
    ];

    public function type()
    {
        return $this->belongsTo(Types::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function fields()
    {
        return $this->hasMany(Fields::class);
    }
}
