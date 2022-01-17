@props(['href', 'label'])

<a href="{{ $href }}" target="_blank" rel="noopener noreferrer" aria-labelledby="external-site-label new-window-label">{{ $label }} <span class="ext-link">(new tab)</span></a>