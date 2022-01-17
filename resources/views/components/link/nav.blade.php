@props(['route' => null, 'name', 'label'])

<li class="{{ request()->routeIs($route ?? $name) ? 'active' : '' }}">
    <a href="{{ route($name) }}" aria-current="{{ request()->routeIs($route ?? $name) ? 'page' : 'false' }}">{{ $label }}</a>
</li>
