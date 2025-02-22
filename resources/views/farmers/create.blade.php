<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Breadcrumbs -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('farmers.index') }}">Farmers</a></li>
                <li>Create</li>
            </ul>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Add New Farmer</h2>
            <p class="text-base-content/70 mt-1">Fill in the details to register a new farmer</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl max-w-5xl mx-auto">
            <div class="card-body">
                <form action="{{ route('farmers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="border-b border-base-200 pb-4">
                        <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Full Name</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="input input-bordered w-full @error('name') input-error @enderror" required>
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Gender</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <select name="gender" class="select select-bordered w-full @error('gender') select-error @enderror" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Farm Information Section -->
                    <div class="border-b border-base-200 pb-4">
                        <h3 class="text-lg font-semibold mb-4">Farm Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- RSBSA -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">RSBSA Number</span>
                                    <span class="label-text-alt">Optional</span>
                                </label>
                                <input type="text" name="rsbsa" value="{{ old('rsbsa') }}"
                                    class="input input-bordered w-full @error('rsbsa') input-error @enderror"
                                    placeholder="Enter RSBSA number">
                                @error('rsbsa')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Land Size -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Land Size</span>
                                    <span class="label-text-alt">in hectares</span>
                                </label>
                                <label class="input-group">
                                    <input type="number" step="0.01" name="landsize" value="{{ old('landsize') }}"
                                        class="input input-bordered w-full @error('landsize') input-error @enderror"
                                        placeholder="0.00">
                                    <span>ha</span>
                                </label>
                                @error('landsize')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Association & Location Section -->
                    <div class="border-b border-base-200 pb-4">
                        <h3 class="text-lg font-semibold mb-4">Association & Location</h3>

                        <!-- Association -->
                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text font-medium">Farmers Association</span>
                            </label>
                            <select name="association_id" class="select select-bordered w-full @error('association_id') select-error @enderror">
                                <option value="">No Association</option>
                                @foreach($associations as $association)
                                    <option value="{{ $association->id }}" {{ old('association_id') == $association->id ? 'selected' : '' }}>
                                        {{ $association->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('association_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Location Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Barangay</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text" name="barangay" value="{{ old('barangay') }}"
                                    class="input input-bordered w-full @error('barangay') input-error @enderror" required>
                                @error('barangay')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Municipality</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text" name="municipality" value="{{ old('municipality') }}"
                                    class="input input-bordered w-full @error('municipality') input-error @enderror" required>
                                @error('municipality')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Technician Assignment Section -->
                    @can('manage users')
                        <div class="border-b border-base-200 pb-4">
                            <h3 class="text-lg font-semibold mb-4">Technician Assignment</h3>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Assigned Technician</span>
                                </label>
                                <select name="technician_id" class="select select-bordered w-full @error('technician_id') select-error @enderror">
                                    <option value="">Select Technician</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}" {{ old('technician_id') == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    @endcan

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('farmers.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create Farmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
