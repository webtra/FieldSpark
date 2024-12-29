<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventories extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'storeroom_id',
        'item_id',
        'quantity'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function storeroom()
    {
        return $this->belongsTo(Storerooms::class, 'storeroom_id');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function prices()
    {
        return $this->hasMany(Prices::class);
    }
}
