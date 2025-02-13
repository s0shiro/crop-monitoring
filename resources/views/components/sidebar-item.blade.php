@props(['route', 'icon', 'title'])

<li>
    <a href="{{ route($route) }}" class="{{ request()->routeIs($route.'*') ? 'active' : '' }}">
        <x-dynamic-component :component="'icons.'.$icon" class="h-5 w-5" />
        {{ $title }}
    </a>
</li>
