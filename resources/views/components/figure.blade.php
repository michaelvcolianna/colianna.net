@props(['width', 'height', 'alt', 'src', 'sizes'])

<figure>
    <img
        loading="lazy"
        width="{{ $width }}"
        height="{{ $height }}"
        src="{{ $src }}"
        alt="{{ $alt }}"
        srcset="{{ $srcset }}"
        sizes="{{ $sizes }}"
    >

    <figcaption>
        {{ $caption }}
    </figcaption>
</figure>
