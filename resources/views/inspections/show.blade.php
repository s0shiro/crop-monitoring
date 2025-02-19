<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('crop_inspections.index') }}">Inspections</a></li>
                <li class="text-primary">View Inspection</li>
            </ul>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="card-title text-2xl">Inspection Details</h2>
                        <p class="text-base-content/70">Inspection record for crop planting</p>
                    </div>
                    <a href="{{ route('crop_inspections.index') }}" class="btn btn-ghost">Back to List</a>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Inspection Information -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Inspection Information</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Inspection Date</p>
                                        <p class="font-medium">{{ $inspection->inspection_date }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Technician</p>
                                        <p class="font-medium">{{ $inspection->technician->name }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content/70">Damaged Area</p>
                                    <p class="font-medium">{{ $inspection->damaged_area }} hectares</p>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content/70">Remarks</p>
                                    <p class="font-medium">{{ $inspection->remarks ?? 'No remarks' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Crop Planting Details -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Crop Planting Details</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Farmer</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->farmer->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Area Planted</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->area_planted }} hectares</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Crop</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->crop->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Variety</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->variety->name }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-base-content/70">Planting Date</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->planting_date }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content/70">Expected Harvest</p>
                                        <p class="font-medium">{{ $inspection->cropPlanting->expected_harvest_date }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
