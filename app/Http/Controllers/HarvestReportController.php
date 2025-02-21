<?php

namespace App\Http\Controllers;

use App\Models\CropPlanting;
use App\Models\HarvestReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HarvestReportController extends Controller
{
    public function index()
    {
        $reports = HarvestReport::with(['cropPlanting.farmer', 'cropPlanting.crop', 'technician'])
            ->latest()
            ->paginate(10);

        return view('harvest_reports.index', compact('reports'));
    }

    public function create($plantingId)
    {
        $cropPlanting = CropPlanting::findOrFail($plantingId);

        if (!$cropPlanting->canBeHarvested()) {
            return back()->with('error', 'This crop cannot be harvested at this time.');
        }

        return view('harvest_reports.create', [
            'cropPlanting' => $cropPlanting,
            'availableArea' => $cropPlanting->remaining_area,
            'harvestProgress' => $cropPlanting->harvest_progress
        ]);
    }

    public function store(Request $request, $plantingId)
    {
        $cropPlanting = CropPlanting::findOrFail($plantingId);

        if (!$cropPlanting->canBeHarvested()) {
            return back()->with('error', 'This crop cannot be harvested at this time.');
        }

        $validated = $request->validate([
            'harvest_date' => 'required|date',
            'area_harvested' => [
                'required',
                'numeric',
                'min:0.01',
                "max:{$cropPlanting->remaining_area}"
            ],
            'total_yield' => 'required|numeric|min:0',
            'profit' => 'nullable|numeric|min:0',
            'damage_quantity' => 'nullable|numeric|min:0'
        ]);

        return DB::transaction(function() use ($validated, $cropPlanting) {
            // Create harvest report
            $report = HarvestReport::create([
                'crop_planting_id' => $cropPlanting->id,
                'technician_id' => Auth::id(),
                'harvest_date' => $validated['harvest_date'],
                'area_harvested' => $validated['area_harvested'],
                'total_yield' => $validated['total_yield'],
                'profit' => $validated['profit'] ?? 0,
                'damage_quantity' => $validated['damage_quantity'] ?? 0
            ]);

            // Update crop planting areas and status
            $cropPlanting->updateHarvestAreas($validated['area_harvested']);

            return redirect()
                ->route('crop_plantings.show', $cropPlanting)
                ->with('success', sprintf(
                    'Harvest recorded successfully. %.2f ha harvested, %.2f ha remaining.',
                    $validated['area_harvested'],
                    $cropPlanting->remaining_area
                ));
        });
    }

    public function show(HarvestReport $report)
    {
        return view('harvest_reports.show', compact('report'));
    }
}
