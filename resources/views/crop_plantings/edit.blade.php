<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold mb-6">Edit Crop Planting Record</h2>

                <form action="{{ route('crop_plantings.update', $cropPlanting->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Farmer Selection (Read-only) -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Farmer</span>
                            </label>
                            <input type="text" value="{{ $farmers->find($cropPlanting->farmer_id)->name }}" class="input input-primary w-full" disabled>
                            <input type="hidden" name="farmer_id" value="{{ $cropPlanting->farmer_id }}">
                        </div>

                        <!-- Category Selection -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Category</span>
                            </label>
                            <select name="category_id" id="category" class="select select-primary w-full" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $cropPlanting->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Crop Selection -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Crop</span>
                            </label>
                            <select name="crop_id" id="crop" class="select select-primary w-full" required>
                                @foreach ($categories as $category)
                                    @foreach ($category->crops as $crop)
                                        <option value="{{ $crop->id }}" data-category="{{ $category->id }}" {{ $cropPlanting->crop_id == $crop->id ? 'selected' : '' }}>
                                            {{ $crop->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Variety Selection -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Variety</span>
                            </label>
                            <select name="variety_id" id="variety" class="select select-primary w-full" required>
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

                        <!-- Planting Date -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Planting Date</span>
                            </label>
                            <input type="date" name="planting_date" value="{{ $cropPlanting->planting_date }}" class="input input-primary" required>
                        </div>

                        <!-- Area Planted -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Area Planted (ha)</span>
                            </label>
                            <input type="number" name="area_planted" value="{{ $cropPlanting->area_planted }}" step="0.01" class="input input-primary" required>
                        </div>

                        <!-- Quantity -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Quantity</span>
                            </label>
                            <input type="number" name="quantity" value="{{ $cropPlanting->quantity }}" class="input input-primary" required>
                        </div>

                        <!-- Expenses -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Expenses</span>
                            </label>
                            <input type="number" name="expenses" value="{{ $cropPlanting->expenses }}" step="0.01" class="input input-primary">
                        </div>

                        <!-- Map Section -->
                        <div class="form-control col-span-2">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Location (Click on map to update)</span>
                            </label>
                            <div id="map" class="w-full h-96 rounded-box border-2 border-primary"></div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">Latitude</span>
                                    </label>
                                    <input type="number" name="latitude" id="latitude" value="{{ $cropPlanting->latitude }}"
                                        step="any" class="input input-primary" required readonly>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">Longitude</span>
                                    </label>
                                    <input type="number" name="longitude" id="longitude" value="{{ $cropPlanting->longitude }}"
                                        step="any" class="input input-primary" required readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Status</span>
                            </label>
                            <select name="status" class="select select-primary w-full" required>
                                <option value="standing" {{ $cropPlanting->status == 'standing' ? 'selected' : '' }}>Standing</option>
                                <option value="harvest" {{ $cropPlanting->status == 'harvest' ? 'selected' : '' }}>Harvest</option>
                                <option value="harvested" {{ $cropPlanting->status == 'harvested' ? 'selected' : '' }}>Harvested</option>
                            </select>
                        </div>

                        <!-- Remarks -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-base font-semibold">Remarks</span>
                            </label>
                            <select name="remarks" class="select select-primary w-full" required>
                                <option value="newly planted" {{ $cropPlanting->remarks == 'newly planted' ? 'selected' : '' }}>Newly Planted</option>
                                <option value="vegetative" {{ $cropPlanting->remarks == 'vegetative' ? 'selected' : '' }}>Vegetative</option>
                                <option value="reproductive" {{ $cropPlanting->remarks == 'reproductive' ? 'selected' : '' }}>Reproductive</option>
                                <option value="maturing" {{ $cropPlanting->remarks == 'maturing' ? 'selected' : '' }}>Maturing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full md:w-auto">Update Record</button>
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

        // Define Marinduque bounds with padding
        const marinduqueBounds = L.latLngBounds(
            [13.1089, 121.7813], // Southwest corner with padding
            [13.5474, 122.2411]  // Northeast corner with padding
        );

        // Initialize map centered on existing coordinates or Marinduque center
        var map = L.map('map', {
            center: [
                {{ $cropPlanting->latitude ?? '13.4677' }},
                {{ $cropPlanting->longitude ?? '121.9037' }}
            ],
            zoom: 10,
            minZoom: 10,
            maxZoom: 18,
            maxBounds: marinduqueBounds
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add initial marker if coordinates exist
        var marker = {{ $cropPlanting->latitude && $cropPlanting->longitude ? 'L.marker([' . $cropPlanting->latitude . ', ' . $cropPlanting->longitude . ']).addTo(map)' : 'null' }};

        map.on('click', function(e) {
            if (marinduqueBounds.contains(e.latlng)) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            }
        });
    </script>
</x-app-layout>
