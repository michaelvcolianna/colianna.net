@props(['slug', 'label'])

<span class="nav-prev">&larr; <a href="{{ route('work.view', ['slug' => $slug]) }}">{{ $label }}</a></span>
