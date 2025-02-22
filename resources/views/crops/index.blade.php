<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Crop Management</h2>
                <p class="text-base-content/70 mt-1">Manage crop varieties and categories</p>
            </div>
            <div class="mt-4 md:mt-0">
                @can('create-crops')
                    <a href="{{ route('crops.create') }}" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Crop
                    </a>
                @endcan
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Crops</div>
                    <div class="stat-value">{{ $crops->count() }}</div>
                    <div class="stat-desc">Active crops</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Categories</div>
                    <div class="stat-value text-primary">{{ $categories->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Varieties</div>
                    <div class="stat-value text-secondary">{{ $varieties->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <form action="{{ route('crops.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Search</span>
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by crop name"
                               class="input input-bordered">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select name="category" class="select select-bordered w-full">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
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
                                <th class="bg-base-200">Category</th>
                                <th class="bg-base-200">Varieties</th>
                                <th class="bg-base-200 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($crops as $crop)
                                <tr class="hover">
                                    <td class="font-medium">
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                                    <span class="text-xs">{{ substr($crop->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <span>{{ $crop->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary badge-sm">
                                            {{ $crop->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($crop->varieties->count() > 0)
                                            @foreach($crop->varieties->take(3) as $variety)
                                                <span class="badge badge-ghost badge-sm">{{ $variety->name }}</span>
                                            @endforeach
                                            @if($crop->varieties->count() > 3)
                                                <span class="badge badge-ghost badge-sm">+{{ $crop->varieties->count() - 3 }}</span>
                                            @endif
                                        @else
                                            <span class="text-base-content/50">No varieties</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex justify-center space-x-2">
                                            @can('update-crops')
                                                <a href="{{ route('crops.edit', $crop) }}"
                                                   class="btn btn-sm btn-ghost btn-square">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete-crops')
                                                <button onclick="confirmDelete('{{ $crop->id }}')"
                                                        class="btn btn-sm btn-ghost btn-square text-error">
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
                                    <td colspan="4" class="text-center py-4">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <span>No crops found</span>
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
            {{ $crops->withQueryString()->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(cropId) {
            if (confirm('Are you sure you want to delete this crop?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/crops/${cropId}`;
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
