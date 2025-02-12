<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-lg font-semibold">Edit Farmer</h2>

        <form action="{{ route('farmers.update', $farmer) }}" method="POST">
            @csrf @method('PUT')

            <label>Name:</label>
            <input type="text" name="name" class="border p-2 w-full" value="{{ $farmer->name }}" required>

            <label>Gender:</label>
            <select name="gender" class="border p-2 w-full">
                <option value="male" {{ $farmer->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $farmer->gender == 'female' ? 'selected' : '' }}>Female</option>
            </select>

            <label>RSBSA Number:</label>
            <input type="text" name="rsbsa" class="border p-2 w-full" value="{{ $farmer->rsbsa }}">

            <label>Land Size (Hectares):</label>
            <input type="number" step="0.01" name="landsize" class="border p-2 w-full" value="{{ $farmer->landsize }}">

            <label>Barangay:</label>
            <input type="text" name="barangay" class="border p-2 w-full" value="{{ $farmer->barangay }}">

            <label>Municipality:</label>
            <input type="text" name="municipality" class="border p-2 w-full" value="{{ $farmer->municipality }}">

            <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2">Update Farmer</button>
        </form>
    </div>
</x-app-layout>
