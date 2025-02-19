<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CropInspection;
use App\Models\CropPlanting;
use Illuminate\Support\Facades\Auth;

class CropInspectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = CropInspection::with('cropPlanting.farmer', 'technician');

        if ($user->hasRole('technician')) {
            // Technician can only see their own inspections
            $query->where('technician_id', $user->id);
        } elseif ($user->hasRole('coordinator')) {
            // Coordinator can see inspections from their technicians
            $technicianIds = $user->technicians->pluck('id');
            $query->whereIn('technician_id', $technicianIds);
        }
        // Admin can see all inspections (no additional filter needed)

        $inspections = $query->latest()->get();
        return view('inspections.index', compact('inspections'));
    }

    public function create($plantingId)
    {
        $planting = CropPlanting::findOrFail($plantingId);

        if (Auth::user()->hasRole('technician') && Auth::id() !== $planting->technician_id) {
            abort(403, 'Unauthorized');
        }

        return view('inspections.create', compact('planting'));
    }

    public function store(Request $request, $plantingId)
    {
        $request->validate([
            'inspection_date' => 'required|date',
            'remarks' => 'nullable|string',
            'damaged_area' => 'required|numeric|min:0',
        ]);

        $planting = CropPlanting::findOrFail($plantingId);

        if (Auth::user()->hasRole('technician') && Auth::id() !== $planting->technician_id) {
            abort(403, 'Unauthorized');
        }

        CropInspection::create([
            'crop_planting_id' => $plantingId,
            'technician_id' => Auth::id(),
            'inspection_date' => $request->inspection_date,
            'remarks' => $request->remarks,
            'damaged_area' => $request->damaged_area,
        ]);

        return redirect()->route('crop_plantings.show', $plantingId)->with('success', 'Inspection recorded successfully.');
    }

    public function edit(CropInspection $inspection)
    {
        if (Auth::user()->hasRole('technician') && Auth::id() !== $inspection->technician_id) {
            abort(403, 'Unauthorized');
        }

        return view('inspections.edit', compact('inspection'));
    }

    public function update(Request $request, CropInspection $inspection)
    {
        if (Auth::user()->hasRole('technician') && Auth::id() !== $inspection->technician_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'inspection_date' => 'required|date',
            'remarks' => 'nullable|string',
            'damaged_area' => 'required|numeric|min:0',
        ]);

        $inspection->update([
            'inspection_date' => $request->inspection_date,
            'remarks' => $request->remarks,
            'damaged_area' => $request->damaged_area,
        ]);

        return redirect()
            ->route('crop_plantings.show', $inspection->crop_planting_id)
            ->with('success', 'Inspection updated successfully.');
    }

    public function show($id)
    {
        $inspection = CropInspection::with(['cropPlanting.farmer', 'technician'])->findOrFail($id);
        return view('inspections.show', compact('inspection'));
    }
}
