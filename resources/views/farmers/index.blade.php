<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Farmers Management</h2>
                <p class="text-base-content/70 mt-1">Manage farmer records and information</p>
            </div>
            @can('create farmers')
                <a href="{{ route('farmers.create') }}" class="btn btn-primary btn-md gap-2 normal-case">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Farmer
                </a>
            @endcan
        </div>

        <!-- Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="border-b-2 border-base-200">
                                <th class="bg-base-100 text-base-content/70">Name</th>
                                <th class="bg-base-100 text-base-content/70">Gender</th>
                                <th class="bg-base-100 text-base-content/70">RSBSA</th>
                                <th class="bg-base-100 text-base-content/70">Land Size (Ha)</th>
                                <th class="bg-base-100 text-base-content/70">Association</th>
                                <th class="bg-base-100 text-base-content/70">Barangay</th>
                                <th class="bg-base-100 text-base-content/70">Municipality</th>
                                <th>Assigned Technician</th>
                                <th class="bg-base-100 text-base-content/70 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($farmers as $farmer)
                                <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                    <td class="font-medium">{{ $farmer->name }}</td>
                                    <td>{{ ucfirst($farmer->gender) }}</td>
                                    <td>{{ $farmer->rsbsa ?? 'N/A' }}</td>
                                    <td>{{ $farmer->landsize ?? 'N/A' }}</td>
                                    <td>{{ $farmer->association->name ?? 'N/A' }}</td>
                                    <td>{{ $farmer->barangay ?? 'N/A' }}</td>
                                    <td>{{ $farmer->municipality ?? 'N/A' }}</td>
                                    <td>{{ $farmer->technician->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            @can('update farmers')
                                                <a href="{{ route('farmers.edit', $farmer) }}"
                                                   class="btn btn-ghost btn-sm tooltip tooltip-top flex items-center justify-center"
                                                   data-tip="Edit Farmer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete farmers')
                                                <button onclick="document.getElementById('delete-modal-{{ $farmer->id }}').showModal()"
                                                        class="btn btn-ghost btn-sm tooltip tooltip-top flex items-center justify-center"
                                                        data-tip="Delete Farmer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-error" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <dialog id="delete-modal-{{ $farmer->id }}" class="modal">
                                                    <div class="modal-box">
                                                        <h3 class="text-lg font-bold">Confirm Deletion</h3>
                                                        <p class="py-4">Are you sure you want to delete this farmer?</p>
                                                        <div class="modal-action">
                                                            <form action="{{ route('farmers.destroy', $farmer) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-error">Delete</button>
                                                            </form>
                                                            <button class="btn" onclick="document.getElementById('delete-modal-{{ $farmer->id }}').close()">Cancel</button>
                                                        </div>
                                                    </div>
                                                </dialog>
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
            {{ $farmers->links() }}
        </div>
    </div>
</x-app-layout>
