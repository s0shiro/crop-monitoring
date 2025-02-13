<x-app-layout>
    <div class="max-w-lg mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-6">Edit Crop</h2>

        <form action="{{ route('crops.update', $crop) }}" method="POST" class="space-y-4">
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

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Category <span class="text-error">*</span></span>
                </label>
                <select
                    name="category_id"
                    id="category"
                    class="select select-bordered w-full @error('category_id') select-error @enderror"
                    required
                >
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $crop->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Crop Name</span>
                </label>
                <input type="text" name="name" value="{{ $crop->name }}" class="input input-bordered w-full" required>
            </div>

            <div class="form-control" x-data="{ varieties: {{ json_encode($crop->varieties->pluck('name')) }} }">
                <label class="label">
                    <span class="label-text">Varieties</span>
                </label>
                <div id="varieties-list" class="space-y-2">
                    <template x-for="(variety, index) in varieties" :key="index">
                        <div class="flex gap-2 items-center">
                            <input type="text" name="varieties[]" x-model="varieties[index]" class="input input-bordered w-full">
                            <button type="button" @click="varieties = varieties.filter((_, i) => i !== index)" class="btn btn-square btn-error btn-sm flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="varieties.push('')" class="btn btn-ghost btn-sm mt-2">
                    + Add Variety
                </button>
            </div>

            <div class="form-control mt-6 grid grid-cols-2 gap-4">
                <a href="{{ route('crops.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Crop</button>
            </div>
        </form>
    </div>
</x-app-layout>
