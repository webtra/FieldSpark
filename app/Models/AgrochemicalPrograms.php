<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgrochemicalPrograms extends Model
{
    use HasFactory;

    protected $fillable = [
        'planned_application_date',
        'crop_id',
        'agrochemical_id',
        'name',
    ];

    public function crop()
    {
        return $this->belongsTo(Crops::class);
    }

    // Original relationship for the agrochemical
    public function agrochemical()
    {
        return $this->belongsTo(Agrochemicals::class);
    }

    // Original relationship name preserved
    public function agrochemicalProgramApplications()
    {
        return $this->hasMany(AgrochemicalProgramApplications::class, 'program_id');
    }
}
