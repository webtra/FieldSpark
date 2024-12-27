<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Types extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'name',
        'description'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function varieties()
    {
        return $this->hasMany(Varieties::class);
    }
}
