<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('crop_plantings.index') }}">Crop Plantings</a></li>
                <li class="text-primary">View Record</li>
            </ul>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="card-title text-2xl">Planting Record Details</h2>
                        <p class="text-base-content/70">Detailed information about this crop planting</p>
                    </div>
                    <div class="flex gap-2">
                        @can('manage crop planting')
                        <a href="{{ route('crop_plantings.edit', $cropPlanting) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Record
                        </a>
                        @endcan
                        <a href="{{ route('crop_plantings.index') }}" class="btn btn-ghost">Back to List</a>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Basic Information</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Farmer</p>
                                        <p class="font-medium">{{ $cropPlanting->farmer->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Assigned Technician</p>
                                        <p class="font-medium">{{ $cropPlanting->technician->name }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Category</p>
                                        <p class="font-medium">{{ $cropPlanting->category->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Crop</p>
                                        <p class="font-medium">{{ $cropPlanting->crop->name }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content/70">Variety</p>
                                    <p class="font-medium">{{ $cropPlanting->variety->name }}</p>
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
                    </div>

                    <!-- Planting Details -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Planting Details</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Area Planted</p>
                                        <p class="font-medium">{{ $cropPlanting->area_planted }} hectares</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Quantity</p>
                                        <p class="font-medium">{{ $cropPlanting->quantity }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Status</p>
                                        <p class="font-medium">{{ ucfirst($cropPlanting->status) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Growth Stage</p>
                                        <p class="font-medium">{{ ucwords($cropPlanting->remarks) }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Planting Date</p>
                                        <p class="font-medium">{{ $cropPlanting->planting_date }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Expected Harvest</p>
                                        <p class="font-medium">{{ $cropPlanting->expected_harvest_date }}</p>
                                    </div>
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

                    <!-- Map -->
                    <div class="card bg-base-200 md:col-span-2">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Location</h3>
                            <div id="map" class="w-full h-[400px] rounded-xl"></div>
                        </div>
                    </div>

                    <!-- Inspections -->
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
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const marinduqueBounds = L.latLngBounds(
            [13.1089, 121.7813],
            [13.5474, 122.2411]
        );

        const map = L.map('map', {
            center: [{{ $cropPlanting->latitude }}, {{ $cropPlanting->longitude }}],
            zoom: 15,
            minZoom: 10,
            maxZoom: 18,
            maxBounds: marinduqueBounds
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $cropPlanting->latitude }}, {{ $cropPlanting->longitude }}]).addTo(map);
    </script>
</x-app-layout>
