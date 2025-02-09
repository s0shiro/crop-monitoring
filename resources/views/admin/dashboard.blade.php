<x-app-layout>
    <div class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value text-primary">25.6K</div>
                    <div class="stat-desc">21% more than last month</div>
                </div>
            </div>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="stat-title">Active Crops</div>
                    <div class="stat-value text-secondary">2.6K</div>
                    <div class="stat-desc">14% more than last month</div>
                </div>
            </div>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <div class="stat-title">Monitoring Tasks</div>
                    <div class="stat-value text-accent">86%</div>
                    <div class="stat-desc">31 tasks remaining</div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-base-100 shadow-xl rounded-box p-6">
            <h2 class="text-2xl font-bold mb-4">Recent Activity</h2>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-03-20</td>
                            <td>Crop Inspection</td>
                            <td><div class="badge badge-success">Completed</div></td>
                            <td><button class="btn btn-ghost btn-xs">View</button></td>
                        </tr>
                        <tr>
                            <td>2024-03-19</td>
                            <td>Irrigation Check</td>
                            <td><div class="badge badge-warning">Pending</div></td>
                            <td><button class="btn btn-ghost btn-xs">View</button></td>
                        </tr>
                        <tr>
                            <td>2024-03-18</td>
                            <td>Pest Control</td>
                            <td><div class="badge badge-error">Delayed</div></td>
                            <td><button class="btn btn-ghost btn-xs">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
