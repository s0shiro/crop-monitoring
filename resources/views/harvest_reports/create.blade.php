<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Record Harvest for {{ $cropPlanting->crop->name }}
            </h2>
            <span class="text-sm text-gray-600">
                Farmer: {{ $cropPlanting->farmer->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <!-- Progress Information -->
                    <div class="alert alert-info mb-6">
                        <div class="flex items-center justify-between">
                            <span>Available Area: {{ number_format($availableArea, 2) }} ha</span>
                            <span>Progress: {{ number_format($harvestProgress, 1) }}%</span>
                        </div>
                        <progress class="progress w-full" value="{{ $harvestProgress }}" max="100"></progress>
                    </div>

                    <form action="{{ route('harvest_reports.store', $cropPlanting->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Harvest Date</span>
                                </label>
                                <input type="date" name="harvest_date" required
                                       class="input input-bordered w-full"
                                       value="{{ old('harvest_date', date('Y-m-d')) }}">
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Area Harvested (ha)</span>
                                </label>
                                <input type="number" name="area_harvested" required
                                       step="0.01" min="0.01" max="{{ $availableArea }}"
                                       class="input input-bordered w-full"
                                       value="{{ old('area_harvested') }}">
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Total Yield (kg)</span>
                                </label>
                                <input type="number" name="total_yield" required
                                       step="0.01" min="0"
                                       class="input input-bordered w-full"
                                       value="{{ old('total_yield') }}">
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Profit (₱)</span>
                                </label>
                                <input type="number" name="profit"
                                       step="0.01" min="0"
                                       class="input input-bordered w-full"
                                       value="{{ old('profit', 0) }}">
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">Damage Quantity (kg)</span>
                                </label>
                                <input type="number" name="damage_quantity"
                                       step="0.01" min="0"
                                       class="input input-bordered w-full"
                                       value="{{ old('damage_quantity', 0) }}">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('crop_plantings.show', $cropPlanting) }}"
                               class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
