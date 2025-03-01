<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiceDetail extends Model
{
    protected $fillable = ['crop_planting_id', 'water_supply', 'land_type', 'classification'];

    // Add constants for classification values to ensure consistency
    const CLASSIFICATIONS = [
        'Hybrid',
        'Registered',
        'Certified',
        'Good Quality',
        'Farmer Saved Seeds'
    ];

    public function cropPlanting()
    {
        return $this->belongsTo(CropPlanting::class);
    }

    // Add accessor to ensure consistent classification format
    public function getClassificationAttribute($value)
    {
        return $value ?? 'Good Quality';
    }
}
