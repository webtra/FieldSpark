<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crops extends Model
{
    use HasFactory;

    protected $fillable = [
        'cultivar_id',
        'block_number',
        'planting_date',
        'harvest_date',
        'location',
        'status',
        'size',
    ];

    public function cultivar()
    {
        return $this->belongsTo(Cultivars::class);
    }
}
