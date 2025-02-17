<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-base-content">{{ $association->name }}</h2>
                    <p class="text-base-content/70 mt-1">{{ $association->description }}</p>
                </div>
                <a href="{{ route('associations.index') }}" class="btn btn-ghost">
                    Back to Associations
                </a>
            </div>
        </div>

        <!-- Farmers Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="p-4 border-b">
                    <h3 class="text-xl font-bold">Member Farmers</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="border-b-2 border-base-200">
                                <th class="bg-base-100 text-base-content/70">Name</th>
                                <th class="bg-base-100 text-base-content/70">RSBSA</th>
                                <th class="bg-base-100 text-base-content/70">Gender</th>
                                <th class="bg-base-100 text-base-content/70">Land Size</th>
                                <th class="bg-base-100 text-base-content/70">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($farmers as $farmer)
                                <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                    <td class="font-medium">{{ $farmer->name }}</td>
                                    <td>{{ $farmer->rsbsa }}</td>
                                    <td>{{ $farmer->gender }}</td>
                                    <td>{{ $farmer->landsize }} hectares</td>
                                    <td>{{ $farmer->barangay }}, {{ $farmer->municipality }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No farmers found in this association.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
