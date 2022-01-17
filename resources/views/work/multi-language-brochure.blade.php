<x-layout title="Multi-Language Brochure" description="A brochure-style site with a few pages and built-in translations.">
    <x-header>
        <x-slot name="heading">Multi-Language Brochure</x-slot>
        <x-slot name="subHeading">Work / 2020-01-20</x-slot>

        <x-figure
            width="1860"
            height="1205"
            :src="asset('images/tu-amica-desktop-main-scaled.jpg')"
            alt="Tu Amica front page"
            sizes="(max-width: 1860px) 100vw, 1860px"
        >
            <x-slot name="srcset">
                {{ asset('images/tu-amica-desktop-main-scaled.jpg') }} 2560w,
                {{ asset('images/tu-amica-desktop-main-300x194.jpg') }} 300w,
                {{ asset('images/tu-amica-desktop-main-1024x664.jpg') }} 1024w,
                {{ asset('images/tu-amica-desktop-main-768x498.jpg') }} 768w,
                {{ asset('images/tu-amica-desktop-main-1536x995.jpg') }} 1536w,
                {{ asset('images/tu-amica-desktop-main-2048x1327.jpg') }} 2048w,
                {{ asset('images/tu-amica-desktop-main-1200x778.jpg') }} 1200w,
                {{ asset('images/tu-amica-desktop-main-1860x1205.jpg') }} 1860w
            </x-slot>

            <x-slot name="caption">
                Screenshot of the TuAmica page (as viewed from a laptop or
                desktop device)
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        The client has a web site tailored to an audience seeking information in
        both Spanish and English. Their main goal is a phone call or online form
        submission. With the prior implementation of the site, updates were
        difficult to make to both the content and style.
    </p>

    <ul id="image-gallery">
        <li class="blocks-gallery-item">
            <x-figure
                width="515"
                height="1024"
                :src="asset('images/tu-amica-mobile-main-515x1024.jpg')"
                alt="Mobile Tu Amica top"
                sizes="(max-width: 515px) 100vw, 515px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-mobile-main-515x1024.jpg') }} 515w,
                    {{ asset('images/tu-amica-mobile-main-151x300.jpg') }} 151w,
                    {{ asset('images/tu-amica-mobile-main-768x1526.jpg') }} 768w,
                    {{ asset('images/tu-amica-mobile-main-773x1536.jpg') }} 773w,
                    {{ asset('images/tu-amica-mobile-main.jpg') }} 954w
                </x-slot>

                <x-slot name="caption">
                    A site page displayed on an iPhone
                </x-slot>
            </x-figure>
        </li>

        <li class="blocks-gallery-item">
            <x-figure
                width="513"
                height="1024"
                :src="asset('images/tu-amica-mobile-menu-513x1024.jpg')"
                alt="Mobile Tu Amica menu"
                sizes="(max-width: 513px) 100vw, 513px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-mobile-menu-513x1024.jpg') }} 513w,
                    {{ asset('images/tu-amica-mobile-menu-150x300.jpg') }} 150w,
                    {{ asset('images/tu-amica-mobile-menu-768x1534.jpg') }} 768w,
                    {{ asset('images/tu-amica-mobile-menu-769x1536.jpg') }} 769w,
                    {{ asset('images/tu-amica-mobile-menu.jpg') }} 947w
                </x-slot>

                <x-slot name="caption">
                    The navigation menu activated on an iPhone
                </x-slot>
            </x-figure>
        </li>

        <li class="blocks-gallery-item">
            <x-figure
                width="373"
                height="1024"
                :src="asset('images/tu-amica-admin-373x1024.jpg')"
                alt="Tu Amica Admin Menu"
                sizes="(max-width: 373px) 100vw, 373px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-admin-373x1024.jpg') }} 373w,
                    {{ asset('images/tu-amica-admin-109x300.jpg') }} 109w,
                    {{ asset('images/tu-amica-admin.jpg') }} 544w
                </x-slot>

                <x-slot name="caption">
                    The backend admin menu displaying the areas to edit
                </x-slot>
            </x-figure>
        </li>

        <li class="blocks-gallery-item">
            <x-figure
                width="869"
                height="1024"
                :src="asset('images/tu-amica-invoke-controller-869x1024.jpg')"
                alt="Invokable controller"
                sizes="(max-width: 869px) 100vw, 869px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-invoke-controller-869x1024.jpg') }} 869w,
                    {{ asset('images/tu-amica-invoke-controller-255x300.jpg') }} 255w,
                    {{ asset('images/tu-amica-invoke-controller-768x905.jpg') }} 768w,
                    {{ asset('images/tu-amica-invoke-controller.jpg') }} 1134w
                </x-slot>

                <x-slot name="caption">
                    PHP code for the controller that handles serving the pages
                </x-slot>
            </x-figure>
        </li>

        <li class="blocks-gallery-item">
            <x-figure
                width="860"
                height="1024"
                :src="asset('images/tu-amica-js-form-submit-860x1024.jpg')"
                alt="JS form submission"
                sizes="(max-width: 860px) 100vw, 860px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-js-form-submit-860x1024.jpg') }} 860w,
                    {{ asset('images/tu-amica-js-form-submit-252x300.jpg') }} 252w,
                    {{ asset('images/tu-amica-js-form-submit-768x914.jpg') }} 768w,
                    {{ asset('images/tu-amica-js-form-submit.jpg') }} 1178w
                </x-slot>

                <x-slot name="caption">
                    Form submission JavaScript code
                </x-slot>
            </x-figure>
        </li>

        <li class="blocks-gallery-item">
            <x-figure
                width="1024"
                height="883"
                :src="asset('images/tu-amica-desktop-content-1024x883.jpg')"
                alt="Tu Amica content"
                sizes="(max-width: 1024px) 100vw, 1024px"
            >
                <x-slot name="srcset">
                    {{ asset('images/tu-amica-desktop-content-1024x883.jpg') }} 1024w,
                    {{ asset('images/tu-amica-desktop-content-300x259.jpg') }} 300w,
                    {{ asset('images/tu-amica-desktop-content-768x662.jpg') }} 768w,
                    {{ asset('images/tu-amica-desktop-content-1536x1324.jpg') }} 1536w,
                    {{ asset('images/tu-amica-desktop-content-2048x1765.jpg') }} 2048w,
                    {{ asset('images/tu-amica-desktop-content-1200x1034.jpg') }} 1200w,
                    {{ asset('images/tu-amica-desktop-content-1860x1603.jpg') }} 1860w
                </x-slot>

                <x-slot name="caption">
                    Content on the site, with a dropdown button activated
                </x-slot>
            </x-figure>
        </li>
    </ul>

    <p>
        The client provided a design. I built the entire site myself in Laravel,
        from the HTML views, to the backend controllers, to the frontend styles
        &amp; scripts. At the beginning of the project, I opted to utilize the
        Voyager package. This made it easier to edit the translatable content
        from a web-based interface – the alternatives would have been utilizing
        Laravel’s language files (not optimal for small tweaks the client
        sometimes needs for blocks of text) or a view/partial for each
        language.
    </p>

    <x-slot name="nav">
        <x-nav.prev slug="rapid-deploy-dev-server" label="Rapid-deploy AWS Dev Server" />
        <x-nav.next slug="optimized-paid-search-landing-page" label="Optimized Paid Search Landing Page" />
    </x-slot>
</x-layout>
