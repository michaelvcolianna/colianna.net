<x-layout>
    <p>
        Michael (he/him) is a hard-of-hearing/deaf author &amp; web developer.
        He has worked professionally for over a decade, and on side projects for
        over 20 years in various PHP and front-end frameworks. He’s currently
        employed full time at
        <x-link.external href="https://cronin-co.com" label="Cronin" />.
    </p>

    <p>
        Michael writes a mix of fantasy and science-fiction set in the distant
        future. His stories in either genre are grounded, focusing on the
        character relationships and societal changes instead of magical
        creatures or space battles. A current of mystery runs under them all, as
        well.
    </p>

    <x-figure
        width="640"
        height="547"
        :src="asset('images/mvc-teal.jpg')"
        alt="A 3/4 photograph of Michael. He has a full but maintained beard with bits of grey, and short hair dyed teal."
        sizes="(max-width: 640px) 100vw, 640px"
    >
        <x-slot name="srcset">
            {{ asset('images/mvc-teal.jpg') }} 640w,
            {{ asset('images/mvc-teal-300x256.jpg') }} 300w
        </x-slot>

        <x-slot name="caption">
            A 3/4 photograph of Michael, showing the taper of his beard and the
            shaved portion on the right of his head, as well as a peek of his
            teal hair. On the wall behind him are two paintings of an artichoke
            and a cucumber, labeled, “Okie Dokie, Artichokie!” and “I am kind of
            a big dill,” respectively.
        </x-slot>
    </x-figure>

    <p>
        For more information about Michael, check out the “about” page. The
        “stories” page gives a little bit of detail about his writing, and the
        “work” page contains some samples of recent projects he’s completed.
    </p>
</x-layout>
