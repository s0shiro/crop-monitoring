<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;
use Illuminate\Support\Facades\Gate;
use App\Models\Variety;
use App\Models\Category;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crops = Crop::with(['category', 'varieties'])->get();
        return view('crops.index', compact('crops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create-crops')) abort(403);

        $categories = Category::all();
        return view('crops.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-crops')) abort(403);

        $request->validate([
            'name' => 'required|string|max:255|unique:crops,name,NULL,id,category_id,' . $request->category_id, // Changed from category to category_id
            'category_id' => 'required|exists:categories,id', // Changed validation rule
            'varieties' => 'nullable|array',
            'varieties.*' => 'nullable|string|max:255',
            'maturity_days' => 'required|array',
            'maturity_days.*' => 'required|integer|min:1',
        ]);

        // Create new crop
        $crop = Crop::create([
            'name' => $request->name,
            'category_id' => $request->category_id, // Changed from category to category_id
        ]);

        // Store multiple varieties linked to the crop
        if ($request->varieties) {
            foreach ($request->varieties as $index => $varietyName) {
                if ($varietyName) {
                    Variety::create([
                        'name' => $varietyName,
                        'crop_id' => $crop->id,
                        'maturity_days' => $request->maturity_days[$index] ?? null,
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

        $categories = Category::all();
        return view('crops.edit', compact('crop', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crop $crop)
    {
        if (!Gate::allows('update-crops')) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'varieties' => 'nullable|array',
            'varieties.*' => 'nullable|string|max:255',
            'maturity_days' => 'required|array',
            'maturity_days.*' => 'required|integer|min:1',
        ]);

        // Check if a crop with the new name already exists in the same category
        $existingCrop = Crop::where('name', $request->name)
                            ->where('category_id', $request->category_id) // Changed from category to category_id
                            ->where('id', '!=', $crop->id)
                            ->first();

        if ($existingCrop) {
            return redirect()->back()->withErrors(['name' => 'This crop already exists in this category!']);
        }

        // Update crop details
        $crop->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // Sync varieties
        $crop->varieties()->delete();
        if ($request->varieties) {
            foreach ($request->varieties as $index => $varietyName) {
                if ($varietyName) {
                    Variety::create([
                        'name' => $varietyName,
                        'crop_id' => $crop->id,
                        'maturity_days' => $request->maturity_days[$index] ?? null,
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
        $request->validate(['category_id' => 'required|exists:categories,id']);

        $crops = Crop::where('category_id', $request->category_id)->get(['id', 'name']);

        return response()->json($crops);
    }


}
