<x-layout title="Paid Search Landing Page" description="A brochure-style site Michael did.">
    <x-header>
        <x-slot name="heading">Paid Search Landing Page</x-slot>
        <x-slot name="subHeading">Work / 2019-10-05</x-slot>

        <x-figure
            width="1105"
            height="671"
            :src="asset('images/amica-auto.jpg')"
            alt="Amica Auto"
            sizes="(max-width: 1105px) 100vw, 1105px"
        >
            <x-slot name="srcset">
                {{ asset('images/amica-auto.jpg') }} 1105w,
                {{ asset('images/amica-auto-300x182.jpg') }} 300w,
                {{ asset('images/amica-auto-768x466.jpg') }} 768w,
                {{ asset('images/amica-auto-1024x622.jpg') }} 1024w
            </x-slot>

            <x-slot name="caption">
                Screenshot of the Amica Auto website (as viewed on a laptop or
                desktop device).
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        The client has several web sites using complex logic to display
        information to visitors. Their main goal is a phone call or an online
        form submission. Some visitors may need to be shown localized
        information, as well. Changes were incredibly difficult to make on the
        previous version, and small changes often had huge repercussions.
    </p>

    <x-figure
        width="1024"
        height="1019"
        :src="asset('images/paid-search-04-1024x1019.jpg')"
        alt="Code snippet"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/paid-search-04-1024x1019.jpg') }} 1024w,
            {{ asset('images/paid-search-04-150x150.jpg') }} 150w,
            {{ asset('images/paid-search-04-300x300.jpg') }} 300w,
            {{ asset('images/paid-search-04-768x764.jpg') }} 768w,
            {{ asset('images/paid-search-04-1200x1194.jpg') }} 1200w,
            {{ asset('images/paid-search-04.jpg') }} 1238w
        </x-slot>

        <x-slot name="caption">
            Main controller, providing variables to the templates
        </x-slot>
    </x-figure>



        <p>I took the functional HTML build and design as a base and used it to create reusable elements, keeping future site conversions in mind. There are now default values which are overridden by definitions in a single YAML file. This provides expandability and ease of editing since data can be added/removed as needed, and template files only need to be created to override the defaults.</p>



    <x-figure
        width="484"
        height="1024"
        :src="asset('images/paid-search-01-484x1024.jpg')"
        alt="Folder structure"
        sizes="(max-width: 484px) 100vw, 484px"
    >
        <x-slot name="srcset">
            {{ asset('images/paid-search-01-484x1024.jpg') }} 484w,
            {{ asset('images/paid-search-01-142x300.jpg') }} 142w,
            {{ asset('images/paid-search-01.jpg') }} 670w
        </x-slot>

        <x-slot name="caption">
            Simple structure for all of the reusable and overridable elements
        </x-slot>
    </x-figure>



        <p>This project sparked great enthusiasm from the client due to the easier presentation of important information and little need for maintenance.</p>


    <x-figure
        width="649"
        height="1024"
        :src="asset('images/paid-search-02-649x1024.jpg')"
        alt="YAML snippet"
        sizes="(max-width: 649px) 100vw, 649px"
    >
        <x-slot name="srcset">
            {{ asset('images/paid-search-02-649x1024.jpg') }} 649w,
            {{ asset('images/paid-search-02-190x300.jpg') }} 190w,
            {{ asset('images/paid-search-02-768x1211.jpg') }} 768w,
            {{ asset('images/paid-search-02.jpg') }} 894w
        </x-slot>

        <x-slot name="caption">
            Definitions of states, and which ones have overrides
        </x-slot>
    </x-figure>

    <x-slot name="nav">
        <x-nav.none direction="prev" />
        <x-nav.next slug="product-information-site" label="Product Information Site" />
    </x-slot>
</x-layout>
