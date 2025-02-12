<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Association;

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
        return view('farmers.create', compact('associations'));
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
            'barangay' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'association_id' => 'nullable|exists:associations,id',
        ]);

        Farmer::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'rsbsa' => $request->rsbsa,
            'landsize' => $request->landsize,
            'barangay' => $request->barangay,
            'municipality' => $request->municipality,
            'association_id' => $request->association_id,
            'technician_id' => Auth::id(),
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
        if (Auth::user()->hasRole('technician') && $farmer->technician_id !== Auth::id()) {
            abort(403);
        }

        $associations = Association::all();
        return view('farmers.edit', compact('farmer', 'associations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {
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
        ]);

        $farmer->update($request->all());

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
