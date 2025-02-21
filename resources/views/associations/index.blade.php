<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Stats Summary -->
        <div class="stats shadow mb-8 w-full bg-base-100">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
                <div class="stat-title">Total Associations</div>
                <div class="stat-value text-primary">{{ $associations->count() }}</div>
            </div>
        </div>

        <!-- Header Section with Search -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Association Management</h2>
                <p class="text-base-content/70 mt-1">Manage farmer associations and groups</p>
            </div>

            <div class="flex gap-4 items-center w-full md:w-auto">
                <!-- Search Input -->
                <div class="join flex-1 md:flex-none">
                    <input type="text" id="search" placeholder="Search associations..."
                           class="input input-bordered join-item flex-1" />
                    <button class="btn join-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Filter Dropdown -->
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost m-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Sort by Name</a></li>
                        <li><a>Sort by Members</a></li>
                        <li><a>Sort by Date Created</a></li>
                    </ul>
                </div>

                @can('create associations')
                    <a href="{{ route('associations.create') }}" class="btn btn-primary gap-2 normal-case">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Association
                    </a>
                @endcan
            </div>
        </div>

        <!-- Table Card with Loading State -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto" id="associations-table">
                    <!-- Loading Skeleton -->
                    <template x-if="loading">
                        <div class="animate-pulse p-4">
                            <div class="h-4 bg-base-300 rounded w-3/4 mb-4"></div>
                            <div class="h-4 bg-base-300 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-base-300 rounded w-5/6"></div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    @if($associations->isEmpty())
                        <div class="text-center py-12">
                            <div class="flex justify-center mb-4">
                                <svg class="h-12 w-12 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">No Associations Found</h3>
                            <p class="text-base-content/70">Start by creating your first association.</p>
                            @can('create associations')
                                <a href="{{ route('associations.create') }}" class="btn btn-primary mt-4">Create Association</a>
                            @endcan
                        </div>
                    @else
                        <table class="table w-full">
                            <thead>
                                <tr class="border-b-2 border-base-200">
                                    <th class="bg-base-100 text-base-content/70">Name</th>
                                    <th class="bg-base-100 text-base-content/70">Description</th>
                                    <th class="bg-base-100 text-base-content/70 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($associations as $association)
                                    <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                        <td class="font-medium">{{ $association->name }}</td>
                                        <td>{{ $association->description }}</td>
                                        <td>
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('associations.show', $association) }}"
                                                   class="btn btn-ghost btn-sm tooltip tooltip-top flex items-center justify-center"
                                                   data-tip="View Members">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast" class="toast toast-end">
        @if(session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('input', debounce((e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }, 300));

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Auto-hide toast after 3 seconds
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 3000);
    </script>
</x-app-layout>
