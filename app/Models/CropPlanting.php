<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CropPlanting extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'category_id',
        'crop_id',
        'variety_id',
        'planting_date',
        'expected_harvest_date',
        'area_planted',
        'quantity',
        'expenses',
        'technician_id',
        'remarks',
        'location',
        'status',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
