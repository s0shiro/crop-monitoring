<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'crop_id'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
