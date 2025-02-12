<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-lg font-semibold">Add Farmer</h2>

        <form action="{{ route('farmers.store') }}" method="POST">
            @csrf

            <label>Name:</label>
            <input type="text" name="name" class="border p-2 w-full" required>

            <label>Gender:</label>
            <select name="gender" class="border p-2 w-full">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <label>RSBSA Number:</label>
            <input type="text" name="rsbsa" class="border p-2 w-full">

            <label>Land Size (Hectares):</label>
            <input type="number" step="0.01" name="landsize" class="border p-2 w-full">

            <label>Barangay:</label>
            <input type="text" name="barangay" class="border p-2 w-full">

            <label>Municipality:</label>
            <input type="text" name="municipality" class="border p-2 w-full">

            <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2">Save Farmer</button>
        </form>
    </div>
</x-app-layout>
