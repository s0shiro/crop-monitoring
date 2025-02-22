<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Breadcrumbs -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('farmers.index') }}">Farmers</a></li>
                <li>Edit {{ $farmer->name }}</li>
            </ul>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Edit Farmer</h2>
            <p class="text-base-content/70 mt-1">Update farmer's information and details</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl max-w-5xl mx-auto">
            <div class="card-body">
                <form action="{{ route('farmers.update', $farmer) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

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
                                <input type="text" name="name" value="{{ old('name', $farmer->name) }}"
                                    class="input input-bordered w-full @error('name') input-error @enderror" required>
                                @error('name')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Gender</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <select name="gender" class="select select-bordered w-full @error('gender') select-error @enderror" required>
                                    <option value="male" {{ old('gender', $farmer->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $farmer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
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
                                <input type="text" name="rsbsa" value="{{ old('rsbsa', $farmer->rsbsa) }}"
                                    class="input input-bordered w-full @error('rsbsa') input-error @enderror"
                                    placeholder="Enter RSBSA number">
                                @error('rsbsa')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <!-- Land Size -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Land Size</span>
                                    <span class="label-text-alt">in hectares</span>
                                </label>
                                <label class="input-group">
                                    <input type="number" step="0.01" name="landsize" value="{{ old('landsize', $farmer->landsize) }}"
                                        class="input input-bordered w-full @error('landsize') input-error @enderror"
                                        placeholder="0.00">
                                    <span>ha</span>
                                </label>
                                @error('landsize')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
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
                                    <option value="{{ $association->id }}"
                                        {{ old('association_id', $farmer->association_id) == $association->id ? 'selected' : '' }}>
                                        {{ $association->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('association_id')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <!-- Location Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Barangay</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text" name="barangay" value="{{ old('barangay', $farmer->barangay) }}"
                                    class="input input-bordered w-full @error('barangay') input-error @enderror" required>
                                @error('barangay')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Municipality</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text" name="municipality" value="{{ old('municipality', $farmer->municipality) }}"
                                    class="input input-bordered w-full @error('municipality') input-error @enderror" required>
                                @error('municipality')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
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
                                        <option value="{{ $technician->id }}"
                                            {{ old('technician_id', $farmer->technician_id) == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>
                        </div>
                    @endcan

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('farmers.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Update Farmer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="max-w-5xl mx-auto mt-8">
            <h3 class="text-lg font-semibold text-error mb-4">Danger Zone</h3>
            <div class="card bg-base-100 shadow-xl border-2 border-error">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium">Delete this farmer</h4>
                            <p class="text-sm text-base-content/70">Once deleted, all of this farmer's data will be permanently removed.</p>
                        </div>
                        <button onclick="deleteModal.showModal()" class="btn btn-error btn-sm">
                            Delete Farmer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <h3 class="font-bold text-lg text-error">Delete Farmer</h3>
                <p class="py-4">This action cannot be undone. Please type <strong>{{ $farmer->name }}</strong> to confirm.</p>

                <form action="{{ route('farmers.destroy', $farmer) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <input type="text"
                        id="confirmationInput"
                        class="input input-bordered w-full mt-2"
                        placeholder="Type the farmer's name here"
                        required>

                    <div class="modal-action">
                        <button type="button" class="btn btn-ghost" onclick="deleteModal.close()">Cancel</button>
                        <button type="submit"
                                class="btn btn-error"
                                id="confirmDeleteBtn"
                                disabled>Delete Farmer</button>
                    </div>
                </form>
            </div>
        </dialog>

        <!-- Delete Confirmation Script -->
        @push('scripts')
        <script>
            const confirmationInput = document.getElementById('confirmationInput');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const farmerName = @json($farmer->name);

            confirmationInput.addEventListener('input', function() {
                confirmDeleteBtn.disabled = this.value !== farmerName;
            });
        </script>
        @endpush

    </div>
</x-app-layout>
