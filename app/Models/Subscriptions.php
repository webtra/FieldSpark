<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_users',
        'max_teams',
        'additional_user_charge',
        'additional_team_charge',
    ];

    // A subscription can have many teams (organizations)
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
