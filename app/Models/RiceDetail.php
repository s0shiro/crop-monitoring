<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiceDetail extends Model
{
    protected $fillable = ['crop_planting_id', 'water_supply', 'land_type'];

    public function cropPlanting()
    {
        return $this->belongsTo(CropPlanting::class);
    }
}
