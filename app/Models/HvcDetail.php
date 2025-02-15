<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HvcDetail extends Model
{
    protected $fillable = ['crop_planting_id', 'classification'];

    public function cropPlanting()
    {
        return $this->belongsTo(CropPlanting::class);
    }
}
