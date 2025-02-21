<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('associations.index') }}">Associations</a></li>
                <li>{{ $association->name }}</li>
            </ul>
        </div>

        <!-- Header Section with Quick Actions -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-base-content">{{ $association->name }}</h2>
                    <p class="text-base-content/70 mt-1">{{ $association->description }}</p>
                </div>
                <div class="flex gap-2">
                    @can('update associations')
                        <a href="{{ route('associations.edit', $association) }}" class="btn btn-outline btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z"/>
                                <path d="M11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Edit Association
                        </a>
                    @endcan
                    <a href="{{ route('associations.index') }}" class="btn btn-ghost">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Total Members</div>
                    <div class="stat-value text-primary">{{ $farmers->count() }}</div>
                </div>
            </div>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Total Land Area</div>
                    <div class="stat-value text-secondary">
                        @if($farmers->sum('landsize'))
                            {{ $farmers->sum('landsize') }}
                        @else
                            <span class="text-base">Not Recorded</span>
                        @endif
                    </div>
                    <div class="stat-desc">Hectares</div>
                </div>
            </div>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Gender Distribution</div>
                    <div class="stat-value">
                        <div class="flex gap-2 text-sm font-normal">
                            <div class="badge badge-primary">Male: {{ $genderStats['male'] }}</div>
                            <div class="badge badge-secondary">Female: {{ $genderStats['female'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Farmers Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <!-- Table Header with Search -->
                <div class="p-4 border-b flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-xl font-bold">Member Farmers</h3>
                    <form action="{{ route('associations.show', $association) }}" method="GET" class="join">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..." class="input input-bordered join-item" />
                        <button type="submit" class="btn join-item">Search</button>
                    </form>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="border-b-2 border-base-200">
                                <th class="bg-base-100 text-base-content/70">Name</th>
                                <th class="bg-base-100 text-base-content/70">RSBSA</th>
                                <th class="bg-base-100 text-base-content/70">Gender</th>
                                <th class="bg-base-100 text-base-content/70">Land Size</th>
                                <th class="bg-base-100 text-base-content/70">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($farmers as $farmer)
                                <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                    <td class="font-medium">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                    <span>{{ strtoupper(substr($farmer->name, 0, 2)) }}</span>
                                                </div>
                                            </div>
                                            {{ $farmer->name }}
                                        </div>
                                    </td>
                                    <td>{{ $farmer->rsbsa }}</td>
                                    <td>
                                        <div class="badge {{ $farmer->gender === 'Male' ? 'badge-primary' : 'badge-secondary' }} badge-sm">
                                            {{ $farmer->gender }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if($farmer->landsize)
                                                <span>{{ $farmer->landsize }}</span>
                                                <span class="text-xs text-base-content/70">ha</span>
                                            @else
                                                <span class="text-xs text-base-content/70 italic">No record</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $farmer->barangay }}, {{ $farmer->municipality }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="h-12 w-12 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-base-content/70">No farmers found in this association.</p>
                                            @can('create farmers')
                                                <a href="#" class="btn btn-primary btn-sm mt-2">Add Member</a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Pagination -->
                @if($farmers->isNotEmpty())
                    <div class="p-4 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-base-content/70">
                                Showing {{ $farmers->firstItem() }} to {{ $farmers->lastItem() }} of {{ $farmers->total() }} members
                            </span>
                            {{ $farmers->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
