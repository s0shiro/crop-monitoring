<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-lg font-semibold">Farmers Management</h2>

        @can('create farmers')
            <a href="{{ route('farmers.create') }}" class="bg-blue-500 text-white px-4 py-2">Add Farmer</a>
        @endcan

        <table class="w-full border mt-4">
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>RSBSA</th>
                <th>Land Size (Ha)</th>
                <th>Barangay</th>
                <th>Municipality</th>
                <th>Actions</th>
            </tr>
            @foreach ($farmers as $farmer)
                <tr>
                    <td>{{ $farmer->name }}</td>
                    <td>{{ ucfirst($farmer->gender) }}</td>
                    <td>{{ $farmer->rsbsa ?? 'N/A' }}</td>
                    <td>{{ $farmer->landsize ?? 'N/A' }}</td>
                    <td>{{ $farmer->barangay ?? 'N/A' }}</td>
                    <td>{{ $farmer->municipality ?? 'N/A' }}</td>
                    <td>
                        @can('update farmers')
                            <a href="{{ route('farmers.edit', $farmer) }}" class="bg-yellow-500 text-white px-2 py-1">Edit</a>
                        @endcan

                        @can('delete farmers')
                            <form action="{{ route('farmers.destroy', $farmer) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $farmers->links() }}
    </div>
</x-app-layout>
