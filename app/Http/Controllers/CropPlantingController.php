<?php

namespace App\Http\Controllers;

use App\Models\CropPlanting;
use App\Models\Farmer;
use App\Models\Category;
use App\Models\Crop;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\HvcDetail;
use App\Models\RiceDetail;

class CropPlantingController extends Controller
{
    use AuthorizesRequests; // Add this line

    public function index(Request $request)
    {
        $query = CropPlanting::with(['farmer', 'crop', 'variety', 'category', 'hvcDetail', 'riceDetail']);

        // Apply role-based filters
        if (auth()->user()->hasRole('technician')) {
            $query->where('technician_id', auth()->id());
        } elseif (auth()->user()->hasRole('coordinator')) {
            // Get IDs of technicians under this coordinator
            $technicianIds = auth()->user()->technicians->pluck('id');
            $query->whereIn('technician_id', $technicianIds);
        }
        // Admin can see all records (no filter needed)

        // Rest of the existing filters
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('farmer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('crop', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->date_from) {
            $query->whereDate('planting_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('planting_date', '<=', $request->date_to);
        }

        // Get counts for status badges (using the filtered query)
        $standingCount = (clone $query)->where('status', 'standing')->count();
        $harvestCount = (clone $query)->where('status', 'harvest')->count();
        $partiallyHarvestedCount = (clone $query)->where('status', 'partially harvested')->count();
        $harvestedCount = (clone $query)->where('status', 'harvested')->count();

        $categories = Category::all();
        $plantings = $query->latest()->paginate(10);

        return view('crop_plantings.index', compact(
            'plantings',
            'categories',
            'standingCount',
            'harvestCount',
            'partiallyHarvestedCount',
            'harvestedCount'
        ));
    }

    public function create()
    {
        // If technician, only show assigned farmers
        if (auth()->user()->hasRole('technician')) {
            $farmers = Farmer::where('technician_id', auth()->id())->get();
        } else {
            $farmers = Farmer::all();
        }

        $categories = Category::with('crops.varieties')->get();
        return view('crop_plantings.create', compact('farmers', 'categories'));
    }

    public function store(Request $request)
    {
        $this->validateFarmerAccess($request->farmer_id);

        $categoryName = Category::findOrFail($request->category_id)->name;

        // Create custom validation rules based on category
        $validationRules = [
            'farmer_id' => 'required|exists:farmers,id',
            'category_id' => 'required|exists:categories,id',
            'crop_id' => 'required|exists:crops,id',
            'variety_id' => 'required|exists:varieties,id',
            'planting_date' => 'required|date',
            'area_planted' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'expenses' => 'nullable|numeric|min:0',
            'remarks' => 'required|string',
            'status' => 'required|in:standing,harvest,harvested',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'municipality' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
        ];

        // Add category-specific validation
        if ($categoryName === 'High Value Crops') {
            $validationRules['hvc_classification'] = 'required|string';
        } elseif ($categoryName === 'Rice') {
            $validationRules['rice_classification'] = 'required|string';
            $validationRules['water_supply'] = 'required|string';
            $validationRules['land_type'] = 'nullable|string';
        }

        $request->validate($validationRules);

        try {
            DB::transaction(function () use ($request, $categoryName) {
                $maturityDays = Variety::where('id', $request->variety_id)->value('maturity_days');
                $expectedHarvestDate = $maturityDays ? Carbon::parse($request->planting_date)->addDays($maturityDays) : null;

                $cropPlanting = CropPlanting::create([
                    'farmer_id' => $request->farmer_id,
                    'category_id' => $request->category_id,
                    'crop_id' => $request->crop_id,
                    'variety_id' => $request->variety_id,
                    'planting_date' => $request->planting_date,
                    'expected_harvest_date' => $expectedHarvestDate,
                    'area_planted' => $request->area_planted,
                    'harvested_area' => 0,
                    'remaining_area' => $request->area_planted,
                    'quantity' => $request->quantity,
                    'expenses' => $request->expenses,
                    'technician_id' => Auth::id(),
                    'remarks' => $request->remarks,
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                ]);

                // Handle category-specific details
                if ($categoryName === 'High Value Crops') {
                    HvcDetail::create([
                        'crop_planting_id' => $cropPlanting->id,
                        'classification' => $request->hvc_classification
                    ]);
                } elseif ($categoryName === 'Rice') {
                    RiceDetail::create([
                        'crop_planting_id' => $cropPlanting->id,
                        'classification' => $request->rice_classification,
                        'water_supply' => $request->water_supply,
                        'land_type' => $request->land_type
                    ]);
                }
            });

            return redirect()->route('crop_plantings.index')
                ->with('success', 'Crop planting record added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating record: ' . $e->getMessage());
        }
    }

    public function edit(CropPlanting $cropPlanting)
    {
        $this->authorize('update', $cropPlanting);

        $cropPlanting->load(['hvcDetail', 'riceDetail']); // Add this line

        if (auth()->user()->hasRole('technician')) {
            $farmers = Farmer::where('technician_id', auth()->id())->get();
        } else {
            $farmers = Farmer::all();
        }

        $categories = Category::with('crops.varieties')->get();
        return view('crop_plantings.edit', compact('cropPlanting', 'farmers', 'categories'));
    }

    public function show(CropPlanting $cropPlanting)
    {
        $cropPlanting->load(['farmer', 'category', 'crop', 'variety', 'technician', 'hvcDetail', 'riceDetail']);
        return view('crop_plantings.show', compact('cropPlanting'));
    }

    public function update(Request $request, CropPlanting $cropPlanting)
    {
        $this->authorize('update', $cropPlanting);
        $this->validateFarmerAccess($request->farmer_id);

        $categoryName = Category::findOrFail($request->category_id)->name;

        // Create custom validation rules based on category
        $validationRules = [
            'farmer_id' => 'required|exists:farmers,id',
            'category_id' => 'required|exists:categories,id',
            'crop_id' => 'required|exists:crops,id',
            'variety_id' => 'required|exists:varieties,id',
            'planting_date' => 'required|date',
            'area_planted' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'expenses' => 'nullable|numeric|min:0',
            'remarks' => 'required|string',
            'status' => 'required|in:standing,harvest,harvested',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'municipality' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
        ];

        // Add category-specific validation
        if ($categoryName === 'High Value Crops') {
            $validationRules['hvc_classification'] = 'required|string';
        } elseif ($categoryName === 'Rice') {
            $validationRules['rice_classification'] = 'required|string';
            $validationRules['water_supply'] = 'required|string';
            $validationRules['land_type'] = 'nullable|string';
        }

        $request->validate($validationRules);

        try {
            DB::transaction(function () use ($request, $cropPlanting, $categoryName) {
                $maturityDays = Variety::where('id', $request->variety_id)->value('maturity_days');
                $expectedHarvestDate = $maturityDays ? Carbon::parse($request->planting_date)->addDays($maturityDays) : null;

                $cropPlanting->update([
                    'farmer_id' => $request->farmer_id,
                    'category_id' => $request->category_id,
                    'crop_id' => $request->crop_id,
                    'variety_id' => $request->variety_id,
                    'planting_date' => $request->planting_date,
                    'expected_harvest_date' => $expectedHarvestDate,
                    'area_planted' => $request->area_planted,
                    'quantity' => $request->quantity,
                    'expenses' => $request->expenses,
                    'remarks' => $request->remarks,
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                ]);

                // Handle category-specific details
                if ($categoryName === 'High Value Crops') {
                    HvcDetail::updateOrCreate(
                        ['crop_planting_id' => $cropPlanting->id],
                        ['classification' => $request->hvc_classification]
                    );
                    // Delete any existing rice details if category changed
                    RiceDetail::where('crop_planting_id', $cropPlanting->id)->delete();
                } elseif ($categoryName === 'Rice') {
                    RiceDetail::updateOrCreate(
                        ['crop_planting_id' => $cropPlanting->id],
                        [
                            'classification' => $request->rice_classification,
                            'water_supply' => $request->water_supply,
                            'land_type' => $request->land_type
                        ]
                    );
                    // Delete any existing hvc details if category changed
                    HvcDetail::where('crop_planting_id', $cropPlanting->id)->delete();
                }
            });

            return redirect()->route('crop_plantings.index')
                ->with('success', 'Crop planting record updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating record: ' . $e->getMessage());
        }
    }

    public function destroy(CropPlanting $cropPlanting)
    {
        $this->authorize('delete', $cropPlanting);
        $cropPlanting->delete();
        return redirect()->route('crop_plantings.index')->with('success', 'Crop planting record deleted.');
    }

    protected function validateFarmerAccess($farmerId)
    {
        if (auth()->user()->hasRole('technician')) {
            $farmer = Farmer::where('id', $farmerId)
                          ->where('technician_id', auth()->id())
                          ->firstOrFail();
        }
    }
}
