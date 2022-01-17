@props(['heading' => null, 'subHeading' => null])

<header class="title">
    @if(isset($heading))
        <h1>{{ $heading }}</h1>
    @endif

    @if(isset($subHeading))
        <h3>{{ $subHeading }}</h3>
    @endif

    {{ $slot }}

    @if(isset($heading) || isset($subHeading))
        <hr>
    @endif
</header>
