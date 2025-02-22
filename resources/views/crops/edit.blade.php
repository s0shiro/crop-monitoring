<x-app-layout>
    <div class="w-full p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-6 text-primary">Edit Crop</h2>

                <form action="{{ route('crops.update', $crop) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Category Selection -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Category</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </span>
                                <select name="category_id" class="select select-bordered w-full pl-10" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $crop->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <!-- Crop Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Crop Name</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $crop->name) }}"
                                       class="input input-bordered w-full pl-10" required>
                            </div>
                            @error('name')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>

                    <!-- Varieties Section -->
                    <div class="form-control mt-6" x-data="{
                        varieties: {{ json_encode($crop->varieties->map(fn($v) => [
                            'name' => $v->name,
                            'maturity_days' => $v->maturity_days
                        ])) }},
                        addVariety() {
                            this.varieties.push({ name: '', maturity_days: '' })
                        }
                    }">
                        <label class="label">
                            <span class="label-text font-semibold">Varieties</span>
                            <button type="button" @click="addVariety" class="btn btn-ghost btn-sm">
                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Variety
                            </button>
                        </label>

                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="space-y-4" id="varieties-container">
                                <template x-for="(variety, index) in varieties" :key="index">
                                    <div class="grid md:grid-cols-2 gap-4 p-4 bg-base-100 rounded-lg shadow">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Variety Name</span>
                                            </label>
                                            <input type="text" :name="'varieties[' + index + ']'"
                                                   x-model="variety.name"
                                                   class="input input-bordered w-full"
                                                   placeholder="Enter variety name">
                                        </div>
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Maturity Days</span>
                                            </label>
                                            <div class="join">
                                                <input type="number" :name="'maturity_days[' + index + ']'"
                                                       x-model="variety.maturity_days"
                                                       class="input input-bordered w-full join-item"
                                                       placeholder="Days to maturity">
                                                <button type="button"
                                                        @click="varieties = varieties.filter((_, i) => i !== index)"
                                                        class="btn btn-error join-item">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('crops.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Crop
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
                            <h4 class="font-medium">Delete this crop</h4>
                            <p class="text-sm text-base-content/70">Once deleted, all crop data and varieties will be permanently removed.</p>
                        </div>
                        <button onclick="deleteModal.showModal()" class="btn btn-error btn-sm">
                            Delete Crop
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Delete Crop</h3>
            <p class="py-4">This action cannot be undone. Please type <strong>{{ $crop->name }}</strong> to confirm.</p>

            <form action="{{ route('crops.destroy', $crop) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <input type="text"
                       id="confirmationInput"
                       class="input input-bordered w-full mt-2"
                       placeholder="Type the crop name here"
                       required>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="deleteModal.close()">Cancel</button>
                    <button type="submit"
                            class="btn btn-error"
                            id="confirmDeleteBtn"
                            disabled>Delete Crop</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        const confirmationInput = document.getElementById('confirmationInput');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cropName = @json($crop->name);

        confirmationInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== cropName;
        });
    </script>
</x-app-layout>
