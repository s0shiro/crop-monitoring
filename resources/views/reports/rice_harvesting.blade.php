<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Harvesting Report') }}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="mx-auto px-2 sm:px-4 lg:px-4">
            <!-- Report Controls Card -->
            <div class="card bg-base-100 shadow-sm mb-6">
                <div class="card-body p-4">
                    <div class="flex flex-wrap justify-between items-center mb-3">
                        <h2 class="text-base font-medium text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Report Settings
                        </h2>

                        <button class="btn btn-sm btn-primary" id="print-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print
                        </button>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <form action="{{ route('reports.rice-harvesting') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Municipality</label>
                                <select name="municipality" class="select select-bordered select-sm w-full">
                                    @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality }}" {{ $selectedMunicipality == $municipality ? 'selected' : '' }}>
                                            {{ $municipality }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Water Supply Type</label>
                                <select name="water_supply" class="select select-bordered select-sm w-full">
                                    @foreach($waterSupplyTypes as $type)
                                        <option value="{{ $type }}" {{ $selectedWaterSupply == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Start Date</label>
                                        <input type="date" name="start_date" class="input input-bordered input-sm w-full" value="{{ $startDate }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">End Date</label>
                                        <input type="date" name="end_date" class="input input-bordered input-sm w-full" value="{{ $endDate }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="btn btn-sm btn-success w-full">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="divider my-2"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prepared by</label>
                            <input type="text" disabled class="input input-sm input-bordered w-full" value="{{ strtoupper($user->name) }}" />
                            <p class="text-xs text-gray-500 mt-1">{{ $user->position ?? 'Agricultural Technician' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Signature Settings</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Noted By</label>
                                    <input type="text" id="notedByName" placeholder="Enter name" value="VANESSA TAYABA" class="input input-sm input-bordered w-full" />
                                </div>
                                
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Title</label>
                                    <input type="text" id="notedByTitle" placeholder="Enter title" value="Municipal Agricultural Officer" class="input input-sm input-bordered w-full" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bond paper container for the report -->
            <div class="bond-paper-container">
                <div class="printable-area" id="printable-report">
                    <div class="text-center mb-4">
                        <p class="report-title m-0">RICE HARVESTING REPORT</p>
                        <p class="report-title m-0">HARVESTING ACCOMPLISHMENT REPORT</p>
                        <p class="report-title m-0">{{ $seasonAndYear }}</p>
                        <p class="report-subtitle">For the Month of: {{ $dateRange }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <p class="m-0"><strong>REGION: IV - MIMAROPA</strong></p>
                            <p class="m-0"><strong>PROVINCE: MARINDUQUE</strong></p>
                            <p class="m-0"><strong>MUNICIPALITY: {{ strtoupper($selectedMunicipality) }}</strong></p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="align-middle border">BARANGAY</th>
                                    <th rowspan="3" class="align-middle border">No. of Farmer Harvested</th>
                                    <th colspan="18" class="text-center border 
                                        @if($selectedWaterSupply == 'irrigated') irrigated-header
                                        @elseif($selectedWaterSupply == 'rainfed') rainfed-header
                                        @elseif($selectedWaterSupply == 'upland') upland-header
                                        @else total-header @endif">
                                        {{ strtoupper($selectedWaterSupply) }}
                                    </th>
                                </tr>
                                <tr>
                                    @foreach(['HYBRID SEEDS', 'REGISTERED SEEDS', 'CERTIFIED SEEDS', 'GOOD QUALITY SEEDS', 'FARMER SAVED SEEDS', 'TOTAL'] as $seedType)
                                        <th colspan="3" class="border text-center">{{ $seedType }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach(range(1, 6) as $i)
                                        <th class="border text-center">Area<br>(ha)</th>
                                        <th class="border text-center">Average Yield<br>(mt/ha)</th>
                                        <th class="border text-center">Production<br>(mt)</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($processedData) > 0)
                                    @foreach($processedData as $barangay => $data)
                                        <tr>
                                            <td class="border">{{ $barangay }}</td>
                                            <td class="border text-center">{{ $data['noOfFarmerHarvested'] }}</td>
                                            
                                            @php
                                                $seedTypes = ['hybridSeeds', 'registeredSeeds', 'certifiedSeeds', 'goodQualitySeeds', 'farmerSavedSeeds'];
                                                $totalArea = 0;
                                                $totalProduction = 0;
                                                
                                                // Calculate totals
                                                foreach($seedTypes as $seedType) {
                                                    $totalArea += $data[$seedType]['area'];
                                                    $totalProduction += $data[$seedType]['production'];
                                                }
                                                
                                                // Calculate average yield for the row total
                                                $totalAverageYield = $totalArea > 0 ? ($totalProduction / $totalArea) : 0;
                                            @endphp
                                            
                                            @foreach($seedTypes as $seedType)
                                                <td class="border text-center">
                                                    @if($data[$seedType]['area'] > 0)
                                                        {{ number_format($data[$seedType]['area'], 3) }}
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($data[$seedType]['area'] > 0)
                                                        {{ number_format($data[$seedType]['averageYield'], 3) }}
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($data[$seedType]['production'] > 0)
                                                        {{ number_format($data[$seedType]['production'], 3) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            
                                            <!-- Total columns -->
                                            <td class="border text-center">
                                                @if($totalArea > 0)
                                                    {{ number_format($totalArea, 3) }}
                                                @endif
                                            </td>
                                            <td class="border text-center">
                                                @if($totalArea > 0)
                                                    {{ number_format($totalAverageYield, 3) }}
                                                @endif
                                            </td>
                                            <td class="border text-center">
                                                @if($totalProduction > 0)
                                                    {{ number_format($totalProduction, 3) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <!-- Municipality Total Row -->
                                    <tr class="total-row">
                                        <td class="border">TOTAL</td>
                                        @php
                                            // Calculate municipality totals
                                            $uniqueFarmerIds = [];
                                            
                                            $municipalityTotals = [
                                                'hybridSeeds' => ['area' => 0, 'production' => 0, 'averageYield' => 0],
                                                'registeredSeeds' => ['area' => 0, 'production' => 0, 'averageYield' => 0],
                                                'certifiedSeeds' => ['area' => 0, 'production' => 0, 'averageYield' => 0],
                                                'goodQualitySeeds' => ['area' => 0, 'production' => 0, 'averageYield' => 0],
                                                'farmerSavedSeeds' => ['area' => 0, 'production' => 0, 'averageYield' => 0],
                                            ];
                                            
                                            foreach($processedData as $barangayData) {
                                                // Add unique farmer IDs
                                                foreach($barangayData['farmerIds'] as $farmerId) {
                                                    if(!in_array($farmerId, $uniqueFarmerIds)) {
                                                        $uniqueFarmerIds[] = $farmerId;
                                                    }
                                                }
                                                
                                                // Add seed type data
                                                foreach($seedTypes as $seedType) {
                                                    $municipalityTotals[$seedType]['area'] += $barangayData[$seedType]['area'];
                                                    $municipalityTotals[$seedType]['production'] += $barangayData[$seedType]['production'];
                                                }
                                            }
                                            
                                            // Calculate average yields for each seed type in the totals row
                                            foreach($seedTypes as $seedType) {
                                                $area = $municipalityTotals[$seedType]['area'];
                                                $production = $municipalityTotals[$seedType]['production'];
                                                $municipalityTotals[$seedType]['averageYield'] = $area > 0 ? ($production / $area) : 0;
                                            }
                                            
                                            // Calculate grand total area and production
                                            $grandTotalArea = 0;
                                            $grandTotalProduction = 0;
                                            
                                            foreach($seedTypes as $seedType) {
                                                $grandTotalArea += $municipalityTotals[$seedType]['area'];
                                                $grandTotalProduction += $municipalityTotals[$seedType]['production'];
                                            }
                                            
                                            $grandTotalAverageYield = $grandTotalArea > 0 ? ($grandTotalProduction / $grandTotalArea) : 0;
                                        @endphp
                                        
                                        <td class="border text-center">{{ count($uniqueFarmerIds) }}</td>
                                        
                                        @foreach($seedTypes as $seedType)
                                            <td class="border text-center">
                                                @if($municipalityTotals[$seedType]['area'] > 0)
                                                    {{ number_format($municipalityTotals[$seedType]['area'], 3) }}
                                                @endif
                                            </td>
                                            <td class="border text-center">
                                                @if($municipalityTotals[$seedType]['area'] > 0)
                                                    {{ number_format($municipalityTotals[$seedType]['averageYield'], 3) }}
                                                @endif
                                            </td>
                                            <td class="border text-center">
                                                @if($municipalityTotals[$seedType]['production'] > 0)
                                                    {{ number_format($municipalityTotals[$seedType]['production'], 3) }}
                                                @endif
                                            </td>
                                        @endforeach
                                        
                                        <!-- Grand Total columns -->
                                        <td class="border text-center">
                                            @if($grandTotalArea > 0)
                                                {{ number_format($grandTotalArea, 3) }}
                                            @endif
                                        </td>
                                        <td class="border text-center">
                                            @if($grandTotalArea > 0)
                                                {{ number_format($grandTotalAverageYield, 3) }}
                                            @endif
                                        </td>
                                        <td class="border text-center">
                                            @if($grandTotalProduction > 0)
                                                {{ number_format($grandTotalProduction, 3) }}
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="20" class="text-center py-4 border">
                                            No harvesting data available for {{ $selectedMunicipality }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="signature-section">
                        <div class="signature-block">
                            <p>Prepared by:</p>
                            <div class="signature-line"></div>
                            <p class="font-weight-bold">{{ strtoupper($user->name) }}</p>
                            <p>{{ $user->position ?? 'Agricultural Technician' }}</p>
                        </div>
                        <div class="signature-block">
                            <p>Noted by:</p>
                            <div class="signature-line"></div>
                            <p class="font-weight-bold" id="noted-by-name">VANESSA TAYABA</p>
                            <p id="noted-by-title">Municipal Agricultural Officer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Add these new styles for select elements at the top of your style section */
        .select-bordered {
            height: auto !important;
            min-height: 2rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            line-height: 1.2;
        }

        .select select {
            height: auto !important;
        }

        /* Fix select option text */
        .select option {
            padding: 8px;
            line-height: 1.2;
            font-size: 0.875rem;
        }

        /* Rest of existing styles */
        .bond-paper-container {
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 0.5in;  /* Match rice_standing padding */
            margin: 20px 0;
            width: 100%;
            max-width: 11in;
            height: 8.5in; /* Letter height */
            position: relative;
            z-index: 1;
            overflow: visible;
        }

        .printable-area {
            width: 100%;
            height: 100%;
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 0;  /* Remove padding */
            margin: 0;  /* Remove margin */
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .report-subtitle {
            font-size: 14px;
            font-weight: bold;
        }
        
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;  /* Remove margin */
        }
        
        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 2px 4px;  /* Reduced padding */
            font-size: 9px;  /* Slightly smaller font */
        }
        
        .table-responsive {
            padding: 0;  /* Remove padding */
            margin: 0;  /* Remove margin */
            overflow: visible;  /* Prevent scrollbars */
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        
        .signature-block {
            width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid black;
            width: 100%;
            margin: 20px 0 5px 0;
        }
        
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .irrigated-header {
            background-color: #FFF5E6;
        }
        
        .rainfed-header {
            background-color: #E6F3FF;
        }
        
        .upland-header {
            background-color: #E6FFE6;
        }
        
        .total-header {
            background-color: #F0F0F0;
        }
        
        /* Print styles - Updated to match rice_standing.blade.php */
        @media print {
            body * {
                visibility: hidden;
            }
            
            .bond-paper-container, #printable-report, #printable-report * {
                visibility: visible;
            }
            
            /* Position the bond paper */
            .bond-paper-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 8.5in; /* Portrait width */
                height: 11in; /* Portrait height */
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            /* Rotate the content inside the bond paper */
            #printable-report {
                transform: rotate(90deg);
                transform-origin: center center;
                width: 11in;
                height: 8.5in;
                padding: 0.25in; /* Match rice_standing print padding */
                margin: 0;
            }
            
            /* Preserve background colors and borders when printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            /* Keep table colors in print */
            .irrigated-header {
                background-color: #FFF5E6 !important;
            }
            
            .rainfed-header {
                background-color: #E6F3FF !important;
            }
            
            .upland-header {
                background-color: #E6FFE6 !important;
            }
            
            .total-header {
                background-color: #F0F0F0 !important;
            }
            
            .total-row {
                background-color: #f8f9fa !important;
                font-weight: bold !important;
            }
            
            /* Ensure borders are visible */
            .report-table th, .report-table td {
                border: 1px solid black !important;
            }
            
            /* Set page to portrait but content will be rotated */
            @page {
                size: portrait;
                margin: 0;
            }
            
            .non-printable {
                display: none !important;
            }
            
            .signature-section {
                margin-top: 30px; /* Adjust signature spacing */
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printBtn = document.getElementById('print-btn');
            const notedByNameInput = document.getElementById('notedByName');
            const notedByTitleInput = document.getElementById('notedByTitle');
            const notedByNameDisplay = document.getElementById('noted-by-name');
            const notedByTitleDisplay = document.getElementById('noted-by-title');
            
            // Simple print functionality (exactly like rice_standing.blade.php)
            printBtn.addEventListener('click', function() {
                window.print();
            });
            
            notedByNameInput.addEventListener('input', function() {
                notedByNameDisplay.textContent = this.value.toUpperCase();
            });
            
            notedByTitleInput.addEventListener('input', function() {
                notedByTitleDisplay.textContent = this.value;
            });
        });
    </script>
</x-app-layout>
