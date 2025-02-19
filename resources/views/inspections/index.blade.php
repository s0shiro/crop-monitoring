<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-base-content">Crop Inspection Monitor</h2>
            <p class="text-base-content/70">Overview of all crop inspections across plantings</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Total Inspections</div>
                <div class="stat-value text-primary">{{ $inspections->count() }}</div>
                <div class="stat-desc">Across all plantings</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Total Damaged Area</div>
                <div class="stat-value text-error">{{ number_format($inspections->sum('damaged_area'), 2) }} ha</div>
                <div class="stat-desc">Cumulative damage reported</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Recent Inspections</div>
                <div class="stat-value text-info">{{ $inspections->where('inspection_date', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-desc">In the last 7 days</div>
            </div>
        </div>

        <!-- Inspections Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Farmer</th>
                                <th>Crop</th>
                                <th>Location</th>
                                <th>Damaged Area</th>
                                <th>Technician</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspections as $inspection)
                            <tr class="hover">
                                <td>{{ $inspection->inspection_date }}</td>
                                <td>{{ $inspection->cropPlanting->farmer->name }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <span>{{ $inspection->cropPlanting->crop->name }}</span>
                                        <span class="text-xs text-base-content/70">{{ $inspection->cropPlanting->variety->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('crop_plantings.show', $inspection->cropPlanting) }}"
                                       class="link link-primary">View Planting</a>
                                </td>
                                <td>
                                    <span class="@if($inspection->damaged_area > 0) text-error @endif">
                                        {{ number_format($inspection->damaged_area, 2) }} ha
                                    </span>
                                </td>
                                <td>{{ $inspection->technician->name }}</td>
                                <td class="text-right">
                                    <a href="{{ route('crop_inspections.show', $inspection) }}"
                                       class="btn btn-ghost btn-xs">Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
