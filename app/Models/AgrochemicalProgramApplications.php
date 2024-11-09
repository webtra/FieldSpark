<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgrochemicalProgramApplications extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'application_date',
        'time',
        'tractor_start_hours',
        'tractor_end_hours',
        'tank_number',
        'liters_applied',
        'notes',
    ];

    public function agrochemicalProgram()
    {
        return $this->belongsTo(AgrochemicalPrograms::class, 'program_id');
    }

    public function crop()
    {
        return $this->belongsTo(Crops::class);
    }

    public function agrochemical()
    {
        return $this->belongsTo(Agrochemicals::class);
    }
}
