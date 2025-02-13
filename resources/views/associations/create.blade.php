<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Add Association</h2>
            <p class="text-base-content/70 mt-1">Create a new farmer association</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('associations.store') }}" method="POST" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div role="alert" class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Association Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered w-full" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered w-full"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('associations.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Association</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
