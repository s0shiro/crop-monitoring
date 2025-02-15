<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold mb-6">Create Crop Planting Record</h2>

                <form action="{{ route('crop_plantings.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Farmer Selection -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Farmer</span>
                            </label>
                            <select name="farmer_id" required class="select select-bordered w-full">
                                <option value="">Select Farmer</option>
                                @foreach ($farmers as $farmer)
                                    <option value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category Selection -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Category</span>
                            </label>
                            <select name="category_id" id="category" required class="select select-bordered w-full">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Crop Selection -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Crop</span>
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

                        <!-- Variety Selection -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Variety</span>
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

                        <!-- Planting Date -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Planting Date</span>
                            </label>
                            <input type="date" name="planting_date" required class="input input-bordered w-full">
                        </div>

                        <!-- Area Planted -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Area Planted (ha)</span>
                            </label>
                            <input type="number" name="area_planted" step="0.01" required class="input input-bordered w-full">
                        </div>

                        <!-- Quantity -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Quantity</span>
                            </label>
                            <input type="number" name="quantity" required class="input input-bordered w-full">
                        </div>

                        <!-- Expenses -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Expenses</span>
                            </label>
                            <input type="number" name="expenses" step="0.01" class="input input-bordered w-full">
                        </div>

                        <!-- Location -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Location</span>
                            </label>
                            <input type="text" name="location" required class="input input-bordered w-full">
                        </div>

                        <!-- Status -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Status</span>
                            </label>
                            <select name="status" required class="select select-bordered w-full">
                                <option value="standing">Standing</option>
                                <option value="harvest">Harvest</option>
                                <option value="harvested">Harvested</option>
                            </select>
                        </div>

                        <!-- Remarks -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Remarks</span>
                            </label>
                            <select name="remarks" required class="select select-bordered w-full">
                                <option value="newly planted">Newly Planted</option>
                                <option value="vegetative">Vegetative</option>
                                <option value="reproductive">Reproductive</option>
                                <option value="maturing">Maturing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full md:w-auto">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
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
