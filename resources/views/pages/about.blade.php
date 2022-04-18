<x-layout title="About" description="An overview of who Michael is and what he does, both as an author and as a web developer.">
    <x-header>
        <x-slot name="heading">About</x-slot>
    </x-header>

    <h2>Web Development</h2>

    <p>
        A lot of Michael’s recent professional work has been done in Laravel,
        WordPress, and Contentful – from APIs to product information sites. All
        of his recent projects integrate some form of workflow to handle assets
        – usually Webpack to compile. Most is CI, currently deployed using
        BitBucket + Circle, with features/bugs/changes managed in JIRA.
    </p>

    <p>
        Michael’s constantly seeking new ways to do things, however, and he can
        generally pick up a technology within a few hours. As an example of
        that, Michael learned React (albeit via Gatsby), as well as how to
        implement Vue in a Nuxt project, then deployed those sites through
        Netlify — all in the space of a week.
    </p>

    <x-figure
        width="1024"
        height="681"
        :src="asset('images/michael-candid-1024x681.jpg')"
        alt="Michael at his desk, with his computer open in the background to some code and the corresponding web page."
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/michael-candid-1024x681.jpg') }} 1024w,
            {{ asset('images/michael-candid-300x200.jpg') }} 300w,
            {{ asset('images/michael-candid-768x511.jpg') }} 768w,
            {{ asset('images/michael-candid-690x459.jpg') }} 690w,
            {{ asset('images/michael-candid-800x532.jpg') }} 800w,
            {{ asset('images/michael-candid.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            A photograph of Michael at his desk, with his computer open in the
            background to some code and the corresponding web page.
        </x-slot>
    </x-figure>

    <p>
        Michael is very skilled at identifying reusable components in a design,
        then separating those into modules for ease of editing. That helps him
        to utilize standard coding principles for his work. He uses Git to
        manage revisions, and all development he does is fully documented – be
        it a simple HTML build, a blog, or forms that integrate with CR
        databases.
    </p>

    <p>
        The “work” page includes some screenshots of web sites and code samples.
    </p>

    <h2>Writing</h2>

    <p>
        The skeleton for Michael’s stories began forming as early as 14 years
        old. He wondered what the future held for humanity, and whether we would
        travel into space. Idolizing Ursula K. LeGuin, Isaac Asimov, and C.S.
        Friedman, he followed humanity into the future and a combination of
        science fiction/fantasy elements trickled into the resulting stories.
    </p>

    <x-figure
        width="1024"
        height="715"
        :src="asset('images/planets.jpg')"
        alt="Painting of a rocky planet, with a small space station on its surface and another planet visible in the sky. A small rocket launches into space."
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/planets.jpg') }} 1024w,
            {{ asset('images/planets-300x209.jpg') }} 300w,
            {{ asset('images/planets-768x536.jpg') }} 768w,
            {{ asset('images/planets-690x482.jpg') }} 690w,
            {{ asset('images/planets-800x559.jpg') }} 800w
        </x-slot>

        <x-slot name="caption">
            “Planets“ painting by Jonas Lesser (http://jonas.lesser.se/)
        </x-slot>
    </x-figure>

    <p>
        Outside of writing, Michael bicycles, runs, and lifts weights. He’s also
        been
        <x-link.external href="https://campaign.andrissar.org" label="running a Dungeons & Dragons campaign" />
        for over 20 years with his unruly and – let’s say imaginitive – friends.
        He and his wife have been on a curious journey sparked by infertility as
        they try to expand their family. As well, he recently received a
        diagnosis of inoperable otosclerosis. So now elements of those things
        are finding their ways into his stories, too.
    </p>

    <p>
        The “stories” page contains some details about what Michael’s been
        working on.
    </p>
</x-layout>
