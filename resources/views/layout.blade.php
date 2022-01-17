<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary">
        <meta property="description" content="{{ $description }}">
        <meta name="twitter:image" content="">
        <style>{!! $css !!}</style>
    </head>

    <body class="home">
        <header class="masthead">
            <h1><a href="{{ route('home') }}">Michael V. Colianna</a></h1>

            <p class="tagline">Author / Web Developer</p>

            <nav class="menu" aria-label="Site menu">
                <input id="menu-check" type="checkbox" hidden/>

                <label id="menu-label" for="menu-check" class="unselectable" hidden aria-controls="site-menu">
                    <span class="icon close-icon">✕</span>
                    <span class="icon open-icon">☰</span>
                    <span class="text">Menu</span>
                </label>

                <ul id="site-menu">
                    <x-link.nav name="home" label="Home" />

                    <x-link.nav name="about" label="About" />

                    <x-link.nav route="work.*" name="work.list" label="Work" />

                    <x-link.nav name="stories" label="Stories" />

                    <li>
                        <x-link.external
                            href="https://www.linkedin.com/in/michaelvcolianna/"
                            label="LinkedIn"
                        />
                    </li>
                </ul>
            </nav>
        </header>

        <article class="main">
            {{ $slot }}

            <footer>
                @if(isset($nav))
                    <nav class="post-nav">
                        {{ $nav }}
                    </nav>
                @endif

                <hr>

                <div class="copyright">
                    © 2022 Michael V. Colianna
                </div>
            </footer>
        </article>

        <div hidden>
            <span id="new-window-label">opens in a new window</span>
            <span id="external-site-label">opens an external site</span>
        </div>
    </body>
</html>

