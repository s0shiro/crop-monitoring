<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Association;
use App\Models\User;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admins see all farmers, Technicians see only their assigned farmers
        $query = Auth::user()->hasRole('admin')
            ? Farmer::query()
            : Farmer::where('technician_id', Auth::id());

        $farmers = $query->with('association')->latest()->paginate(10);

        return view('farmers.index', compact('farmers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $associations = Association::all();

        // If the logged-in user is an Admin, fetch all Technicians
        $technicians = [];
        if (Auth::user()->hasRole('admin')) {
            $technicians = User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->get();
        }

        return view('farmers.create', compact('associations', 'technicians'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'rsbsa' => 'nullable|string|max:255',
            'landsize' => 'nullable|numeric|min:0',
            'barangay' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'association_id' => 'nullable|exists:associations,id',
            'technician_id' => 'nullable|exists:users,id', // Allow Admin to assign Technician
        ]);

        // Determine Technician assignment
        $technicianId = Auth::user()->hasRole('admin') ? $request->technician_id : Auth::id();

        Farmer::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'rsbsa' => $request->rsbsa,
            'landsize' => $request->landsize,
            'barangay' => $request->barangay,
            'municipality' => $request->municipality,
            'association_id' => $request->association_id,
            'technician_id' => $technicianId, // Assign selected or logged-in Technician
        ]);

        return redirect()->route('farmers.index')->with('success', 'Farmer added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farmer $farmer)
    {
        // Restrict technicians from editing farmers that are not assigned to them
        if (Auth::user()->hasRole('technician') && $farmer->technician_id !== Auth::id()) {
            abort(403);
        }

        $associations = Association::all();

        // Load technicians only if the user is an Admin
        $technicians = Auth::user()->hasRole('admin')
            ? User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->get()
            : null;

        return view('farmers.edit', compact('farmer', 'associations', 'technicians'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {
        // Restrict technicians from updating farmers not assigned to them
        if (Auth::user()->hasRole('technician') && $farmer->technician_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'rsbsa' => 'nullable|string|max:255',
            'landsize' => 'nullable|numeric|min:0',
            'barangay' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'association_id' => 'nullable|exists:associations,id',
            'technician_id' => 'nullable|exists:users,id|required_if:role,admin', // Allow Admins to change Technician
        ]);

        // Allow only Admins to update the technician_id
        if (Auth::user()->hasRole('admin')) {
            $farmer->update($request->all());
        } else {
            // Technicians cannot change technician_id, only update their assigned farmers
            $farmer->update($request->except('technician_id'));
        }

        return redirect()->route('farmers.index')->with('success', 'Farmer updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farmer $farmer)
    {
        if (Auth::user()->hasRole('technician') && $farmer->technician_id !== Auth::id()) {
            abort(403);
        }

        $farmer->delete();
        return redirect()->route('farmers.index')->with('success', 'Farmer deleted successfully.');
    }
}
