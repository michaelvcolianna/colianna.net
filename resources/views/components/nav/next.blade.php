@props(['slug', 'label'])

<span class="nav-next"><a href="{{ route('work.view', ['slug' => $slug]) }}">{{ $label }}</a> &rarr;</span>
