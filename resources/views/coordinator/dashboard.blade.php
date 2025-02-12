<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-lg font-semibold">Dashboard</h2>

        @if (Auth::user()->hasRole('coordinator'))
            <p>Managing Crop Category: {{ Auth::user()->crop_category }}</p>
            <p>Assigned Technicians:</p>
            <ul>
                @foreach (Auth::user()->technicians as $tech)
                    <li>{{ $tech->name }} ({{ $tech->email }})</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
