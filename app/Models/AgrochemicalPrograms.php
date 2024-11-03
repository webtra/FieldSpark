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
        'planned_application_date',
        'application_date',
        'application_time',
        'tractor_hours_start',
        'tractor_hours_end',
        'tank_number',
        'liters_sprayed',
        'operator_name',
        'application_sheet_generated',
        'application_sheet_link',
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
