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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this line

class CropPlantingController extends Controller
{
    use AuthorizesRequests; // Add this line

    public function index()
    {
        $query = CropPlanting::with(['farmer', 'crop', 'variety']);

        // If user is technician, only show their records
        if (auth()->user()->hasRole('technician')) {
            $query->where('technician_id', auth()->id());
        }

        $plantings = $query->paginate(10); // Use paginate instead of get
        return view('crop_plantings.index', compact('plantings'));
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

        $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'category_id' => 'required|exists:categories,id',
            'crop_id' => 'required|exists:crops,id',
            'variety_id' => 'required|exists:varieties,id',
            'planting_date' => 'required|date',
            'area_planted' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'expenses' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'location' => 'required|string',
            'status' => 'required|in:standing,harvest,harvested',
        ]);

        $maturityDays = Variety::where('id', $request->variety_id)->value('maturity_days');
        $expectedHarvestDate = $maturityDays ? Carbon::parse($request->planting_date)->addDays($maturityDays) : null;

        CropPlanting::create([
            'farmer_id' => $request->farmer_id,
            'category_id' => $request->category_id,
            'crop_id' => $request->crop_id,
            'variety_id' => $request->variety_id,
            'planting_date' => $request->planting_date,
            'expected_harvest_date' => $expectedHarvestDate,
            'area_planted' => $request->area_planted,
            'quantity' => $request->quantity,
            'expenses' => $request->expenses,
            'technician_id' => Auth::id(),
            'remarks' => $request->remarks,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('crop_plantings.index')->with('success', 'Crop planting record added.');
    }

    public function edit(CropPlanting $cropPlanting)
    {
        $this->authorize('update', $cropPlanting);

        // If technician, only show assigned farmers
        if (auth()->user()->hasRole('technician')) {
            $farmers = Farmer::where('technician_id', auth()->id())->get();
        } else {
            $farmers = Farmer::all();
        }

        $categories = Category::with('crops.varieties')->get();
        return view('crop_plantings.edit', compact('cropPlanting', 'farmers', 'categories'));
    }

    public function update(Request $request, CropPlanting $cropPlanting)
    {
        $this->authorize('update', $cropPlanting);
        $this->validateFarmerAccess($request->farmer_id);

        $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'category_id' => 'required|exists:categories,id',
            'crop_id' => 'required|exists:crops,id',
            'variety_id' => 'required|exists:varieties,id',
            'planting_date' => 'required|date',
            'area_planted' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'expenses' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'location' => 'required|string',
            'status' => 'required|in:standing,harvest,harvested',
        ]);

        $maturityDays = Variety::where('id', $request->variety_id)->value('maturity_days');
        $expectedHarvestDate = $maturityDays ? \Carbon\Carbon::parse($request->planting_date)->addDays($maturityDays) : null;

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
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('crop_plantings.index')->with('success', 'Crop planting record updated.');
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
