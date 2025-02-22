<x-app-layout>
    <div class="w-full p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-6 text-primary">Create New User</h2>

                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Name</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" name="name" class="input input-bordered w-full pl-10" required value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Email</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input type="email" name="email" class="input input-bordered w-full pl-10" required value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Password</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" name="password" class="input input-bordered w-full pl-10" required>
                            </div>
                            <label class="label">
                                <span class="label-text-alt text-gray-500">Must be at least 8 characters</span>
                            </label>
                            @error('password')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Confirm Password</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" name="password_confirmation" class="input input-bordered w-full pl-10" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Role</span>
                            </label>
                            <select name="role" id="role" class="select select-bordered w-full" required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                                <option value="technician" {{ old('role') == 'technician' ? 'selected' : '' }}>Technician</option>
                            </select>
                            @error('role')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div id="crop_category_field" class="form-control hidden">
                            <label class="label">
                                <span class="label-text font-semibold">Crop Category</span>
                            </label>
                            <select name="crop_category" class="select select-bordered w-full">
                                <option value="">Select Crop Category</option>
                                <option value="Rice" {{ old('crop_category') == 'Rice' ? 'selected' : '' }}>Rice</option>
                                <option value="Corn" {{ old('crop_category') == 'Corn' ? 'selected' : '' }}>Corn</option>
                                <option value="High Value Crops" {{ old('crop_category') == 'High Value Crops' ? 'selected' : '' }}>High Value Crops</option>
                            </select>
                            @error('crop_category')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div id="coordinator_field" class="form-control hidden">
                            <label class="label">
                                <span class="label-text font-semibold">Assign Coordinator</span>
                            </label>
                            <select name="coordinator_id" class="select select-bordered w-full">
                                <option value="">Select Coordinator</option>
                                @foreach($coordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}" {{ old('coordinator_id') == $coordinator->id ? 'selected' : '' }}>
                                        {{ $coordinator->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coordinator_id')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('users.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            let cropCategoryField = document.getElementById('crop_category_field');
            let coordinatorField = document.getElementById('coordinator_field');

            if (this.value === 'coordinator') {
                cropCategoryField.classList.remove('hidden');
                coordinatorField.classList.add('hidden');
            } else if (this.value === 'technician') {
                cropCategoryField.classList.add('hidden');
                coordinatorField.classList.remove('hidden');
            } else {
                cropCategoryField.classList.add('hidden');
                coordinatorField.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
