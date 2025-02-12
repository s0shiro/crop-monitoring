<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
            <div class="card-body">
                <h2 class="card-title">Edit Crop</h2>

                <form action="{{ route('crops.update', $crop) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" value="{{ $crop->name }}" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select name="category" class="select select-bordered" required>
                            <option value="Rice" {{ $crop->category == 'Rice' ? 'selected' : '' }}>Rice</option>
                            <option value="Corn" {{ $crop->category == 'Corn' ? 'selected' : '' }}>Corn</option>
                            <option value="High Value Crops" {{ $crop->category == 'High Value Crops' ? 'selected' : '' }}>High Value Crops</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Variety</span>
                        </label>
                        <input type="text" name="variety" value="{{ $crop->variety }}" class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered h-24">{{ $crop->description }}</textarea>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('crops.index') }}" class="btn">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
