<x-app-layout>
    <div class="max-w-lg mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-6">Create New User</h2>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" class="input input-bordered w-full" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered w-full" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="password" class="input input-bordered w-full" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Confirm Password</span>
                </label>
                <input type="password" name="password_confirmation" class="input input-bordered w-full" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Role</span>
                </label>
                <select name="role" id="role" class="select select-bordered w-full" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="coordinator">Coordinator</option>
                    <option value="technician">Technician</option>
                </select>
            </div>

            <div id="crop_category_field" class="form-control hidden">
                <label class="label">
                    <span class="label-text">Crop Category (For Coordinators)</span>
                </label>
                <select name="crop_category" class="select select-bordered w-full">
                    <option value="">Select Crop Category</option>
                    <option value="Rice">Rice</option>
                    <option value="Corn">Corn</option>
                    <option value="High Value Crops">High Value Crops</option>
                </select>
            </div>

            <div id="coordinator_field" class="form-control hidden">
                <label class="label">
                    <span class="label-text">Assign Coordinator (For Technicians)</span>
                </label>
                <select name="coordinator_id" class="select select-bordered w-full">
                    <option value="">Select Coordinator</option>
                    @foreach($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control mt-6 grid grid-cols-2 gap-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create User</button>
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
