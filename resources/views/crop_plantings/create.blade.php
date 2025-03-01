<x-app-layout>
    <div data-turbo="false">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-3xl font-bold mb-6">Create Crop Planting Record</h2>

                    <!-- Steps -->
                    <ul class="steps steps-horizontal w-full mb-8">
                        <li class="step step-primary" data-content="1">Basic Info</li>
                        <li class="step" data-content="2">Location</li>
                        <li class="step" data-content="3">Additional Details</li>
                    </ul>

                    <form id="plantingForm" action="{{ route('crop_plantings.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Step 1: Basic Info -->
                        <div id="step1" class="space-y-4">
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

                                <!-- High Value Crops Classification -->
                                <div id="hvc-fields" class="form-control w-full hidden">
                                    <label class="label">
                                        <span class="label-text font-medium">Classification</span>
                                    </label>
                                    <select name="hvc_classification" class="select select-bordered w-full">
                                        <option value="">Select Classification</option>
                                        <option value="lowland vegetable">Lowland Vegetable</option>
                                        <option value="upland vegetable">Upland Vegetable</option>
                                        <option value="legumes">Legumes</option>
                                        <option value="spice">Spice</option>
                                        <option value="rootcrop">Rootcrop</option>
                                        <option value="fruit">Fruit</option>
                                    </select>
                                </div>

                                <!-- Rice Fields -->
                                <div id="rice-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text font-medium">Classification</span>
                                        </label>
                                        <select name="rice_classification" class="select select-bordered w-full">
                                            <option value="">Select Classification</option>
                                            <option value="Hybrid">Hybrid</option>
                                            <option value="Registered">Registered</option>
                                            <option value="Certified">Certified</option>
                                            <option value="Good Quality">Good Quality</option>
                                            <option value="Farmer Saved Seeds">Farmer Saved Seeds</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text font-medium">Water Supply</span>
                                        </label>
                                        <select name="water_supply" class="select select-bordered w-full">
                                            <option value="">Select Water Supply</option>
                                            <option value="irrigated">Irrigated</option>
                                            <option value="rainfed">Rainfed</option>
                                        </select>
                                    </div>

                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text font-medium">Land Type</span>
                                        </label>
                                        <select name="land_type" class="select select-bordered w-full">
                                            <option value="">None</option>
                                            <option value="lowland">Lowland</option>
                                            <option value="upland">Upland</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="validateAndNext(2)" class="btn btn-primary">Next</button>
                            </div>
                        </div>

                        <!-- Step 2: Location -->
                        <div id="step2" class="hidden space-y-4">
                            <div class="w-full h-[600px] relative">
                                <div id="map" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0;" class="rounded-lg border-2 border-primary"></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Latitude</span>
                                    </label>
                                    <input type="text" id="latitude" name="latitude" class="input input-bordered" readonly required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Longitude</span>
                                    </label>
                                    <input type="text" id="longitude" name="longitude" class="input input-bordered" readonly required>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Municipality</span>
                                    </label>
                                    <input type="text" id="municipality" name="municipality" class="input input-bordered" readonly required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Barangay</span>
                                    </label>
                                    <input type="text" id="barangay" name="barangay" class="input input-bordered" readonly required>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" onclick="prevStep(1)" class="btn btn-ghost">Previous</button>
                                <button type="button" onclick="validateAndNext(3)" class="btn btn-primary">Next</button>
                            </div>
                        </div>

                        <!-- Step 3: Additional Details -->
                        <div id="step3" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                            <div class="flex justify-between">
                                <button type="button" onclick="prevStep(2)" class="btn btn-ghost">Previous</button>
                                <button type="submit" class="btn btn-primary">Save Record</button>
                            </div>
                        </div>
                    </form>
                </div>
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

        // Add this inside your existing script tag, after the category change event listener
        document.getElementById("category").addEventListener("change", function() {
            let categoryId = this.value;
            let categoryName = this.options[this.selectedIndex].text.trim();
            let hvcFields = document.getElementById('hvc-fields');
            let riceFields = document.getElementById('rice-fields');

            // Hide all category-specific fields first
            hvcFields.classList.add('hidden');
            riceFields.classList.add('hidden');

            // Reset values when changing categories
            if (hvcFields.querySelector('select')) {
                hvcFields.querySelector('select').value = '';
            }
            if (riceFields.querySelectorAll('select')) {
                riceFields.querySelectorAll('select').forEach(select => select.value = '');
            }

            // Show relevant fields based on category
            if (categoryName === 'High Value Crops') {
                hvcFields.classList.remove('hidden');
            } else if (categoryName === 'Rice') {
                riceFields.classList.remove('hidden');
            }

            // Existing category change logic for crops
            document.querySelectorAll("#crop option").forEach(option => {
                option.hidden = option.getAttribute("data-category") !== categoryId;
            });
            document.getElementById("crop").value = "";
            document.getElementById("variety").value = "";
        });

        // Update validateStep1 to include category-specific required fields
        function validateStep1() {
            const baseFields = [
                document.querySelector('select[name="farmer_id"]'),
                document.querySelector('select[name="category_id"]'),
                document.querySelector('select[name="crop_id"]'),
                document.querySelector('select[name="variety_id"]')
            ];

            // Get the selected category
            const categorySelect = document.querySelector('select[name="category_id"]');
            const categoryName = categorySelect.options[categorySelect.selectedIndex].text.trim();

            let additionalFields = [];

            // Add category-specific required fields
            if (categoryName === 'High Value Crops') {
                additionalFields.push(document.querySelector('select[name="hvc_classification"]'));
            } else if (categoryName === 'Rice') {
                additionalFields.push(
                    document.querySelector('select[name="rice_classification"]'),
                    document.querySelector('select[name="water_supply"]')
                );
                // Land type is not required
            }

            return checkFields([...baseFields, ...additionalFields]);
        }

        document.getElementById("crop").addEventListener("change", function() {
            let cropId = this.value;
            document.querySelectorAll("#variety option").forEach(option => {
                option.hidden = option.getAttribute("data-crop") !== cropId;
            });
        });

        // Move map initialization to a dedicated function
        let map, marker;
        
        function initMap() {
            if (map) {
                map.remove();
            }

            // Define Marinduque bounds with padding
            const marinduqueBounds = L.latLngBounds(
                [13.1089, 121.7813],
                [13.5474, 122.2411]
            );

            // Initialize map
            map = L.map('map', {
                center: [13.4677, 121.9037],
                zoom: 10,
                minZoom: 10,
                maxZoom: 18,
                maxBounds: marinduqueBounds
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Re-add click handler
            map.on('click', async function(e) {
                if (marinduqueBounds.contains(e.latlng)) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;

                    await getLocationDetails(lat, lng);

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }
                }
            });
        }

        async function getLocationDetails(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                const data = await response.json();
                
                // Extract municipality and barangay from address
                const address = data.address;
                const municipality = address.town || address.city || address.municipality;
                const barangay = address.suburb || address.village || address.neighbourhood;
                
                // Update form fields
                document.getElementById('municipality').value = municipality || '';
                document.getElementById('barangay').value = barangay || '';
                
                return {municipality, barangay};
            } catch (error) {
                console.error('Error fetching location details:', error);
                return null;
            }
        }

        // Add these validation functions
        function checkFields(fields) {
            let isValid = true;
            fields.forEach(field => {
                if (!field.value) {
                    field.classList.add('input-error', 'select-error');
                    isValid = false;
                } else {
                    field.classList.remove('input-error', 'select-error');
                }
            });
            return isValid;
        }

        function validateStep1() {
            const fields = [
                document.querySelector('select[name="farmer_id"]'),
                document.querySelector('select[name="category_id"]'),
                document.querySelector('select[name="crop_id"]'),
                document.querySelector('select[name="variety_id"]')
            ];
            return checkFields(fields);
        }

        function validateStep2() {
        const fields = [
            document.getElementById('latitude'),
            document.getElementById('longitude'),
            document.getElementById('municipality'),
            document.getElementById('barangay')
        ];
        return checkFields(fields);
        }

        function validateStep3() {
            const fields = Array.from(document.querySelector('#step3').querySelectorAll('[required]'));
            return checkFields(fields);
        }

        // Replace nextStep function with validateAndNext
        function validateAndNext(step) {
            let isValid = true;

            switch (step - 1) {
                case 1:
                    isValid = validateStep1();
                    break;
                case 2:
                    isValid = validateStep2();
                    break;
            }

            if (isValid) {
                nextStep(step);
            }
        }

        // Update button handlers to use validateAndNext
        document.querySelectorAll('[onclick^="nextStep"]').forEach(btn => {
            const step = btn.getAttribute('onclick').match(/\d+/)[0];
            btn.setAttribute('onclick', `validateAndNext(${step})`);
        });

        // Add form submission validation
        document.getElementById('plantingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateStep3()) {
                this.submit();
            }
        });

        // Step navigation
        function nextStep(step) {
            document.querySelectorAll('.step').forEach((el, index) => {
                if (index <= step - 1) {
                    el.classList.add('step-primary');
                } else {
                    el.classList.remove('step-primary');
                }
            });
            hideAllSteps();
            document.getElementById(`step${step}`).classList.remove('hidden');
            
            if (step === 2) {
                // Use requestAnimationFrame to ensure DOM is updated
                requestAnimationFrame(() => {
                    initMap();
                    map.invalidateSize();
                });
            }
        }

        function prevStep(step) {
            document.querySelectorAll('.step').forEach((el, index) => {
                if (index < step) {
                    el.classList.add('step-primary');
                } else {
                    el.classList.remove('step-primary');
                }
            });
            hideAllSteps();
            document.getElementById(`step${step}`).classList.remove('hidden');
        }

        function hideAllSteps() {
            document.querySelectorAll('[id^="step"]').forEach(step => {
                step.classList.add('hidden');
            });
        }

        // Add this to your existing script section
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger map resize when step 2 is shown
            document.querySelector('[onclick="nextStep(2)"]').addEventListener('click', function() {
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
            });
        });
    </script>
</x-app-layout>
