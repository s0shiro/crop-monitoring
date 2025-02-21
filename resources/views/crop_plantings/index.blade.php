<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section with Stats -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-4xl font-bold text-base-content">Crop Planting Records</h2>
                    <p class="text-base-content/70 mt-2">Track and manage crop planting activities</p>
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

            <!-- Quick Stats -->
            <div class="stats stats-vertical lg:stats-horizontal shadow-lg bg-base-200 w-full">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Area</div>
                    <div class="stat-value text-primary">{{ number_format($plantings->sum('area_planted'), 2) }}</div>
                    <div class="stat-desc">hectares</div>
                </div>
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="stat-title">Standing Crops</div>
                    <div class="stat-value text-secondary">{{ $standingCount }}</div>
                    <div class="stat-desc">Active plantings</div>
                </div>
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">For Harvest</div>
                    <div class="stat-value text-warning">{{ $harvestCount }}</div>
                    <div class="stat-desc">in next 7 days</div>
                </div>
                <div class="stat">
                    <div class="stat-figure text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Expenses</div>
                    <div class="stat-value text-info">₱{{ number_format($plantings->sum('expenses'), 0) }}</div>
                    <div class="stat-desc">All plantings</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters Section -->
        <div class="card bg-base-100 shadow-lg mb-8">
            <div class="card-body">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Search and Category Filter -->
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search farmer or crop..."
                                class="input input-bordered flex-1">
                            <select name="category" class="select select-bordered w-1/3">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="join w-full">
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="input input-bordered join-item w-1/3"
                                   placeholder="From Date">
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="input input-bordered join-item w-1/3"
                                   placeholder="To Date">
                            <button type="submit" class="btn btn-primary join-item flex-1 gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Status Tabs -->
        <div class="tabs tabs-lifted mb-8">
            <a href="{{ route('crop_plantings.index', ['status' => 'all']) }}"
               class="tab tab-lg {{ request('status', 'all') === 'all' ? 'tab-active' : '' }}">
                All Records
            </a>
            <a href="{{ route('crop_plantings.index', ['status' => 'standing']) }}"
               class="tab tab-lg {{ request('status') === 'standing' ? 'tab-active' : '' }}">
                Standing
                <div class="badge badge-sm badge-success ml-2">{{ $standingCount }}</div>
            </a>
            <a href="{{ route('crop_plantings.index', ['status' => 'harvest']) }}"
               class="tab tab-lg {{ request('status') === 'harvest' ? 'tab-active' : '' }}">
                Ready to Harvest
                <div class="badge badge-sm badge-warning ml-2">{{ $harvestCount }}</div>
            </a>
            <a href="{{ route('crop_plantings.index', ['status' => 'partially harvested']) }}"
               class="tab tab-lg {{ request('status') === 'partially harvested' ? 'tab-active' : '' }}">
                Partially Harvested
                <div class="badge badge-sm badge-warning ml-2">{{ $partiallyHarvestedCount }}</div>
            </a>
            <a href="{{ route('crop_plantings.index', ['status' => 'harvested']) }}"
               class="tab tab-lg {{ request('status') === 'harvested' ? 'tab-active' : '' }}">
                Harvested
                <div class="badge badge-sm badge-info ml-2">{{ $harvestedCount }}</div>
            </a>
        </div>

        @if($plantings->count() > 0)
            <!-- Enhanced Table Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
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
                                <tr class="hover">
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
                                    <td>{{ $planting->planting_date->format('M d, Y') }}</td>
                                    <td>{{ $planting->expected_harvest_date->format('M d, Y') }}</td>
                                    <td>
                                        @switch($planting->status)
                                        @case('standing')
                                            <span class="badge badge-success">Standing</span>
                                            @break
                                        @case('harvest')
                                            <span class="badge badge-warning">Ready to Harvest</span>
                                            @break
                                        @case('partially harvested')
                                            <span class="badge badge-warning">Partially Harvested</span>
                                            @break
                                        @case('harvested')
                                            <span class="badge badge-info">Harvested</span>
                                            @break
                                        @default
                                            <span class="badge">{{ ucfirst($planting->status) }}</span>
                                    @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown dropdown-end">
                                            <label tabindex="0" class="btn btn-ghost btn-sm m-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </label>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li><a href="{{ route('crop_plantings.show', $planting->id) }}">View Details</a></li>
                                                @can('manage crop planting')
                                                <li><a href="{{ route('crop_plantings.edit', $planting->id) }}">Edit Record</a></li>
                                                <li>
                                                    <form action="{{ route('crop_plantings.destroy', $planting->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-error" onclick="return confirm('Are you sure?')">
                                                            Delete Record
                                                        </button>
                                                    </form>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Enhanced Pagination -->
            <div class="mt-8">
                {{ $plantings->withQueryString()->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="hero bg-base-200 rounded-box">
                <div class="hero-content text-center py-16">
                    <div class="max-w-md">
                        <div class="text-6xl mb-4">🌱</div>
                        <h2 class="text-3xl font-bold mb-4">No Records Found</h2>
                        <p class="text-base-content/60 mb-6">
                            @if(request()->has('search') || request()->has('category') || request()->has('date_from'))
                                No records match your search criteria. Try adjusting your filters.
                            @else
                                Start tracking your crop plantings by creating your first record.
                            @endif
                        </p>
                        <div class="flex justify-center gap-4">
                            @if(request()->has('search') || request()->has('category') || request()->has('date_from'))
                                <a href="{{ route('crop_plantings.index') }}" class="btn btn-primary">Clear Filters</a>
                            @endif
                            @can('manage crop planting')
                                <a href="{{ route('crop_plantings.create') }}" class="btn btn-accent">Add First Record</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
