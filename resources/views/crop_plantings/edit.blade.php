<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-bold mb-4">Edit Crop Planting</h2>

        <form action="{{ route('crop_plantings.update', $cropPlanting->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Farmer</span>
                </label>
                <select name="farmer_id" required class="select select-bordered w-full">
                    @foreach ($farmers as $farmer)
                        <option value="{{ $farmer->id }}" {{ $cropPlanting->farmer_id == $farmer->id ? 'selected' : '' }}>
                            {{ $farmer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Category</span>
                </label>
                <select name="category_id" id="category" required class="select select-bordered w-full">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $cropPlanting->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Crop</span>
                </label>
                <select name="crop_id" id="crop" required class="select select-bordered w-full">
                    @foreach ($categories as $category)
                        @foreach ($category->crops as $crop)
                            <option value="{{ $crop->id }}" data-category="{{ $category->id }}" {{ $cropPlanting->crop_id == $crop->id ? 'selected' : '' }}>
                                {{ $crop->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Variety</span>
                </label>
                <select name="variety_id" id="variety" required class="select select-bordered w-full">
                    @foreach ($categories as $category)
                        @foreach ($category->crops as $crop)
                            @foreach ($crop->varieties as $variety)
                                <option value="{{ $variety->id }}" data-crop="{{ $crop->id }}" {{ $cropPlanting->variety_id == $variety->id ? 'selected' : '' }}>
                                    {{ $variety->name }}
                                </option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Planting Date</span>
                </label>
                <input type="date" name="planting_date" value="{{ $cropPlanting->planting_date }}" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Area Planted (ha)</span>
                </label>
                <input type="number" name="area_planted" value="{{ $cropPlanting->area_planted }}" step="0.01" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Quantity</span>
                </label>
                <input type="number" name="quantity" value="{{ $cropPlanting->quantity }}" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Expenses</span>
                </label>
                <input type="number" name="expenses" value="{{ $cropPlanting->expenses }}" step="0.01" class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Location</span>
                </label>
                <input type="text" name="location" value="{{ $cropPlanting->location }}" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select name="status" required class="select select-bordered w-full">
                    <option value="standing" {{ $cropPlanting->status == 'standing' ? 'selected' : '' }}>Standing</option>
                    <option value="harvest" {{ $cropPlanting->status == 'harvest' ? 'selected' : '' }}>Harvest</option>
                    <option value="harvested" {{ $cropPlanting->status == 'harvested' ? 'selected' : '' }}>Harvested</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Remarks</span>
                </label>
                <textarea name="remarks" class="textarea textarea-bordered w-full">{{ $cropPlanting->remarks }}</textarea>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("category").addEventListener("change", function() {
            let categoryId = this.value;
            document.getElementById("crop").value = "";
            document.getElementById("variety").value = "";
        });

        document.getElementById("crop").addEventListener("change", function() {
            let cropId = this.value;
            document.querySelectorAll("#variety option").forEach(option => {
                option.hidden = option.getAttribute("data-crop") !== cropId;
            });
        });
    </script>
</x-app-layout>
