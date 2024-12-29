<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prices extends Model
{
    use SoftDeletes;

    protected $table = 'prices';

    protected $fillable = [
        'team_id',
        'item_id',
        'inventory_id',
        'price',
        'date'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventories::class, 'inventory_id', 'id');
    }
}
