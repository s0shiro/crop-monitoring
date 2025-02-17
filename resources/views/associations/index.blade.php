<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-base-content">Association Management</h2>
                <p class="text-base-content/70 mt-1">Manage farmer associations and groups</p>
            </div>
            @can('create associations')
                <a href="{{ route('associations.create') }}" class="btn btn-primary btn-md gap-2 normal-case">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Association
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
                                            @can('update associations')
                                                <a href="{{ route('associations.edit', $association) }}"
                                                   class="btn btn-ghost btn-sm tooltip tooltip-top flex items-center justify-center"
                                                   data-tip="Edit Association">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete associations')
                                                <button onclick="document.getElementById('delete-modal-{{ $association->id }}').showModal()"
                                                        class="btn btn-ghost btn-sm tooltip tooltip-top flex items-center justify-center"
                                                        data-tip="Delete Association">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-error" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <dialog id="delete-modal-{{ $association->id }}" class="modal">
                                                    <div class="modal-box">
                                                        <h3 class="text-lg font-bold">Confirm Deletion</h3>
                                                        <p class="py-4">Are you sure you want to delete this association?</p>
                                                        <div class="modal-action">
                                                            <form action="{{ route('associations.destroy', $association) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-error">Delete</button>
                                                            </form>
                                                            <button class="btn" onclick="document.getElementById('delete-modal-{{ $association->id }}').close()">Cancel</button>
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
    </div>
</x-app-layout>
