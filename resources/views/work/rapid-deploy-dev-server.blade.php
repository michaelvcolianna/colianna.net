<x-layout title="Rapid-deploy AWS Dev Server" description="A Linux EC2 instance Michael turned into an AMI for developers.">
    <x-header>
        <x-slot name="heading">Rapid-deploy AWS Dev Server</x-slot>
        <x-slot name="subHeading">Work / 2019-10-05</x-slot>

        <x-figure
            width="1082"
            height="860"
            :src="asset('images/dev-box.jpg')"
            alt="Dev Box ssh"
            sizes="(max-width: 1082px) 100vw, 1082px"
        >
            <x-slot name="srcset">
                {{ asset('images/dev-box.jpg') }} 1082w,
                {{ asset('images/dev-box-300x238.jpg') }} 300w,
                {{ asset('images/dev-box-768x610.jpg') }} 768w,
                {{ asset('images/dev-box-1024x814.jpg') }} 1024w
            </x-slot>

            <x-slot name="caption">
                Screenshot of the login screen for the development server
            </x-slot>
        </x-figure>
    </x-header>

    <p>
        When my company migrated from the Cloud9 service we needed a way for our
        developers to work from anywhere. AWS still offers Cloud9 boxes but they
        weren’t as configurable as what we needed. I went through and set up an
        AMI to rapidly-deploy a development server and get someone going with
        our standards.
    </p>

    <x-figure
        width="1024"
        height="651"
        :src="asset('images/server-01-1024x651.jpg')"
        alt="AWS security group"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/server-01-1024x651.jpg') }} 1024w,
            {{ asset('images/server-01-300x191.jpg') }} 300w,
            {{ asset('images/server-01-768x489.jpg') }} 768w,
            {{ asset('images/server-01.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            Custom security group setting in AWS for the development AMIs
        </x-slot>
    </x-figure>

    <p>
        I created a special security group for the EC2 instances, along with a
        range of elastic IPs so that the development projects could be accessed
        easily via computer or device. I also created instructions for anyone to
        set up an instance and deploy it.
    </p>

    <x-figure
        width="938"
        height="570"
        :src="asset('images/server-02.jpg')"
        alt="Dynamic vhost config"
        sizes="(max-width: 938px) 100vw, 938px"
    >
        <x-slot name="srcset">
            {{ asset('images/server-02.jpg') }} 938w,
            {{ asset('images/server-02-300x182.jpg') }} 300w,
            {{ asset('images/server-02-768x467.jpg') }} 768w
        </x-slot>

        <x-slot name="caption">
            “Magic” lines in Apache config for the dynamically served web sites,
            using mod_vhost_alias
        </x-slot>
    </x-figure>

    <p>
        I leveraged Apache’s ‘mod_vhost_alias’ module to dynamically serve any
        sites within the specified folder so that getting up and running was
        near-instantaneous. I also created a web front-end that lists the sites
        for easier access.
    </p>

    <x-figure
        width="1024"
        height="909"
        :src="asset('images/server-03-1024x909.jpg')"
        alt="Web interface"
        sizes="(max-width: 1024px) 100vw, 1024px"
    >
        <x-slot name="srcset">
            {{ asset('images/server-03-1024x909.jpg') }} 1024w,
            {{ asset('images/server-03-300x266.jpg') }} 300w,
            {{ asset('images/server-03-768x682.jpg') }} 768w,
            {{ asset('images/server-03.jpg') }} 1105w
        </x-slot>

        <x-slot name="caption">
            A web interface for the dynamically served sites
        </x-slot>
    </x-figure>

    <p>
        This allows us to spin these up as single instances for heavy projects
        or to use them with the dynamic serving. We can access the development
        boxes from any location and pick up where we left off.
    </p>

    <x-slot name="nav">
        <x-nav.prev slug="old-author-site" label="Author Site (Older Version)" />
        <x-nav.next slug="multi-language-brochure" label="Multi-Language Brochure" />
    </x-slot>
</x-layout>
