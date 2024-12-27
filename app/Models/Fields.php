<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fields extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'variety_id',
        'name',
        'size',
        'status',
        'planted_at',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function variety()
    {
        return $this->belongsTo(Varieties::class);
    }

    public function type()
    {
        return $this->hasOneThrough(
            Types::class,    // Final model to access
            Varieties::class, // Intermediate model
            'id',            // Foreign key on `varieties` table (e.g., `variety_id`)
            'id',            // Foreign key on `types` table (e.g., `type_id`)
            'variety_id',    // Local key on `fields` table
            'type_id'        // Local key on `varieties` table
        );
    }

}
