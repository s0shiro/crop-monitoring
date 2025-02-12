<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
            <div class="card-body">
                <h2 class="card-title">Add New Crop</h2>

                <form action="{{ route('crops.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select name="category" class="select select-bordered" required>
                            <option value="">Select category</option>
                            <option value="Rice">Rice</option>
                            <option value="Corn">Corn</option>
                            <option value="High Value Crops">High Value Crops</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Variety</span>
                        </label>
                        <input type="text" name="variety" class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered h-24"></textarea>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('crops.index') }}" class="btn">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
