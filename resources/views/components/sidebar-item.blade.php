@props(['route', 'icon', 'title'])

<li>
    <a href="{{ route($route) }}" class="{{ str_starts_with(request()->route()->getName(), str_replace('index', '', $route)) ? 'active' : '' }}">
        <x-dynamic-component :component="'icons.'.$icon" class="h-5 w-5" />
        {{ $title }}
    </a>
</li>
