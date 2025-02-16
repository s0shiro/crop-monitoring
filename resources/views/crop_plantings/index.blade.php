<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Crop Planting Records</h2>
                <p class="text-base-content/70 mt-1">Track and manage crop planting activities</p>
            </div>
            @can('manage crop planting')
            <a href="{{ route('crop_plantings.create') }}" class="btn btn-primary btn-md gap-2 normal-case">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Planting Record
            </a>
            @endcan
        </div>

        @if($plantings->count() > 0)
            <!-- Table Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr class="border-b-2 border-base-200">
                                    <th class="bg-base-100 text-base-content/70">Farmer</th>
                                    <th class="bg-base-100 text-base-content/70">Category</th>
                                    <th class="bg-base-100 text-base-content/70">Crop</th>
                                    <th class="bg-base-100 text-base-content/70">Variety</th>
                                    <th class="bg-base-100 text-base-content/70">Type Details</th>
                                    <th class="bg-base-100 text-base-content/70">Planting Date</th>
                                    <th class="bg-base-100 text-base-content/70">Expected Harvest Date</th>
                                    <th class="bg-base-100 text-base-content/70">Status</th>
                                    <th class="bg-base-100 text-base-content/70 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plantings as $planting)
                                <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                    <td>{{ $planting->farmer->name }}</td>
                                    <td>{{ $planting->category->name }}</td>
                                    <td>{{ $planting->crop->name }}</td>
                                    <td>{{ $planting->variety->name }}</td>
                                    <td>
                                        @if($planting->category->name === 'High Value Crops' && $planting->hvcDetail)
                                            <span class="badge badge-info">{{ $planting->hvcDetail->classification }}</span>
                                        @elseif($planting->category->name === 'Rice' && $planting->riceDetail)
                                            <div class="flex flex-col gap-1">
                                                <span class="badge badge-info">{{ $planting->riceDetail->water_supply }}</span>
                                                @if($planting->riceDetail->land_type)
                                                    <span class="badge badge-ghost">{{ $planting->riceDetail->land_type }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $planting->planting_date }}</td>
                                    <td>{{ $planting->expected_harvest_date }}</td>
                                    <td>{{ ucfirst($planting->status) }}</td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('crop_plantings.show', $planting->id) }}"
                                            class="btn btn-ghost btn-sm tooltip tooltip-top p-0 h-8 w-8 min-h-8"
                                            data-tip="View">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                 <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                 <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                             </svg>
                                         </a>
                                        @can('manage crop planting')
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('crop_plantings.edit', $planting->id) }}"
                                               class="btn btn-ghost btn-sm tooltip tooltip-top p-0 h-8 w-8 min-h-8"
                                               data-tip="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('crop_plantings.destroy', $planting->id) }}"
                                                  method="POST"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-ghost btn-sm tooltip tooltip-top p-0 h-8 w-8 min-h-8 text-error"
                                                        data-tip="Delete"
                                                        onclick="return confirm('Are you sure?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $plantings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center py-12">
                    <div class="text-6xl mb-4">🌱</div>
                    <h2 class="card-title text-2xl mb-2">No Planting Records Yet</h2>
                    <p class="text-base-content/60 mb-6">Start tracking your crop plantings by creating your first record.</p>
                    {{-- @can('manage crop planting')
                        <a href="{{ route('crop_plantings.create') }}" class="btn btn-primary gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create First Record
                        </a>
                    @endcan --}}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
