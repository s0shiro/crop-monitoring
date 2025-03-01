<x-app-layout>
    <div data-turbo="false">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-base-200 to-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <!-- Breadcrumbs -->
                <div class="py-2 text-sm">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('dashboard') }}" class="text-base-content/70 hover:text-primary">Dashboard</a></li>
                            <li><a href="{{ route('crop_plantings.index') }}" class="text-base-content/70 hover:text-primary">Crop Plantings</a></li>
                            <li class="text-primary font-medium">View Record</li>
                        </ul>
                    </div>
                </div>

                <!-- Improved Title and Actions -->
                <div class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-12">
                                <span class="text-lg">{{ substr($cropPlanting->crop->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ $cropPlanting->crop->name }}</h1>
                            <p class="text-base-content/70">{{ $cropPlanting->variety->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @can('manage crop planting')
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-primary">
                                    Actions
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52">
                                    <li>
                                        <a href="{{ route('crop_plantings.edit', $cropPlanting) }}" class="text-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z" />
                                                <path fill-rule="evenodd" d="M11.293 5.793L3 14.086V17h2.914l8.293-8.293-2.914-2.914z" clip-rule="evenodd" />
                                            </svg>
                                            Edit Record
                                        </a>
                                    </li>
                                    @if($cropPlanting->status === 'standing')
                                        <li>
                                            <a href="{{ route('crop_inspections.create', $cropPlanting->id) }}" class="text-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Add Inspection
                                            </a>
                                        </li>
                                    @endif
                                    @if($cropPlanting->canBeHarvested())
                                        <li>
                                            <a href="{{ route('harvest_reports.create', $cropPlanting->id) }}" class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Record Harvest
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endcan
                        <a href="{{ route('crop_plantings.index') }}" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status and Quick Stats Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <!-- Status Badge -->
                            <div class="flex justify-end">
                                @switch($cropPlanting->status)
                                    @case('standing')
                                        <div class="badge badge-lg badge-success gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Standing
                                        </div>
                                        @break
                                    @case('harvest')
                                        <div class="badge badge-lg badge-warning gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            Ready to Harvest
                                        </div>
                                        @break
                                    @default
                                        <div class="badge badge-lg">{{ ucfirst($cropPlanting->status) }}</div>
                                @endswitch
                            </div>

                            <!-- Enhanced Stats Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="stats bg-base-200 shadow">
                                    <div class="stat p-4">
                                        <div class="stat-figure text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                        </div>
                                        <div class="stat-title">Area</div>
                                        <div class="stat-value text-primary text-2xl">{{ number_format($cropPlanting->area_planted, 2) }}</div>
                                        <div class="stat-desc">hectares</div>
                                    </div>
                                </div>

                                <div class="stats bg-base-200 shadow">
                                    <div class="stat p-4">
                                        <div class="stat-title">Days Active</div>
                                        <div class="stat-value text-2xl">{{ number_format($cropPlanting->planting_date->diffInDays(now()), 0) }}</div>
                                        <div class="stat-desc">since planting</div>
                                    </div>
                                </div>

                                <div class="stats bg-base-200 shadow">
                                    <div class="stat p-4">
                                        <div class="stat-title">Expected Harvest</div>
                                        <div class="stat-value text-secondary text-2xl">{{ $cropPlanting->expected_harvest_date->format('M d') }}</div>
                                        <div class="stat-desc">{{ $cropPlanting->expected_harvest_date->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body p-0">
                            <div id="map" class="w-full h-[400px] rounded-xl"></div>
                        </div>
                    </div>

                    <!-- Add this to your location information section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Location</span>
                            </label>
                            <div class="text-gray-600">
                                {{ $cropPlanting->barangay }}, {{ $cropPlanting->municipality }}
                                <br>
                                Coordinates: {{ $cropPlanting->latitude }}, {{ $cropPlanting->longitude }}
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    @if($cropPlanting->status === 'harvest' || $cropPlanting->status === 'partially harvested')
                    <div class="card bg-base-100 shadow-xl md:col-span-2">
                        <div class="card-body">
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="text-xl font-semibold">Harvest Progress</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Progress Stats -->
                                <div class="space-y-4">
                                    <div class="stats stats-vertical w-full bg-base-200">
                                        <div class="stat">
                                            <div class="stat-title">Area Planted</div>
                                            <div class="stat-value text-primary">{{ number_format($cropPlanting->area_planted, 2) }}</div>
                                            <div class="stat-desc">hectares</div>
                                        </div>

                                        <div class="stat">
                                            <div class="stat-title">Area Harvested</div>
                                            <div class="stat-value text-success">{{ number_format($cropPlanting->harvested_area, 2) }}</div>
                                            <div class="stat-desc">hectares</div>
                                        </div>

                                        <div class="stat">
                                            <div class="stat-title">Remaining Area</div>
                                            <div class="stat-value text-warning">{{ number_format($cropPlanting->remaining_area, 2) }}</div>
                                            <div class="stat-desc">hectares</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar and Action -->
                                <div class="flex flex-col justify-between">
                                    <div class="space-y-4">
                                        <div class="text-center">
                                            <div class="text-4xl font-bold text-primary mb-1">
                                                {{ number_format($cropPlanting->harvest_progress, 1) }}%
                                            </div>
                                            <div class="text-base-content/70">Overall Progress</div>
                                        </div>

                                        <div class="w-full bg-base-200 rounded-full h-4 relative overflow-hidden">
                                            <div class="absolute top-0 left-0 h-full bg-primary transition-all duration-500 rounded-full"
                                                style="width: {{ $cropPlanting->harvest_progress }}%"></div>
                                        </div>
                                    </div>

                                    @can('manage crop planting')
                                        @if($cropPlanting->canBeHarvested())
                                            <div class="mt-4 text-center">
                                                <a href="{{ route('harvest_reports.create', $cropPlanting->id) }}"
                                                class="btn btn-primary btn-wide gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Record New Harvest
                                                </a>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Inspections Table -->
                    <div class="card bg-base-200 md:col-span-2">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-semibold text-lg">Inspections</h3>
                                @if($cropPlanting->status === 'standing')
                                    @can('create inspections')
                                        <a href="{{ route('crop_inspections.create', $cropPlanting->id) }}"
                                           class="btn btn-primary btn-sm gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                            </svg>
                                            Add Inspection
                                        </a>
                                    @endcan
                                @endif
                            </div>

                            @if($cropPlanting->inspections->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="table w-full">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Technician</th>
                                                <th>Damaged Area</th>
                                                <th>Remarks</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cropPlanting->inspections as $inspection)
                                                <tr>
                                                    <td>{{ $inspection->inspection_date }}</td>
                                                    <td>{{ $inspection->technician->name }}</td>
                                                    <td>{{ $inspection->damaged_area }} ha</td>
                                                    <td>{{ Str::limit($inspection->remarks, 30) }}</td>
                                                    <td class="text-right">
                                                        @can('update inspections')
                                                        <a href="{{ route('crop_inspections.edit', $inspection->id) }}"
                                                           class="btn btn-ghost btn-xs">Edit</a>
                                                        @endcan
                                                        <a href="{{ route('crop_inspections.show', $inspection->id) }}"
                                                           class="btn btn-ghost btn-xs">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-base-content/70">
                                    No inspections recorded yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Harvest Reports Table -->
                    @if($cropPlanting->harvestReports->count() > 0)
                        <div class="card bg-base-200 md:col-span-2">
                            <div class="card-body">
                                <h3 class="font-semibold text-lg mb-4">Harvest Reports</h3>
                                <div class="overflow-x-auto">
                                    <table class="table w-full">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Area Harvested</th>
                                                <th>Total Yield</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cropPlanting->harvestReports as $report)
                                                <tr>
                                                    <td>{{ $report->harvest_date->format('M d, Y') }}</td>
                                                    <td>{{ number_format($report->area_harvested, 2) }} ha</td>
                                                    <td>{{ number_format($report->total_yield, 2) }} kg</td>
                                                    <td>
                                                        <a href="{{ route('harvest_reports.show', $report) }}"
                                                           class="btn btn-sm btn-ghost">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Details Column -->
                <div class="space-y-6 lg:sticky lg:top-4 lg:self-start">
                    <!-- Combined Information Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body space-y-6">
                            <!-- Stakeholders Section -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                    Stakeholders
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
                                                <span>{{ substr($cropPlanting->farmer->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $cropPlanting->farmer->name }}</p>
                                            <p class="text-sm text-base-content/70">Farmer</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-primary text-primary-content rounded-full w-10">
                                                <span>{{ substr($cropPlanting->technician->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $cropPlanting->technician->name }}</p>
                                            <p class="text-sm text-base-content/70">Technician</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Crop Details -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    Crop Details
                                </h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-base-content/70">Category</p>
                                            <p class="font-medium">{{ $cropPlanting->category->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-base-content/70">Variety</p>
                                            <p class="font-medium">{{ $cropPlanting->variety->name }}</p>
                                        </div>
                                    </div>

                                    @if($cropPlanting->category->name === 'High Value Crops' && $cropPlanting->hvcDetail)
                                        <div>
                                            <p class="text-sm text-base-content/70">Classification</p>
                                            <span class="badge badge-info">{{ $cropPlanting->hvcDetail->classification }}</span>
                                        </div>
                                    @elseif($cropPlanting->category->name === 'Rice' && $cropPlanting->riceDetail)
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-base-content/70">Water Supply</p>
                                                <span class="badge badge-info">{{ $cropPlanting->riceDetail->water_supply }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm text-base-content/70">Land Type</p>
                                                <span class="badge badge-ghost">{{ $cropPlanting->riceDetail->land_type }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Planting Information -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Planting Information
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Planting Date</p>
                                        <p class="font-medium">{{ $cropPlanting->planting_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Expected Harvest</p>
                                        <p class="font-medium">{{ $cropPlanting->expected_harvest_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Quantity</p>
                                        <p class="font-medium">{{ $cropPlanting->quantity }}</p>
                                    </div>
                                    @if($cropPlanting->expenses)
                                    <div>
                                        <p class="text-sm text-base-content/70">Expenses</p>
                                        <p class="font-medium">₱{{ number_format($cropPlanting->expenses, 2) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let map, marker;
            
            function initMap() {
                if (map) {
                    map.remove();
                }

                const marinduqueBounds = L.latLngBounds(
                    [13.1089, 121.7813],
                    [13.5474, 122.2411]
                );

                map = L.map('map', {
                    center: [{{ $cropPlanting->latitude }}, {{ $cropPlanting->longitude }}],
                    zoom: 15,
                    minZoom: 10,
                    maxZoom: 18,
                    maxBounds: marinduqueBounds
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                marker = L.marker([{{ $cropPlanting->latitude }}, {{ $cropPlanting->longitude }}]).addTo(map);

                // Force map to render properly
                requestAnimationFrame(() => {
                    map.invalidateSize();
                });
            }

            // Initialize map when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                initMap();
            });
        </script>
    </div>
</x-app-layout>
