<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'storeroom_id',
        'name',
        'unit',
        'size',
        'description',
        'recommended_dosage',
        'category',
        'application_method',
        'toxicity_level',
        'restricted_use',
        'recommended_application_frequency',
        'reentry_interval',
        'pre_harvest_interval',
        'safety_precautions',
        'mixing_compatibility',
        'mixing_order',
        'mixing_category',
        'msds_file_path',
    ];

    protected $casts = [
        'restricted_use' => 'boolean'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function storeroom()
    {
        return $this->belongsTo(Storerooms::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventories::class);
    }
}
