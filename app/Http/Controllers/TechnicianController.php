<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index()
    {
        return view('technician.dashboard');
    }
}
