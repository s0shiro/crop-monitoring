<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Harvest Reports') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Farmer</th>
                                <th>Harvest Date</th>
                                <th>Area Harvested</th>
                                <th>Total Yield</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->cropPlanting->crop->name }}</td>
                                    <td>{{ $report->cropPlanting->farmer->name }}</td>
                                    <td>{{ $report->harvest_date->format('M d, Y') }}</td>
                                    <td>{{ number_format($report->area_harvested, 2) }} ha</td>
                                    <td>{{ number_format($report->total_yield, 2) }} kg</td>
                                    <td>
                                        <a href="{{ route('harvest_reports.show', $report) }}"
                                           class="btn btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
