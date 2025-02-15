<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Technician Dashboard</h2>
            <p class="text-base-content/70 mt-1">Monitor and manage your assigned crop activities</p>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Coordinator Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-12">
                                <span class="text-xl">
                                    {{ substr(Auth::user()->coordinator->name ?? 'N', 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <h3 class="card-title">Assigned Coordinator</h3>
                            <p class="text-base-content/70">
                                {{ Auth::user()->coordinator->name ?? 'Not Assigned' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crop Category Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div class="bg-secondary text-secondary-content rounded-full w-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="card-title">Assigned Crop Category</h3>
                            <p class="text-base-content/70">
                                {{ Auth::user()->coordinator->crop_category ?? 'Not Assigned' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('crop_plantings.index') }}" class="btn btn-primary btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        New Planting Record
                    </a>
                    <a href="{{ route('farmers.index') }}" class="btn btn-secondary btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        View Farmers
                    </a>
                    <a href="{{ route('crops.index') }}" class="btn btn-accent btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        Manage Crops
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
