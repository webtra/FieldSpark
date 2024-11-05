<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agrochemicals extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'recommended_dosage',
        'category',
        'manufacturer',
        'application_method',
        'toxicity_level',
        'restricted_use',
        'recommended_application_frequency',
        'reentry_interval',
        'pre_harvest_interval',
        'storage_instructions',
        'safety_precautions',
        'mixing_compatibility',
        'mixing_order',
        'mixing_category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'recommended_dosage' => 'decimal:2',
        'restricted_use' => 'boolean',
        'reentry_interval' => 'integer',
        'pre_harvest_interval' => 'integer',
    ];

    /**
     * The attributes with ENUM values that can be set in the model.
     */
    const CATEGORIES = [
        'Herbicide',
        'Pesticide',
        'Fungicide',
        'Fertilizer',
        'Growth Regulator'
    ];

    const APPLICATION_METHODS = [
        'Spray',
        'Granular',
        'Drip',
        'Foliar'
    ];

    const TOXICITY_LEVELS = [
        'Low',
        'Medium',
        'High'
    ];

    protected static $mixingOrderMapping = [
        'Water' => 1,
        'Water Quality Regulators' => 2,
        'Water-Soluble Packets' => 3,
        'Dry Formulations' => 4,
        'Suspension Concentrates' => 5,
        'Emulsifiable Concentrates' => 6,
        'Adhesives' => 7,
        'Water-Soluble Liquids' => 8,
        'Foliar Feedings' => 9,
    ];

    protected static function boot()
    {
        parent::boot();

        // Assign `mixing_order` automatically before saving
        static::saving(function ($agrochemical) {
            if (isset($agrochemical->mixing_category)) {
                $agrochemical->mixing_order = self::$mixingOrderMapping[$agrochemical->mixing_category] ?? null;
            }
        });
    }

    public function agrochemicalPrograms()
    {
        return $this->hasMany(AgrochemicalPrograms::class);
    }
}
