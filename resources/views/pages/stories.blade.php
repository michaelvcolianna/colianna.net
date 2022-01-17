<x-layout title="Stories" description="">
    <x-header>
        <x-slot name="heading">Stories</x-slot>
    </x-header>

    <h2>What is the Guild Library?</h2>

    <p>
        The Guild Library is a magnificent database of humanity’s knowledge and
        history. It is managed by a universe-wide government called the Galactic
        Guild of Humanity from its headquarters on the planet of Ur-Magad. Any
        citizen of the Guild can easily learn about their past in the Library –
        from humanity’s unexpected need to leave Earth and colonize other
        planets, through the war-torn times before the Guild’s existence that
        nearly saw humanity enslaved, to the fragile peace that has persevered
        after its formation.
    </p>

    <p>
        Michael currently has two projects. They are part of the overall future
        history but are also their own distinct stories.
    </p>

    <x-figure
        width="1024"
        height="573"
        :src="asset('images/spaceship-1024x573.jpg')"
        alt="Spaceship interior."
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/spaceship.jpg') }} 1024w,
            {{ asset('images/spaceship-300x168.jpg') }} 300w,
            {{ asset('images/spaceship-768x430.jpg') }} 768w,
            {{ asset('images/spaceship-600x336.jpg') }} 600w
        </x-slot>

        <x-slot name="caption">
            CGI interior of a spaceship. (Image from
            https://www.artstation.com/artwork/m-deck.)
        </x-slot>
    </x-figure>

    <h2>Fractured Children of Earth</h2>

    <p>
        A deeply personal story stemming from things that have happened in real
        life for Michael and his wife. Co-captains of a smuggling group in
        humanity’s distant future uncover a plot to control humanity. Taking
        action to stop it endangers their livelihoods, but doing nothing
        jeopardizes their dreams of retiring and starting a family.
        (Completed &amp; querying, but he would never turn down a reader!)
    </p>

    <hr>

    <h2>The Kinetic Conspiracy</h2>

    <p>
        She stole to survive, but now sells paintings. He’s a shy city guard,
        hoping to fit in. An army threatens the land, enhanced by planetary
        energy. Both are unaware they can help defeat the army – until they
        learn of their connections to it. (This story was completed but he is
        re-writing to better reflect his life.)
    </p>
</x-layout>
