<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto p-2 sm:p-4 md:p-6">
        <div class="text-sm breadcrumbs mb-2 sm:mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('crop_plantings.index') }}">Crop Plantings</a></li>
                <li class="text-primary">Edit Record</li>
            </ul>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-3 sm:p-4 md:p-6">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-base-200 pb-4 mb-6 gap-4 sm:gap-2">
                    <div>
                        <h2 class="card-title text-xl sm:text-2xl font-bold">Edit Crop Planting Record</h2>
                        <p class="text-base-content/70 text-sm sm:text-base">Update the details of your crop planting record</p>
                    </div>
                    <div class="flex w-full sm:w-auto gap-2">
                        <a href="{{ route('crop_plantings.index') }}" class="btn btn-ghost flex-1 sm:flex-none">Cancel</a>
                        <button form="editForm" type="submit" class="btn btn-primary flex-1 sm:flex-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 hidden sm:inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sm:hidden">Save</span>
                            <span class="hidden sm:inline">Save Changes</span>
                        </button>
                    </div>
                </div>

                <!-- Main Form -->
                <form id="editForm" action="{{ route('crop_plantings.update', $cropPlanting->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="card bg-base-200 shadow-sm">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Farmer Selection -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Farmer</span>
                                    </label>
                                    <div class="join w-full">
                                        <div class="btn btn-square join-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.660.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                        </div>
                                        <input type="text" value="{{ $farmers->find($cropPlanting->farmer_id)->name }}" class="input input-bordered join-item w-full" disabled>
                                        <input type="hidden" name="farmer_id" value="{{ $cropPlanting->farmer_id }}">
                                    </div>
                                </div>

                                <!-- Category, Crop, Variety Selections -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Category</span>
                                    </label>
                                    <select name="category_id" id="category" class="select select-bordered w-full" required>
                                        <option value="">Select Category</option>
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
                                        <span class="label-text font-medium">Crop</span>
                                    </label>
                                    <select name="crop_id" id="crop" class="select select-bordered w-full" required>
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
                                        <span class="label-text font-medium">Variety</span>
                                    </label>
                                    <select name="variety_id" id="variety" class="select select-bordered w-full" required>
                                        @foreach ($categories->find($cropPlanting->category_id)->crops->find($cropPlanting->crop_id)->varieties as $variety)
                                            <option value="{{ $variety->id }}" data-crop="{{ $cropPlanting->crop_id }}" {{ $cropPlanting->variety_id == $variety->id ? 'selected' : '' }}>
                                                {{ $variety->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Planting Date -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Planting Date</span>
                                    </label>
                                    <input type="date" name="planting_date" value="{{ $cropPlanting->planting_date }}" class="input input-bordered" required>
                                </div>

                                <!-- Area Planted -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Area Planted (ha)</span>
                                    </label>
                                    <input type="number" name="area_planted" value="{{ $cropPlanting->area_planted }}" step="0.01" class="input input-bordered" required>
                                </div>

                                <!-- Quantity -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Quantity</span>
                                    </label>
                                    <input type="number" name="quantity" value="{{ $cropPlanting->quantity }}" class="input input-bordered" required>
                                </div>

                                <!-- Expenses -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Expenses</span>
                                    </label>
                                    <input type="number" name="expenses" value="{{ $cropPlanting->expenses }}" step="0.01" class="input input-bordered">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="card bg-base-200 shadow-sm">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Location Details</h3>
                            <div class="space-y-4">
                                <div id="map" class="w-full h-[400px] rounded-xl border-2 border-primary/20 shadow-inner"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Latitude</span>
                                        </label>
                                        <input type="number" name="latitude" id="latitude" value="{{ $cropPlanting->latitude }}"
                                            step="any" class="input input-bordered" required readonly>
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Longitude</span>
                                        </label>
                                        <input type="number" name="longitude" id="longitude" value="{{ $cropPlanting->longitude }}"
                                            step="any" class="input input-bordered" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="card bg-base-200 shadow-sm">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-4">Status & Remarks</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Status</span>
                                    </label>
                                    <select name="status" class="select select-bordered w-full" required>
                                        @foreach(['standing' => 'Standing', 'harvest' => 'Ready for Harvest', 'harvested' => 'Harvested'] as $value => $label)
                                            <option value="{{ $value }}" {{ $cropPlanting->status == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Growth Stage</span>
                                    </label>
                                    <select name="remarks" class="select select-bordered w-full" required>
                                        @foreach(['newly planted' => 'Newly Planted', 'vegetative' => 'Vegetative', 'reproductive' => 'Reproductive', 'maturing' => 'Maturing'] as $value => $label)
                                            <option value="{{ $value }}" {{ $cropPlanting->remarks == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("category").addEventListener("change", function() {
            let categoryId = this.value;
            let cropSelect = document.getElementById("crop");
            let varietySelect = document.getElementById("variety");

            // Hide all crop options first
            cropSelect.querySelectorAll("option").forEach(option => {
                option.hidden = option.getAttribute("data-category") !== categoryId;
            });

            // Reset crop and variety selections
            cropSelect.value = "";
            varietySelect.innerHTML = '<option value="">Select Variety</option>';
        });

        document.getElementById("crop").addEventListener("change", function() {
            let cropId = this.value;
            let varietySelect = document.getElementById("variety");

            // Clear and reset variety dropdown
            varietySelect.innerHTML = '<option value="">Select Variety</option>';

            // Get all varieties for selected crop
            if (cropId) {
                let varieties = @json($categories->pluck('crops')->flatten()->pluck('varieties')->flatten());
                varieties.filter(v => v.crop_id == cropId).forEach(variety => {
                    let option = new Option(variety.name, variety.id);
                    varietySelect.add(option);
                });
            }
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

    @push('scripts')
    <script>
        // Add loading state to form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.classList.add('loading');
        });
    </script>
    @endpush
</x-app-layout>
