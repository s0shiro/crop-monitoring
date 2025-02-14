<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-bold mb-4">Create Crop Planting Record</h2>

        <form action="{{ route('crop_plantings.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Farmer</span>
                </label>
                <select name="farmer_id" required class="select select-bordered w-full">
                    <option value="">Select Farmer</option>
                    @foreach ($farmers as $farmer)
                        <option value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Category</span>
                </label>
                <select name="category_id" id="category" required class="select select-bordered w-full">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Crop</span>
                </label>
                <select name="crop_id" id="crop" required class="select select-bordered w-full">
                    <option value="">Select Crop</option>
                    @foreach ($categories as $category)
                        @foreach ($category->crops as $crop)
                            <option value="{{ $crop->id }}" data-category="{{ $category->id }}">{{ $crop->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Variety</span>
                </label>
                <select name="variety_id" id="variety" required class="select select-bordered w-full">
                    <option value="">Select Variety</option>
                    @foreach ($categories as $category)
                        @foreach ($category->crops as $crop)
                            @foreach ($crop->varieties as $variety)
                                <option value="{{ $variety->id }}" data-crop="{{ $crop->id }}">{{ $variety->name }}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Planting Date</span>
                </label>
                <input type="date" name="planting_date" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Area Planted (ha)</span>
                </label>
                <input type="number" name="area_planted" step="0.01" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Quantity</span>
                </label>
                <input type="number" name="quantity" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Expenses</span>
                </label>
                <input type="number" name="expenses" step="0.01" class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Location</span>
                </label>
                <input type="text" name="location" required class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select name="status" required class="select select-bordered w-full">
                    <option value="standing">Standing</option>
                    <option value="harvest">Harvest</option>
                    <option value="harvested">Harvested</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Remarks</span>
                </label>
                <textarea name="remarks" class="textarea textarea-bordered w-full"></textarea>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("category").addEventListener("change", function() {
            let categoryId = this.value;
            document.querySelectorAll("#crop option").forEach(option => {
                option.hidden = option.getAttribute("data-category") !== categoryId;
            });
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
