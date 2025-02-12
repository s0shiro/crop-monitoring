<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Crop Management</h2>

            @can('create-crops')
                <a href="{{ route('crops.create') }}" class="btn btn-primary">Add Crop</a>
            @endcan
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Variety</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crops as $crop)
                                <tr>
                                    <td>{{ $crop->name }}</td>
                                    <td>
                                        <div class="badge badge-outline">{{ $crop->category }}</div>
                                    </td>
                                    <td>{{ $crop->variety }}</td>
                                    <td class="flex gap-2">
                                        @can('update-crops')
                                            <a href="{{ route('crops.edit', $crop) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endcan

                                        @can('delete-crops')
                                            <button onclick="document.getElementById('delete-modal-{{ $crop->id }}').showModal()"
                                                    class="btn btn-sm btn-error">Delete</button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($crops as $crop)
            <dialog id="delete-modal-{{ $crop->id }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirm Deletion</h3>
                    <p class="py-4">Are you sure you want to delete <strong>{{ $crop->name }}</strong>?</p>
                    <div class="modal-action">
                        <form action="{{ route('crops.destroy', $crop) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-error">Delete</button>
                        </form>
                        <button class="btn" onclick="document.getElementById('delete-modal-{{ $crop->id }}').close()">Cancel</button>
                    </div>
                </div>
            </dialog>
        @endforeach
    </div>
</x-app-layout>
