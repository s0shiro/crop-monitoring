<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold">Coordinator Dashboard</h2>
            <p class="text-base-content/70 mt-1">Manage your assigned crop category and technicians</p>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Technicians -->
            <div class="stats bg-base-100 shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Technicians</div>
                    <div class="stat-value text-primary">{{ Auth::user()->technicians->count() }}</div>
                </div>
            </div>

            <!-- Crop Category -->
            <div class="stats bg-base-100 shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div class="stat-title">Crop Category</div>
                    <div class="stat-value text-secondary text-sm">{{ Auth::user()->crop_category ?? 'Not Assigned' }}</div>
                </div>
            </div>

            <!-- Total Reports -->
            <div class="stats bg-base-100 shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Reports</div>
                    <div class="stat-value text-accent">89</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-100 shadow-lg mb-8">
            <div class="card-body">
                <h3 class="card-title mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Temporarily disabled Add Technician button -->
                    <button class="btn btn-disabled gap-2" onclick="alert('Feature coming soon!')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Add Technician
                    </button>
                    <a href="{{ route('crop_plantings.index') }}" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        View Reports
                    </a>
                    <a href="{{ route('crops.index') }}" class="btn btn-secondary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        Manage Crops
                    </a>
                </div>
            </div>
        </div>

        <!-- Technicians Table -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h3 class="card-title mb-4">Assigned Technicians</h3>
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Name</th>
                                <th class="bg-base-200">Email</th>
                                <th class="bg-base-200">Status</th>
                                <th class="bg-base-200">Last Activity</th>
                                <th class="bg-base-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Auth::user()->technicians as $tech)
                            <tr class="hover:bg-base-200">
                                <td class="flex items-center gap-2">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-8">
                                            <span>{{ substr($tech->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    {{ $tech->name }}
                                </td>
                                <td>{{ $tech->email }}</td>
                                <td><div class="badge badge-success gap-2">Active</div></td>
                                <td>{{ $tech->updated_at->diffForHumans() }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>
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
