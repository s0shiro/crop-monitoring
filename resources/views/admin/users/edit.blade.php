<x-app-layout>
    <div class="max-w-2xl mx-auto p-6" x-data="{ roles: @json($user->roles->pluck('name')), permissions: @json($user->permissions->pluck('name')) }">
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
                <div class="dropdown">
                    <label tabindex="0" class="btn m-1">Select Role</label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52" style="z-index: 50;">
                        @foreach ($roles as $role)
                            <li>
                                <label class="cursor-pointer">
                                    <input type="radio" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }} class="radio">
                                    <span class="ml-2">{{ $role->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-control">
                <label for="permissions" class="label">
                    <span class="label-text">Permissions</span>
                </label>
                <div class="dropdown">
                    <label tabindex="0" class="btn m-1">Select Permissions</label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52" style="z-index: 50;">
                        @foreach ($permissions as $permission)
                            <li>
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }} class="checkbox">
                                    <span class="ml-2">{{ $permission->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">
                    Update User
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
