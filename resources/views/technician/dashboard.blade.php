<x-app-layout>
    @if (Auth::user()->hasRole('technician'))
        <p>Assigned Coordinator: {{ Auth::user()->coordinator->name ?? 'None' }}</p>
        <p>Allowed Crop Category: {{ Auth::user()->coordinator->crop_category ?? 'Not Assigned' }}</p>
    @endif
</x-app-layout>
