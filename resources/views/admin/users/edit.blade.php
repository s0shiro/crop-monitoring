<x-app-layout>
    <div class="max-w-2xl mx-auto p-6" x-data="{ roles: @json($user->roles->pluck('name')) }">
        <h2 class="text-2xl font-light mb-6 text-gray-700">Edit User</h2>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div class="form-control">
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required
                       class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label for="email" class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required
                       class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label for="roles" class="label">
                    <span class="label-text">Roles</span>
                </label>
                <select name="roles[]" id="role" class="border p-2 w-full" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Crop Category for Coordinators -->
            <div id="crop_category_field" class="{{ $user->hasRole('coordinator') ? '' : 'hidden' }}">
                <label for="crop_category" class="label">
                    <span class="label-text">Crop Category (For Coordinators)</span>
                </label>
                <select name="crop_category" class="border p-2 w-full">
                    <option value="">Select Crop Category</option>
                    <option value="Rice" {{ $user->crop_category == 'Rice' ? 'selected' : '' }}>Rice</option>
                    <option value="Corn" {{ $user->crop_category == 'Corn' ? 'selected' : '' }}>Corn</option>
                    <option value="High Value Crops" {{ $user->crop_category == 'High Value Crops' ? 'selected' : '' }}>High Value Crops</option>
                </select>
            </div>

            <!-- Assign Coordinator for Technicians -->
            <div id="coordinator_field" class="{{ $user->hasRole('technician') ? '' : 'hidden' }}">
                <label for="coordinator_id" class="label">
                    <span class="label-text">Assign Coordinator (For Technicians)</span>
                </label>
                <select name="coordinator_id" class="border p-2 w-full">
                    <option value="">Select Coordinator</option>
                    @foreach($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}" {{ $user->coordinator_id == $coordinator->id ? 'selected' : '' }}>
                            {{ $coordinator->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label for="permissions" class="label">
                    <span class="label-text">Permissions</span>
                </label>
                <div class="dropdown" x-data="{ search: '' }">
                    <label tabindex="0" class="btn m-1">Select Permissions</label>
                    <div tabindex="0" class="dropdown-content bg-base-100 rounded-box shadow-xl p-4"
                         style="width: 600px; max-height: 500px; z-index: 50;">
                        <div class="mb-4">
                            <input type="text" x-model="search"
                                   placeholder="Search permissions..."
                                   class="input input-bordered w-full">
                        </div>
                        <div class="overflow-y-auto" style="max-height: 400px;">
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($permissions as $permission)
                                    <label class="flex items-center p-2 hover:bg-base-200 rounded"
                                           x-show="!search || '{{ $permission->name }}'.toLowerCase().includes(search.toLowerCase())">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                               {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                               class="checkbox checkbox-primary checkbox-sm">
                                        <span class="ml-2 text-sm">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">
                    Update User
                </button>
            </div>
        </form>
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
