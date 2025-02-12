<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;
use Illuminate\Support\Facades\Gate;
use App\Models\Variety;

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
            'name' => 'required|string|max:255|unique:crops,name,NULL,id,category,' . $request->category,
            'category' => 'required|string|max:255',
            'varieties' => 'nullable|array',
            'varieties.*' => 'nullable|string|max:255',
        ]);

        // Create new crop
        $crop = Crop::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);


        // Store multiple varieties linked to the crop
        if ($request->varieties) {
            foreach ($request->varieties as $varietyName) {
                if ($varietyName) {
                    Variety::create([
                        'name' => $varietyName,
                        'category' => $request->category,
                        'crop_id' => $crop->id,
                    ]);
                }
            }
        }

        return redirect()->route('crops.index')->with('success', 'Crop and varieties added successfully.');
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
            'varieties' => 'nullable|array',
            'varieties.*' => 'nullable|string|max:255',
        ]);

        // Check if a crop with the new name already exists in the same category
        $existingCrop = Crop::where('name', $request->name)
                            ->where('category', $request->category)
                            ->where('id', '!=', $crop->id) // Exclude current crop
                            ->first();

        if ($existingCrop) {
            return redirect()->back()->withErrors(['name' => 'This crop already exists in this category!']);
        }

        // Update crop details
        $crop->update([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        // Sync varieties
        $crop->varieties()->delete(); // Remove old varieties
        if ($request->varieties) {
            foreach ($request->varieties as $varietyName) {
                if ($varietyName) {
                    Variety::create([
                        'name' => $varietyName,
                        'category' => $request->category,
                        'crop_id' => $crop->id,
                    ]);
                }
            }
        }

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

    public function getByCategory(Request $request)
    {
        $request->validate(['category' => 'required|string']);

        $crops = Crop::where('category', $request->category)->get(['id', 'name']);

        return response()->json($crops);
    }


}
