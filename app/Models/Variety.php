<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'crop_id', 'maturity_days'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function category()
    {
        return $this->hasOneThrough(Category::class, Crop::class);
    }
}
