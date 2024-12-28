<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storerooms extends Model
{
    use SoftDeletes;

    protected $table = 'storerooms';

    protected $fillable = [
        'team_id',
        'name',
        'country',
        'city',
        'state',
        'zip_code',
        'status',
        'is_default',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
