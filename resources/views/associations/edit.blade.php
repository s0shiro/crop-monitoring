<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('associations.index') }}">Associations</a></li>
                <li><a href="{{ route('associations.show', $association) }}">{{ $association->name }}</a></li>
                <li>Edit</li>
            </ul>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Edit Association</h2>
            <p class="text-base-content/70 mt-1">Update the information for {{ $association->name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Edit Form -->
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="{{ route('associations.update', $association) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div role="alert" class="alert alert-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h3 class="font-bold">Please fix the following errors:</h3>
                                        <ul class="mt-1 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Association Name</span>
                                    <span class="label-text-alt text-error">Required</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $association->name) }}"
                                       class="input input-bordered @error('name') input-error @enderror w-full"
                                       placeholder="Enter association name"
                                       required>
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Description</span>
                                    <span class="label-text-alt text-base-content/70">Optional</span>
                                </label>
                                <textarea name="description"
                                          class="textarea textarea-bordered min-h-[120px] @error('description') textarea-error @enderror"
                                          placeholder="Enter a brief description of the association">{{ old('description', $association->description) }}</textarea>
                                @error('description')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row justify-end gap-2 pt-4">
                                <a href="{{ route('associations.show', $association) }}" class="btn btn-ghost">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Save Changes
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
                                    <h4 class="font-medium">Delete this association</h4>
                                    <p class="text-sm text-base-content/70">Once deleted, this cannot be undone.</p>
                                </div>
                                <button onclick="deleteModal.showModal()" class="btn btn-error btn-sm">
                                    Delete Association
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Information -->
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold mb-4">Association Details</h3>

                        <!-- Stats -->
                        <div class="stats stats-vertical shadow w-full">
                            <div class="stat">
                                <div class="stat-title">Total Members</div>
                                <div class="stat-value">{{ $association->farmers()->count() }}</div>
                            </div>

                            <div class="stat">
                                <div class="stat-title">Created</div>
                                <div class="stat-value text-sm">{{ $association->created_at->format('M d, Y') }}</div>
                                <div class="stat-desc">{{ $association->created_at->diffForHumans() }}</div>
                            </div>

                            <div class="stat">
                                <div class="stat-title">Last Updated</div>
                                <div class="stat-value text-sm">{{ $association->updated_at->format('M d, Y') }}</div>
                                <div class="stat-desc">{{ $association->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="mt-6">
                            <h4 class="font-medium mb-2">Tips</h4>
                            <ul class="text-sm text-base-content/70 space-y-2">
                                <li class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Keep the association name clear and unique
                                </li>
                                <li class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Add a detailed description to help members
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Delete Association</h3>
            <p class="py-4">This action cannot be undone. Please type <strong>{{ $association->name }}</strong> to confirm.</p>

            <form action="{{ route('associations.destroy', $association) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <input type="text"
                       id="confirmationInput"
                       class="input input-bordered w-full mt-2"
                       placeholder="Type the association name here"
                       required>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="deleteModal.close()">Cancel</button>
                    <button type="submit"
                            class="btn btn-error"
                            id="confirmDeleteBtn"
                            disabled>Delete Association</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Delete Confirmation Script -->
    <script>
        const confirmationInput = document.getElementById('confirmationInput');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const associationName = @json($association->name);

        confirmationInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== associationName;
        });
    </script>
</x-app-layout>
