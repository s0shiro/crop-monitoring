<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Standing Crop Report') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prepared by</label>
                            <input type="text" disabled class="input input-sm input-bordered w-full" value="{{ strtoupper($user->name) }}" />
                            <p class="text-xs text-gray-500 mt-1">{{ $user->position ?? 'Agricultural Technician' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Date</label>
                            <input type="text" disabled class="input input-sm input-bordered w-full" value="{{ $currentDate }}" />
                        </div>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <label class="block text-sm font-medium text-gray-700 mb-2">Signature Settings</label>
                    <div class="grid grid-cols-2 gap-4">
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

            <!-- Debug Info -->
            @if(isset($debugInfo) && count($debugInfo) > 0)
            <div class="alert alert-info shadow-sm mb-6 non-printable py-2">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-5 h-5 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="ml-2">
                        <p class="text-xs font-medium">{{ count($plantings ?? []) }} rice plantings with standing status found.</p>
                        <details class="mt-1">
                            <summary class="text-xs cursor-pointer">View debug details</summary>
                            <ul class="text-xs mt-1 pl-4 list-disc">
                                @foreach($debugInfo as $info)
                                    <li>{{ $info }}</li>
                                @endforeach
                            </ul>
                        </details>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Bond paper container - Keep this exactly as it was for the preview -->
    <div class="bond-paper-container">
        <div class="printable-area" id="printable-report">
            <div class="text-center mb-4">
                <p class="report-title m-0">RICE</p>
                <p class="report-title m-0">STANDING CROP</p>
                <p class="report-subtitle">As of {{ $currentDate }}</p>
            </div>
            
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <p class="m-0"><strong>REGION: IV - MIMAROPA</strong></p>
                    <p class="m-0"><strong>PROVINCE: MARINDUQUE</strong></p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle municipality-header">MUNICIPALITY</th>
                            @foreach($categories as $category)
                                <th colspan="5" class="text-center {{ $category }}-header">
                                    {{ strtoupper($category) }} (ha)
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($categories as $category)
                                @foreach($stages as $stage)
                                    <th class="text-center {{ $category }}-cell">{{ $stage }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($municipalities as $municipality)
                            <tr class="{{ $municipality === 'Marinduque' ? 'total-row' : '' }}">
                                <td class="location-cell">{{ $municipality }}</td>
                                @foreach($categories as $category)
                                    @foreach($stages as $stage)
                                        <td class="text-center">
                                            @php
                                                $value = $stage === 'TOTAL' 
                                                    ? $data[$municipality][$category]['total'] 
                                                    : $data[$municipality][$category][$stage];
                                                echo $value > 0 ? number_format($value, 4) : '';
                                            @endphp
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
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

    <style>
        /* Bond paper styling - Keep this exactly as it was for the preview */
        .bond-paper-container {
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 0.5in;
            margin: 20px auto;
            width: 11in; /* Letter width */
            height: 8.5in; /* Letter height */
            position: relative;
            z-index: 1;
        }

        .printable-area {
            width: 100%;
            height: 100%;
            font-size: 12px;
            font-family: Arial, sans-serif;
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
            margin-bottom: 20px;
        }
        
        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 3px 6px;
            font-size: 10px;
        }
        
        .municipality-header {
            width: 120px;
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
        
        .irrigated-cell {
            background-color: #FFF5E6;
        }
        
        .rainfed-cell {
            background-color: #E6F3FF;
        }
        
        .upland-cell {
            background-color: #E6FFE6;
        }
        
        .location-cell {
            text-align: left;
            padding-left: 10px;
        }
        
        /* Print styles - Updated to preserve colors and rotate content */
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
                padding: 0.25in;
            }
            
            /* Preserve background colors and borders when printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            /* Keep table colors in print */
            .irrigated-header, .irrigated-cell {
                background-color: #FFF5E6 !important;
            }
            
            .rainfed-header, .rainfed-cell {
                background-color: #E6F3FF !important;
            }
            
            .upland-header, .upland-cell {
                background-color: #E6FFE6 !important;
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
            
            .non-printable, #debug-info {
                display: none !important;
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
