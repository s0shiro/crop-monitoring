<?php

namespace App\Http\Controllers;

use App\Models\CropPlanting;
use App\Models\Category;
use App\Models\RiceDetail;
use App\Models\HarvestReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function riceStandingReport()
    {
        // Get all standing rice crop plantings
        $riceCategoryId = Category::where('name', 'Rice')->value('id');
        
        $query = CropPlanting::with(['riceDetail', 'farmer'])
            ->where('category_id', $riceCategoryId)
            ->where('status', 'standing');
            
        // Apply role-based filters
        if (auth()->user()->hasRole('technician')) {
            $query->where('technician_id', auth()->id());
        } elseif (auth()->user()->hasRole('coordinator')) {
            // Get IDs of technicians under this coordinator
            $technicianIds = auth()->user()->technicians->pluck('id');
            $query->whereIn('technician_id', $technicianIds);
        }
        
        $plantings = $query->get();
        
        // Process data for the report
        $municipalities = ['Boac', 'Buenavista', 'Gasan', 'Mogpog', 'Santa Cruz', 'Torrijos'];
        $categories = ['irrigated', 'rainfed', 'upland'];
        $stages = [
            'Newly Planted',
            'Vegetative Stage',
            'Reproductive Stage',
            'Maturing Stage'
        ];
        
        // Initialize the data structure
        $processedData = [
            'Marinduque' => []
        ];
        
        foreach ($categories as $category) {
            $processedData['Marinduque'][$category] = [];
            foreach ($stages as $stage) {
                $processedData['Marinduque'][$category][$stage] = 0;
            }
            $processedData['Marinduque'][$category]['total'] = 0;
        }
        
        // Initialize municipality data with the same structure
        foreach ($municipalities as $municipality) {
            $processedData[$municipality] = [];
            foreach ($categories as $category) {
                $processedData[$municipality][$category] = [];
                foreach ($stages as $stage) {
                    $processedData[$municipality][$category][$stage] = 0;
                }
                $processedData[$municipality][$category]['total'] = 0;
            }
        }
        
        // Stage mapping based on remarks field - more flexible matching
        $stageMapping = [
            'newly planted' => 'Newly Planted',
            'seedling' => 'Newly Planted',
            'vegetative' => 'Vegetative Stage',
            'reproductive' => 'Reproductive Stage',
            'maturing' => 'Maturing Stage',
            'mature' => 'Maturing Stage',
        ];
        
        // Debug info
        $debugInfo = [];
        
        // Process each planting record
        foreach ($plantings as $planting) {
            $municipality = $planting->municipality;
            
            // Determine category based on water_supply and land_type
            if ($planting->riceDetail && $planting->riceDetail->water_supply === 'irrigated') {
                $category = 'irrigated';
            } elseif ($planting->riceDetail && $planting->riceDetail->land_type === 'upland') {
                $category = 'upland';
            } else {
                $category = 'rainfed';
            }
            
            // Determine stage from remarks
            $remarks = strtolower($planting->remarks);
            $stage = null;
            
            foreach ($stageMapping as $key => $value) {
                if (strpos($remarks, $key) !== false) {
                    $stage = $value;
                    break;
                }
            }
            
            // If no stage matched, use a default stage
            if (!$stage) {
                $stage = 'Newly Planted';
                
                // Add to debug info
                $debugInfo[] = "No stage match for: {$planting->id}, remarks: {$planting->remarks}";
            }
            
            // Add data to the appropriate categories
            $processedData[$municipality][$category][$stage] += $planting->area_planted;
            $processedData[$municipality][$category]['total'] += $planting->area_planted;
            
            // Add to Marinduque totals
            $processedData['Marinduque'][$category][$stage] += $planting->area_planted;
            $processedData['Marinduque'][$category]['total'] += $planting->area_planted;
        }
        
        // For debugging purposes, we'll send the debug info to the view
        // You can display this temporarily to diagnose issues
        
        return view('reports.rice_standing', [
            'data' => $processedData,
            'municipalities' => array_merge(['Marinduque'], $municipalities),
            'categories' => $categories,
            'stages' => array_merge($stages, ['TOTAL']),
            'currentDate' => Carbon::now()->format('F d, Y'),
            'user' => Auth::user(),
            'debugInfo' => $debugInfo  // Remove this after debugging
        ]);
    }

    public function riceHarvestingReport(Request $request)
    {
        // Get default dates for the current season if not provided
        $today = Carbon::today();
        $startDate = $request->input('start_date', $today->copy()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', $today->format('Y-m-d'));
        
        // Set default selections
        $selectedMunicipality = $request->input('municipality', 'Boac');
        $selectedWaterSupply = $request->input('water_supply', 'irrigated');
        
        // All municipalities in Marinduque
        $municipalities = ['Boac', 'Buenavista', 'Gasan', 'Mogpog', 'Santa Cruz', 'Torrijos'];
        $waterSupplyTypes = ['irrigated', 'rainfed', 'upland', 'total'];
        
        // Get rice category ID
        $riceCategoryId = Category::where('name', 'Rice')->value('id');
        
        // Initialize query to get harvest reports
        $query = HarvestReport::with([
                'cropPlanting.farmer',
                'cropPlanting.riceDetail',
                'cropPlanting.variety',
            ])
            ->whereHas('cropPlanting', function($q) use ($riceCategoryId) {
                $q->where('category_id', $riceCategoryId);
            })
            ->whereBetween('harvest_date', [$startDate, $endDate]);
            
        // Apply role-based filters
        if (auth()->user()->hasRole('technician')) {
            $query->whereHas('cropPlanting', function($q) {
                $q->where('technician_id', auth()->id());
            });
        } elseif (auth()->user()->hasRole('coordinator')) {
            // Get IDs of technicians under this coordinator
            $technicianIds = auth()->user()->technicians->pluck('id');
            $query->whereHas('cropPlanting', function($q) use ($technicianIds) {
                $q->whereIn('technician_id', $technicianIds);
            });
        }
        
        // Get the data
        $harvestReports = $query->get();
        
        // Process the data for the report
        $processedData = $this->processHarvestData(
            $harvestReports, 
            $selectedMunicipality,
            $selectedWaterSupply
        );
        
        // Calculate season and year
        $startDateObj = Carbon::parse($startDate);
        $seasonAndYear = $this->getSeasonAndYear($startDateObj);
        
        return view('reports.rice_harvesting', [
            'processedData' => $processedData,
            'selectedMunicipality' => $selectedMunicipality,
            'selectedWaterSupply' => $selectedWaterSupply,
            'municipalities' => $municipalities,
            'waterSupplyTypes' => $waterSupplyTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'seasonAndYear' => $seasonAndYear,
            'dateRange' => $this->formatDateRange($startDate, $endDate),
            'user' => auth()->user(),
        ]);
    }
    
    private function processHarvestData($harvestReports, $selectedMunicipality, $selectedWaterSupply)
    {
        $processedData = [];
        
        // Group data by barangay
        foreach ($harvestReports as $report) {
            $cropPlanting = $report->cropPlanting;
            
            // Skip if not matching the selected municipality
            if ($cropPlanting->municipality !== $selectedMunicipality) {
                continue;
            }
            
            $barangay = $cropPlanting->barangay;
            $farmer = $cropPlanting->farmer;
            $farmerId = $farmer->id;
            
            // Get rice details
            $riceDetail = $cropPlanting->riceDetail;
            $waterSupply = $riceDetail ? $riceDetail->water_supply : 'rainfed';
            $landType = $riceDetail ? $riceDetail->land_type : 'lowland';
            
            // Skip based on water supply filter
            if ($selectedWaterSupply !== 'total') {
                if ($selectedWaterSupply === 'upland' && $landType !== 'upland') {
                    continue;
                }
                if ($selectedWaterSupply !== 'upland' && $waterSupply !== $selectedWaterSupply) {
                    continue;
                }
            }
            
            // Get classification directly from rice_detail
            $classification = $riceDetail ? $riceDetail->classification : 'Good Quality';
            
            // Update mapping to exactly match the values in create.blade.php rice_classification select options
            $seedTypeMap = [
                'Hybrid' => 'hybridSeeds',
                'Registered' => 'registeredSeeds',
                'Certified' => 'certifiedSeeds',
                'Good Quality' => 'goodQualitySeeds',
                'Farmer Saved Seeds' => 'farmerSavedSeeds'
            ];
            
            // Add debug logging
            \Log::info("Processing classification: {$classification}");
            
            // Match exact classification value
            $seedType = $seedTypeMap[$classification] ?? 'goodQualitySeeds';
            
            \Log::info("Mapped to seedType: {$seedType}");
            
            // Initialize barangay data if not exists
            if (!isset($processedData[$barangay])) {
                $processedData[$barangay] = [
                    'farmerIds' => [],
                    'noOfFarmerHarvested' => 0,
                    'hybridSeeds' => ['area' => 0, 'averageYield' => 0, 'production' => 0],
                    'registeredSeeds' => ['area' => 0, 'averageYield' => 0, 'production' => 0],
                    'certifiedSeeds' => ['area' => 0, 'averageYield' => 0, 'production' => 0],
                    'goodQualitySeeds' => ['area' => 0, 'averageYield' => 0, 'production' => 0],
                    'farmerSavedSeeds' => ['area' => 0, 'averageYield' => 0, 'production' => 0],
                ];
            }
            
            // Add farmer ID if not already counted
            if (!in_array($farmerId, $processedData[$barangay]['farmerIds'])) {
                $processedData[$barangay]['farmerIds'][] = $farmerId;
                $processedData[$barangay]['noOfFarmerHarvested'] += 1;
            }
            
            // Calculate area and production from the harvest report
            $area = floatval($report->area_harvested);
            
            // Check if we should use total_yield or yield_quantity
            if (isset($report->total_yield)) {
                // If total_yield exists, use that (in kg)
                $yieldQuantity = floatval($report->total_yield);
            } else if (isset($report->yield_quantity)) {
                // If yield_quantity exists, use that (in kg)
                $yieldQuantity = floatval($report->yield_quantity);
            } else {
                // Fallback to 0 if no yield data is available
                $yieldQuantity = 0;
            }
            
            // Convert kg to metric tons
            $production = $yieldQuantity / 1000;
            
            // Debug logging to verify classifications are mapping correctly
            \Log::debug("Rice classification mapping: {$classification} → {$seedType}");
            
            // Update seed type data
            $processedData[$barangay][$seedType]['area'] += $area;
            $processedData[$barangay][$seedType]['production'] += $production;
        }
        
        // Calculate average yield for each seed type
        foreach ($processedData as $barangay => &$barangayData) {
            foreach (['hybridSeeds', 'registeredSeeds', 'certifiedSeeds', 'goodQualitySeeds', 'farmerSavedSeeds'] as $seedType) {
                $area = $barangayData[$seedType]['area'];
                $production = $barangayData[$seedType]['production'];
                
                // Only calculate average yield if area is greater than zero
                if ($area > 0) {
                    $barangayData[$seedType]['averageYield'] = $production / $area;
                } else {
                    $barangayData[$seedType]['averageYield'] = 0;
                }
            }
        }
        
        // Sort barangays alphabetically
        ksort($processedData);
        
        return $processedData;
    }
    
    private function getSeasonAndYear(Carbon $date)
    {
        $month = $date->month;
        $year = $date->year;
        
        // Determine season based on month
        $season = '';
        if ($month >= 5 && $month <= 10) {
            $season = 'WET SEASON';
        } else {
            $season = 'DRY SEASON';
        }
        
        return $season . ' ' . $year;
    }
    
    private function formatDateRange($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        if ($start->month === $end->month && $start->year === $end->year) {
            return $start->format('F Y');
        } else {
            return $start->format('M d') . ' - ' . $end->format('M d, Y');
        }
    }
}
