<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Harvest Report Details') }}
            </h2>
            <a href="{{ route('harvest_reports.index') }}" class="btn btn-ghost">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Crop and Farmer Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-medium mb-4">Crop Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Crop:</span> {{ $report->cropPlanting->crop->name }}</p>
                                <p><span class="font-medium">Variety:</span> {{ $report->cropPlanting->variety->name }}</p>
                                <p><span class="font-medium">Farmer:</span> {{ $report->cropPlanting->farmer->name }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-4">Harvest Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Date:</span> {{ $report->harvest_date->format('F d, Y') }}</p>
                                <p><span class="font-medium">Technician:</span> {{ $report->technician->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Harvest Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="stats bg-base-200 shadow">
                            <div class="stat">
                                <div class="stat-title">Area Harvested</div>
                                <div class="stat-value text-primary">{{ number_format($report->area_harvested, 2) }} ha</div>
                            </div>
                        </div>

                        <div class="stats bg-base-200 shadow">
                            <div class="stat">
                                <div class="stat-title">Total Yield</div>
                                <div class="stat-value">{{ number_format($report->total_yield, 2) }} kg</div>
                                <div class="stat-desc">{{ number_format($report->total_yield / $report->area_harvested, 2) }} kg/ha</div>
                            </div>
                        </div>

                        <div class="stats bg-base-200 shadow">
                            <div class="stat">
                                <div class="stat-title">Profit</div>
                                <div class="stat-value text-success">₱{{ number_format($report->profit, 2) }}</div>
                                @if($report->damage_quantity > 0)
                                    <div class="stat-desc text-error">
                                        Damage: {{ number_format($report->damage_quantity, 2) }} kg
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
