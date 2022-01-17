<x-layout title="Optimized Paid Search Landing Page" description="A brochure-style site Michael did, which focuses on delivery.">
    <x-header>
        <x-slot name="heading">Optimized Paid Search Landing Page</x-slot>
        <x-slot name="subHeading">Work / 2021-01-20</x-slot>

        <x-figure
            width="1860"
            height="1009"
            :src="asset('images/optimized-paid-search-mantel-min-1860x1009.jpg')"
            alt="Optimized paid search site mantel"
            sizes="(max-width: 1860px) 100vw, 1860px"
        >
            <x-slot name="srcset">
                {{ asset('images/optimized-paid-search-mantel-min-1860x1009.jpg') }} 1860w,
                {{ asset('images/optimized-paid-search-mantel-min-300x163.jpg') }} 300w,
                {{ asset('images/optimized-paid-search-mantel-min-1024x555.jpg') }} 1024w,
                {{ asset('images/optimized-paid-search-mantel-min-768x417.jpg') }} 768w,
                {{ asset('images/optimized-paid-search-mantel-min-1536x833.jpg') }} 1536w,
                {{ asset('images/optimized-paid-search-mantel-min-2048x1111.jpg') }} 2048w,
                {{ asset('images/optimized-paid-search-mantel-min-1200x651.jpg') }} 1200w
            </x-slot>

            <x-slot name="caption">
                Screenshot of the Amica IRA site (as viewed from a laptop or
                desktop device)
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        Much like the Paid Search Landing Page, the client wanted to apply a
        refreshed look to a different set of products. They also wanted these
        landing pages to be optimized for better paid search rankings.
    </p>

    <x-figure
        width="877"
        height="778"
        :src="asset('images/optimized-paid-search-01-min.jpg')"
        alt="Lighthouse performance report"
        sizes="(max-width: 877px) 100vw, 877px"
    >
        <x-slot name="srcset">
            {{ asset('images/optimized-paid-search-01-min.jpg') }} 877w,
            {{ asset('images/optimized-paid-search-01-min-300x266.jpg') }} 300w,
            {{ asset('images/optimized-paid-search-01-min-768x681.jpg') }} 768w
        </x-slot>

        <x-slot name="caption">
            Screenshot of the web site’s Lighthouse scores for mobile: 100 performance, 100 accessibility, 93 best practices (thanks to a cross-site link), and 100 SEO
        </x-slot>
    </x-figure>

    <p>
        This project did not require a lot of JavaScript, as it was created in
        Laravel 8 using Jetstream &amp; Livewire. Components native to that
        implementation allowed for an easy form submission and freed up time to
        work on custom routing and styles.
    </p>

    <x-figure
        width="969"
        height="1024"
        :src="asset('images/optimized-paid-search-02-min-969x1024.jpg')"
        alt="Custom routing image"
        sizes="(max-width: 969px) 100vw, 969px"
    >
        <x-slot name="srcset">
            {{ asset('images/optimized-paid-search-02-min-969x1024.jpg') }} 969w,
            {{ asset('images/optimized-paid-search-02-min-284x300.jpg') }} 284w,
            {{ asset('images/optimized-paid-search-02-min-768x812.jpg') }} 768w,
            {{ asset('images/optimized-paid-search-02-min-1200x1268.jpg') }} 1200w,
            {{ asset('images/optimized-paid-search-02-min.jpg') }} 1304w
        </x-slot>

        <x-slot name="caption">
            Screenshot of code in the routes/web.php file from the Laravel install, with some custom routing functions and a fallback for the contact form submission
        </x-slot>
    </x-figure>

    <p>
        One of the most custom portions is the controller, which implements a
        model that utilizes accessors and mutators for actual and computed
        properties so that values can be easily retrieved and set.
    </p>

    <x-figure
        width="1024"
        height="926"
        :src="asset('images/optimized-paid-search-03-min-1024x926.jpg')"
        alt="Controller instance for one site"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/optimized-paid-search-03-min-1024x926.jpg') }} 1024w,
            {{ asset('images/optimized-paid-search-03-min-300x271.jpg') }} 300w,
            {{ asset('images/optimized-paid-search-03-min-768x695.jpg') }} 768w,
            {{ asset('images/optimized-paid-search-03-min.jpg') }} 1176w
        </x-slot>

        <x-slot name="caption">
            Screenshot of controller code, showcasing an srcset and a custom accessor/mutator for a model property
        </x-slot>
    </x-figure>

    <p>
        The styling leverages SASS compilation with Laravel Mix. And the styling
        was achieved with mixins so that future sites added to the project will
        have a baseline to work from.
    </p>

    <x-figure
        width="709"
        height="1024"
        :src="asset('images/optimized-paid-search-04-min-709x1024.jpg')"
        alt="SASS mixins for a button and screen reader text"
        sizes="(max-width: 709px) 100vw, 709px"
    >
        <x-slot name="srcset">
            {{ asset('images/optimized-paid-search-04-min-709x1024.jpg') }} 709w,
            {{ asset('images/optimized-paid-search-04-min-208x300.jpg') }} 208w,
            {{ asset('images/optimized-paid-search-04-min-768x1109.jpg') }} 768w,
            {{ asset('images/optimized-paid-search-04-min.jpg') }} 942w
        </x-slot>

        <x-slot name="caption">
            Screenshot of code for SASS (really SCSS) mixins defining a standard button and screen reader text styles
        </x-slot>
    </x-figure>

    <p>
        Since the goal of the site is to get the customer to call, the “mobile”
        version of the web site prominently features the call button without
        sacrificing the hero image or call-to-action copy.
    </p>

    <x-figure
        width="579"
        height="1024"
        :src="asset('images/optimized-paid-search-05-min-579x1024.jpg')"
        alt="Small device view"
        sizes="(max-width: 579px) 100vw, 579px"
    >
        <x-slot name="srcset">
            {{ asset('images/optimized-paid-search-05-min-579x1024.jpg') }} 579w,
            {{ asset('images/optimized-paid-search-05-min-170x300.jpg') }} 170w,
            {{ asset('images/optimized-paid-search-05-min-768x1358.jpg') }} 768w,
            {{ asset('images/optimized-paid-search-05-min.jpg') }} 828w
        </x-slot>

        <x-slot name="caption">
            Screenshot of the web site from a mobile device, showing that the call button is prominent
        </x-slot>
    </x-figure>

    <x-slot name="nav">
        <x-nav.prev slug="multi-language-brochure" label="Multi-Language Brochure" />
        <x-nav.none direction="next" />
    </x-slot>
</x-layout>
