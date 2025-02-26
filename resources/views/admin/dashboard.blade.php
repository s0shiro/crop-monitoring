<x-app-layout>
    <div class="container mx-auto p-6 opacity-0 animate-reveal">
        <!-- Header Section -->
        <div class="mb-8 opacity-0 animate-reveal" style="animation-delay: 200ms;">
            <h2 class="text-3xl font-bold">Admin Dashboard</h2>
            <p class="text-base-content/70 mt-1">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Users Stats -->
            <div class="stats bg-base-100 shadow-xl opacity-0 animate-reveal hover:shadow-2xl transition-all duration-500 ease-in-out transform hover:-translate-y-1" style="animation-delay: 300ms;">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Users</div>
                    <div class="stat-value text-primary">2.3K</div>
                    <div class="stat-desc">↗︎ 12% more</div>
                </div>
            </div>

            <!-- Farmers Stats -->
            <div class="stats bg-base-100 shadow-xl opacity-0 animate-reveal hover:shadow-2xl transition-all duration-500 ease-in-out transform hover:-translate-y-1" style="animation-delay: 400ms;">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <div class="stat-title">Farmers</div>
                    <div class="stat-value text-secondary">1.2K</div>
                    <div class="stat-desc">↗︎ 8% more</div>
                </div>
            </div>

            <!-- Crops Stats -->
            <div class="stats bg-base-100 shadow-xl opacity-0 animate-reveal hover:shadow-2xl transition-all duration-500 ease-in-out transform hover:-translate-y-1" style="animation-delay: 500ms;">
                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="stat-title">Active Crops</div>
                    <div class="stat-value text-accent">850</div>
                    <div class="stat-desc">↗︎ 15% growth</div>
                </div>
            </div>

            <!-- Monitoring Stats -->
            <div class="stats bg-base-100 shadow-xl opacity-0 animate-reveal hover:shadow-2xl transition-all duration-500 ease-in-out transform hover:-translate-y-1" style="animation-delay: 600ms;">
                <div class="stat">
                    <div class="stat-figure text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="stat-title">Monitoring Tasks</div>
                    <div class="stat-value text-info">92%</div>
                    <div class="stat-desc">↗︎ 5% this week</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-100 shadow-xl mb-8 opacity-0 animate-reveal" style="animation-delay: 700ms;">
            <div class="card-body">
                <h3 class="card-title mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('users.index') }}" class="btn btn-primary transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                    <a href="{{ route('farmers.index') }}" class="btn btn-secondary transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        Manage Farmers
                    </a>
                    <a href="{{ route('crops.index') }}" class="btn btn-accent transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Manage Crops
                    </a>
                    <a href="{{ route('associations.index') }}" class="btn btn-info transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Associations
                    </a>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="card bg-base-100 shadow-xl opacity-0 animate-reveal" style="animation-delay: 800ms;">
                <div class="card-body">
                    <h3 class="card-title mb-4">Recent Activity</h3>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span>JD</span>
                                            </div>
                                        </div>
                                        <span>John Doe</span>
                                    </td>
                                    <td>Created new crop record</td>
                                    <td>5 mins ago</td>
                                </tr>
                                <tr>
                                    <td class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span>AS</span>
                                            </div>
                                        </div>
                                        <span>Alice Smith</span>
                                    </td>
                                    <td>Updated farmer profile</td>
                                    <td>2 hours ago</td>
                                </tr>
                                <tr>
                                    <td class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span>RJ</span>
                                            </div>
                                        </div>
                                        <span>Robert Johnson</span>
                                    </td>
                                    <td>Added new monitoring task</td>
                                    <td>5 hours ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="card bg-base-100 shadow-xl opacity-0 animate-reveal" style="animation-delay: 900ms;">
                <div class="card-body">
                    <h3 class="card-title mb-4">System Overview</h3>
                    <div class="space-y-4">
                        <!-- Server Status -->
                        <div class="flex justify-between items-center p-4 bg-base-200 rounded-lg">
                            <div>
                                <p class="font-medium">Server Status</p>
                                <p class="text-sm text-base-content/70">All systems operational</p>
                            </div>
                            <div class="badge badge-success gap-2">
                                <span class="animate-pulse w-2 h-2 bg-current rounded-full"></span>
                                Online
                            </div>
                        </div>

                        <!-- Storage Usage -->
                        <div class="p-4 bg-base-200 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <p class="font-medium">Storage Usage</p>
                                <p class="text-sm">65%</p>
                            </div>
                            <progress class="progress progress-primary w-full" value="65" max="100"></progress>
                        </div>

                        <!-- Latest Backup -->
                        <div class="flex justify-between items-center p-4 bg-base-200 rounded-lg">
                            <div>
                                <p class="font-medium">Latest Backup</p>
                                <p class="text-sm text-base-content/70">2 hours ago</p>
                            </div>
                            <button class="btn btn-square btn-ghost btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes reveal {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-5px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .animate-reveal {
            animation: reveal 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Add subtle hover effect for interactive elements */
        .btn, .card {
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat:hover .stat-figure svg {
            animation: float 3s ease-in-out infinite;
        }

        /* Smooth transition for progress bars */
        .progress {
            transition: width 1s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Smooth transition for badges */
        .badge {
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }
    </style>
</x-app-layout>
