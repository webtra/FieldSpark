<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgrochemicalPrograms extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'agrochemical_id',
        'name',
        'planned_application_date',
    ];

    public function crop()
    {
        return $this->belongsTo(Crops::class);
    }

    // Relationship to the Agrochemical model
    public function agrochemical()
    {
        return $this->belongsTo(Agrochemicals::class);
    }
}
