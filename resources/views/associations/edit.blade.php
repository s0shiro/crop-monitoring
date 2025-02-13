<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Edit Association</h2>
            <p class="text-base-content/70 mt-1">Update association information</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('associations.update', $association) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')

                    @if ($errors->any())
                        <div role="alert" class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Association Name</span>
                        </label>
                        <input type="text" name="name" value="{{ $association->name }}"
                               class="input input-bordered w-full" required>
                    </div>

                    <!-- Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered w-full">{{ $association->description }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('associations.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Association</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
