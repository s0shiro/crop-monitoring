<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $associations = Association::all();
        return view('associations.index', compact('associations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('associations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:associations,name',
            'description' => 'nullable|string',
        ]);

        Association::create($request->all());

        return redirect()->route('associations.index')->with('success', 'Association created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        $farmers = $association->farmers()->get();
        return view('associations.show', compact('association', 'farmers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Association $association)
    {
        return view('associations.edit', compact('association'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Association $association)
    {
        $request->validate([
            'name' => 'required|string|unique:associations,name,' . $association->id,
            'description' => 'nullable|string',
        ]);

        $association->update($request->all());

        return redirect()->route('associations.index')->with('success', 'Association updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        $association->delete();
        return redirect()->route('associations.index')->with('success', 'Association deleted successfully.');
    }
}
