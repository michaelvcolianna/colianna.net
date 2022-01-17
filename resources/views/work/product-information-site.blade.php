<x-layout title="Product Information Site" description="A multiple-page product information site Michael did.">
    <x-header>
        <x-slot name="heading">Product Information Site</x-slot>
        <x-slot name="subHeading">Work / 2019-10-05</x-slot>

        <x-figure
            width="1105"
            height="847"
            :src="asset('images/culturelle.jpg')"
            alt="Culturelle"
            sizes="(max-width: 1105px) 100vw, 1105px"
        >
            <x-slot name="srcset">
                {{ asset('images/culturelle.jpg') }} 1105w,
                {{ asset('images/culturelle-300x230.jpg') }} 300w,
                {{ asset('images/culturelle-768x589.jpg') }} 768w,
                {{ asset('images/culturelle-1024x785.jpg') }} 1024w
            </x-slot>

            <x-slot name="caption">
                Screenshot of a Culturelle product page (as viewed on a laptop
                or desktop device).
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        The client’s existing site was overhauled to update the design, utilize
        newer technologies, and make it easier to edit. They were also having
        issues with the forms and coupon implementations. They opted to embrace
        Drupal 8.
    </p>


    <x-figure
        width="1024"
        height="722"
        :src="asset('images/product-02-1024x722.jpg')"
        alt="Drupal content type"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/product-02-1024x722.jpg') }} 1024w,
            {{ asset('images/product-02-300x211.jpg') }} 300w,
            {{ asset('images/product-02-768x541.jpg') }} 768w,
            {{ asset('images/product-02.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            Many fields in a content type
        </x-slot>
    </x-figure>

    <p>
        I handled most of the backend code – modules to print static blocks,
        Twig templates that utilized the many custom fields in multiple content
        types, and structural elements for the views. I took the beautiful
        design and identified the reusable elements, then turned those into
        modular template files.
    </p>

    <x-figure
        width="965"
        height="1024"
        :src="asset('images/product-04-965x1024.jpg')"
        alt="Code snippet"
        sizes="(max-width: 965px) 100vw, 965px"
    >
        <x-slot name="srcset">
            {{ asset('images/product-04-965x1024.jpg') }} 965w,
            {{ asset('images/product-04-283x300.jpg') }} 283w,
            {{ asset('images/product-04-768x815.jpg') }} 768w,
            {{ asset('images/product-04.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            A theme file function for rendering blocks as template variables
        </x-slot>
    </x-figure>

    <p>
        The site’s speed is much better than the old, Drupal 7 version. They
        have gotten more interest in the coupons, the issues with the forms have
        dropped significantly, and it is a lot easier to use all around.
    </p>

    <x-slot name="nav">
        <x-nav.prev slug="paid-search-landing-page" label="Paid Search Landing Page" />
        <x-nav.next slug="old-author-site" label="Author Site (Older Version)" />
    </x-slot>
</x-layout>
