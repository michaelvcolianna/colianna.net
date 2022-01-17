<x-layout title="Work" description="A list of work Michael has done recently.">
    <x-header>
        <x-slot name="heading">Work</x-slot>
        <x-slot name="subHeading">
            Examples of some recent projects I’ve done, usually with code
            snippets and screenshots.
        </x-slot>
    </x-header>

    <ul>
        <x-link.work
            slug="optimized-paid-search-landing-page"
            label="Optimized Paid Search Landing Page"
            date="2021-01-20"
        />

        <x-link.work
            slug="multi-language-brochure"
            label="Multi-Language Brochure"
            date="2020-01-20"
        />

        <x-link.work
            slug="rapid-deploy-dev-server"
            label="Rapid-deploy AWS Dev Server"
            date="2019-10-05"
        />

        <x-link.work
            slug="old-author-site"
            label="Author Site (Older Version)"
            date="2019-10-05"
        />

        <x-link.work
            slug="product-information-site"
            label="Product Information Site"
            date="2019-10-05"
        />

        <x-link.work
            slug="paid-search-landing-page"
            label="Paid Search Landing Page"
            date="2019-10-05"
        />
    </ul>
</x-layout>
