<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:border-gray-500 dark:bg-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="#">
                        <a href="#" class="flex items-center">
                            <div class="w-12 h-12 overflow-hidden rounded-full sm:w-12 sm:h-12">
                                <img src="https://cdn-1.webcatalog.io/catalog/d-id/d-id-icon-filled-256.png?v=1676420127863"
                                    alt="ReadConnect Logo" class="object-cover w-full h-full" />
                            </div>
                            <span class="self-center ml-2 text-xl font-semibold dark:text-white">D-ID-SOFTWARE</span>
                        </a>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('images.index') }}" :active="request()->routeIs('images.index')">
                        Imagenes
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('talks.index') }}" :active="request()->routeIs('talks.index')">
                        Videos
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('audios.index') }}" :active="request()->routeIs('audios.index')">
                        Audios
                    </x-nav-link>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                Home
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            {{-- <x-responsive-nav-link href="{{ route('books.index') }}" :active="request()->routeIs('books.index')"> --}}
            <x-responsive-nav-link href="{{ route('images.index') }}" :active="request()->routeIs('images.index')">
                Imagenes
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            {{-- <x-responsive-nav-link href="{{ route('books.index') }}" :active="request()->routeIs('books.index')"> --}}
            <x-responsive-nav-link href="{{ route('talks.index') }}" :active="request()->routeIs('talks.index')">
                Videos
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('audios.index') }}" :active="request()->routeIs('audios.index')">
                Audios
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
