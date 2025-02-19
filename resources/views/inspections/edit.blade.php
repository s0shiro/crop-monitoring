<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-base-content">Edit Crop Inspection</h2>
            <p class="text-base-content/70 mt-1">Update inspection details for the crop planting</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('crop_inspections.update', $inspection) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Display validation errors if any -->
                    @if ($errors->any())
                        <div role="alert" class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Inspection Date -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Inspection Date</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="date"
                               name="inspection_date"
                               value="{{ old('inspection_date', $inspection->inspection_date) }}"
                               class="input input-bordered w-full"
                               required>
                    </div>

                    <!-- Damaged Area -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Damaged Area</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <div class="join">
                            <input type="number"
                                   name="damaged_area"
                                   value="{{ old('damaged_area', $inspection->damaged_area) }}"
                                   step="0.01"
                                   min="0"
                                   class="input input-bordered join-item w-full"
                                   required>
                            <span class="btn btn-neutral join-item no-animation">hectares</span>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Remarks</span>
                            <span class="label-text-alt text-base-content/70">Optional</span>
                        </label>
                        <textarea name="remarks"
                                  class="textarea textarea-bordered w-full min-h-[120px]"
                                  placeholder="Enter any additional observations or notes">{{ old('remarks', $inspection->remarks) }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('crop_plantings.show', $inspection->crop_planting_id) }}"
                           class="btn btn-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 mr-2"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Update Inspection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
