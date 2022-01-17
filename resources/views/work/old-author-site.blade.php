<x-layout title="Author Site (Older Version)" description="Michael's old version of his author site, from when they were separate domains.">
    <x-header>
        <x-slot name="heading">Author Site (Older Version)</x-slot>
        <x-slot name="subHeading">Work / 2019-10-05</x-slot>

        <x-figure
            width="1105"
            height="880"
            :src="asset('images/guild-library.jpg')"
            alt="Guild Library"
            sizes="(max-width: 1105px) 100vw, 1105px"
        >
            <x-slot name="srcset">
                {{ asset('images/guild-library.jpg') }} 1105w,
                {{ asset('images/guild-library-300x239.jpg') }} 300w,
                {{ asset('images/guild-library-768x612.jpg') }} 768w,
                {{ asset('images/guild-library-1024x815.jpg') }} 1024w
            </x-slot>

            <x-slot name="caption">
                A screenshot of the Guild Library site (as viewed on a laptop or
                desktop device)
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        (Older design shown for custom code purposes.) I wanted to update my
        site to showcase the work for my writing hobby. I wanted a design that
        was incredibly flexible and would work across multiple devices with
        little tweaking. I needed to account for older links and provide
        appropriate data for sharing, SEO, and structured data.
    </p>

    <x-figure
        width="1024"
        height="987"
        :src="asset('images/personal-03-1024x987.jpg')"
        alt="Javascript code snippet"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/personal-03-1024x987.jpg') }} 1024w,
            {{ asset('images/personal-03-300x289.jpg') }} 300w,
            {{ asset('images/personal-03-768x740.jpg') }} 768w,
            {{ asset('images/personal-03.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            Custom JS for the site using jQuery.
        </x-slot>
    </x-figure>

    <p>
        As I am not a designer, I located a theme I liked and applied changes to
        it that suited the style of my work.
    </p>

    <p>
        I created a custom “framework” to handle routing. I utilized YAML to
        make both the valid paths and redirects. I made several classes for
        \handling the variables, the Twig template engine, and development mode.
    </p>

    <x-figure
        width="1024"
        height="474"
        :src="asset('images/personal-02-1024x474.jpg')"
        alt="PHP code snippet"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/personal-02-1024x474.jpg') }} 1024w,
            {{ asset('images/personal-02-300x139.jpg') }} 300w,
            {{ asset('images/personal-02-768x355.jpg') }} 768w,
            {{ asset('images/personal-02.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            Private method for domain details
        </x-slot>
    </x-figure>

    <p>
        The result is a much easier to manage web site that looks better and
        will help to increase the web presence for my hobby as I ramp up
        campaigns and social media usage.
    </p>

    <x-slot name="nav">
        <x-nav.prev slug="product-information-site" label="Product Information Site" />
        <x-nav.next slug="rapid-deploy-dev-server" label="Rapid-deploy AWS Dev Server" />
    </x-slot>
</x-layout>
