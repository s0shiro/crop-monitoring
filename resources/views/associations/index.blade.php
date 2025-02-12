<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-lg font-semibold">Associations</h2>

        @can('create associations')
            <a href="{{ route('associations.create') }}" class="bg-blue-500 text-white px-4 py-2">Add Association</a>
        @endcan

        <table class="w-full border mt-4">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            @foreach ($associations as $association)
                <tr>
                    <td>{{ $association->name }}</td>
                    <td>{{ $association->description }}</td>
                    <td>
                        @can('update associations')
                            <a href="{{ route('associations.edit', $association) }}" class="bg-yellow-500 text-white px-2 py-1">Edit</a>
                        @endcan

                        @can('delete associations')
                            <form action="{{ route('associations.destroy', $association) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
