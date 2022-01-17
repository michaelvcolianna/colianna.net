@props(['slug', 'label', 'date'])

<li>
    <span class="date">{{ $date }}</span>
    <a href="{{ route('work.view', ['slug' => $slug]) }}">{{ $label }}</a>
</li>
