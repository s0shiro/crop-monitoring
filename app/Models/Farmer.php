<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'rsbsa', 'landsize', 'barangay', 'municipality', 'technician_id'];


    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
