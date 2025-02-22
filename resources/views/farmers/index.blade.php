<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Farmers Management</h2>
                <p class="text-base-content/70 mt-1">Manage farmer records and information</p>
            </div>
            <div class="mt-4 md:mt-0">
                @can('create farmers')
                    <a href="{{ route('farmers.create') }}" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Farmer
                    </a>
                @endcan
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Farmers</div>
                    <div class="stat-value">{{ $farmers->total() }}</div>
                    <div class="stat-desc">Registered farmers</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Land Size</div>
                    <div class="stat-value text-primary">{{ number_format($farmers->sum('landsize'), 2) }}</div>
                    <div class="stat-desc">hectares</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Associations</div>
                    <div class="stat-value text-secondary">{{ $farmers->unique('association_id')->count() }}</div>
                    <div class="stat-desc">Farmer groups</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Municipalities</div>
                    <div class="stat-value text-accent">{{ $farmers->unique('municipality')->count() }}</div>
                    <div class="stat-desc">Coverage areas</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <form action="{{ route('farmers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Search</span>
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search farmers..."
                               class="input input-bordered">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Association</span>
                        </label>
                        <select name="association" class="select select-bordered w-full">
                            <option value="">All Associations</option>
                            <!-- Add association options here -->
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Municipality</span>
                        </label>
                        <select name="municipality" class="select select-bordered w-full">
                            <option value="">All Municipalities</option>
                            <!-- Add municipality options here -->
                        </select>
                    </div>
                    <div class="form-control mt-8">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200">
                                <th class="bg-base-200">Name</th>
                                <th class="bg-base-200">RSBSA</th>
                                <th class="bg-base-200">Land Size</th>
                                <th class="bg-base-200">Association</th>
                                <th class="bg-base-200">Location</th>
                                <th class="bg-base-200">Technician</th>
                                <th class="bg-base-200 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($farmers as $farmer)
                                <tr class="hover">
                                    <td class="font-medium">
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                                    <span class="text-xs">{{ substr($farmer->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{ $farmer->name }}</div>
                                                <div class="text-sm opacity-50">{{ ucfirst($farmer->gender) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($farmer->rsbsa)
                                            <span class="font-mono text-sm">{{ $farmer->rsbsa }}</span>
                                        @else
                                            <span class="badge badge-ghost badge-sm">No RSBSA</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($farmer->landsize)
                                            <div class="flex items-center gap-1">
                                                <span class="font-semibold">{{ number_format($farmer->landsize, 2) }}</span>
                                                <span class="text-xs opacity-70">ha</span>
                                            </div>
                                        @else
                                            <span class="badge badge-ghost badge-sm">Not set</span>
                                        @endif
                                    </td>
                                    <td>{{ $farmer->association->name ?? 'N/A' }}</td>
                                    <td>
                                        <div>{{ $farmer->barangay }}</div>
                                        <div class="text-sm opacity-50">{{ $farmer->municipality }}</div>
                                    </td>
                                    <td>{{ $farmer->technician->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        <div class="flex justify-center space-x-2">
                                            @can('update farmers')
                                            <a href="{{ route('farmers.edit', $farmer) }}" class="btn btn-sm btn-ghost btn-square">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            @endcan
                                            @can('delete farmers')
                                            <button onclick="confirmDelete('{{ $farmer->id }}')" class="btn btn-sm btn-ghost btn-square text-error">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <span>No farmers found</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $farmers->withQueryString()->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(farmerId) {
            if (confirm('Are you sure you want to delete this farmer?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/farmers/${farmerId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    @endpush
</x-app-layout>
