<x-app-layout>
    <div class="w-full p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-6 text-primary">Edit User</h2>

                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

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
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="input input-bordered w-full pl-10" required>
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
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="input input-bordered w-full pl-10" required>
                            </div>
                            @error('email')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Role</span>
                            </label>
                            <select name="roles[]" id="role" class="select select-bordered w-full" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div id="crop_category_field" class="form-control {{ $user->hasRole('coordinator') ? '' : 'hidden' }}">
                            <label class="label">
                                <span class="label-text font-semibold">Crop Category</span>
                            </label>
                            <select name="crop_category" class="select select-bordered w-full">
                                <option value="">Select Crop Category</option>
                                @foreach(['Rice', 'Corn', 'High Value Crops'] as $category)
                                    <option value="{{ $category }}" {{ $user->crop_category == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('crop_category')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div id="coordinator_field" class="form-control {{ $user->hasRole('technician') ? '' : 'hidden' }}">
                            <label class="label">
                                <span class="label-text font-semibold">Assign Coordinator</span>
                            </label>
                            <select name="coordinator_id" class="select select-bordered w-full">
                                <option value="">Select Coordinator</option>
                                @foreach($coordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}" {{ $user->coordinator_id == $coordinator->id ? 'selected' : '' }}>
                                        {{ $coordinator->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coordinator_id')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Permissions</span>
                        </label>
                        <div class="bg-base-200 rounded-lg p-4" x-data="{ searchTerm: '' }">
                            <div class="mb-4">
                                <input type="text" x-model="searchTerm"
                                       placeholder="Search permissions..."
                                       class="input input-bordered w-full">
                            </div>
                            <div class="grid grid-cols-4 gap-4 max-h-60 overflow-y-auto">
                                @foreach ($permissions as $permission)
                                    <label class="flex items-center p-2 hover:bg-base-300 rounded cursor-pointer"
                                           x-show="!searchTerm || '{{ $permission->name }}'.toLowerCase().includes(searchTerm.toLowerCase())">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               class="checkbox checkbox-primary checkbox-sm"
                                               {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('users.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-error mb-4">Danger Zone</h3>
            <div class="card bg-base-100 shadow-xl border-2 border-error">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium">Delete this user</h4>
                            <p class="text-sm text-base-content/70">Once deleted, all user data will be permanently removed.</p>
                        </div>
                        <button onclick="deleteModal.showModal()" class="btn btn-error btn-sm">
                            Delete User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Delete User</h3>
            <p class="py-4">This action cannot be undone. Please type <strong>{{ $user->email }}</strong> to confirm.</p>

            <form action="{{ route('users.destroy', $user) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <input type="text"
                       id="confirmationInput"
                       class="input input-bordered w-full mt-2"
                       placeholder="Type the user's email here"
                       required>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="deleteModal.close()">Cancel</button>
                    <button type="submit"
                            class="btn btn-error"
                            id="confirmDeleteBtn"
                            disabled>Delete User</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Delete Confirmation Script -->
    <script>
        const confirmationInput = document.getElementById('confirmationInput');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const userEmail = @json($user->email);

        confirmationInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== userEmail;
        });
    </script>

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
