<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;
use Illuminate\Support\Facades\Gate;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crops = Crop::all();
        return view('crops.index', compact('crops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create-crops')) abort(403);

        return view('crops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-crops')) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Crop::create($request->all());

        return redirect()->route('crops.index')->with('success', 'Crop added successfully.');
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
    public function edit(Crop $crop)
    {
        if (!Gate::allows('update-crops')) abort(403);

        return view('crops.edit', compact('crop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crop $crop)
    {
        if (!Gate::allows('update-crops')) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $crop->update($request->all());

        return redirect()->route('crops.index')->with('success', 'Crop updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crop $crop)
    {
        if (!Gate::allows('delete-crops')) abort(403);

        $crop->delete();

        return redirect()->route('crops.index')->with('success', 'Crop deleted successfully.');
    }
}
