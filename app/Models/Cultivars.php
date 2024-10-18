<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivars extends Model
{
    use HasFactory;

    protected $fillable = [
        'prime_name',
        'variety_number',
        'country',
        'color_of_berry_skin',
        'country_of_origin',
        'species',
    ];
}
