<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Add Farmer</h2>
            <p class="text-base-content/70 mt-1">Create a new farmer record</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('farmers.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered w-full" required>
                    </div>

                    <!-- Gender -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Gender</span>
                        </label>
                        <select name="gender" class="select select-bordered w-full">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- RSBSA -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">RSBSA Number</span>
                        </label>
                        <input type="text" name="rsbsa" class="input input-bordered w-full">
                    </div>

                    <!-- Land Size -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Land Size (Hectares)</span>
                        </label>
                        <input type="number" step="0.01" name="landsize" class="input input-bordered w-full">
                    </div>

                    <!-- Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Barangay</span>
                            </label>
                            <input type="text" name="barangay" class="input input-bordered w-full">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Municipality</span>
                            </label>
                            <input type="text" name="municipality" class="input input-bordered w-full">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('farmers.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Farmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
