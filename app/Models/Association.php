<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }
}
