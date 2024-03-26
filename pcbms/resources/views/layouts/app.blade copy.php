<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
        <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/js/app.js'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

    </head>
    <body class="font-sans antialiased">
        @stack('modals')
        @livewire('livewire-ui-modal')
        @livewireScripts
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @if (request()->routeIs('pos'))
             <!-- Page Content -->
             {{-- <main>
                {{ $slot }}
            </main> --}}
            @livewire('pos-page')
            @else
                @livewire('navigation-menu')

                <div class="relative">
                    <div class="flex">
                        <div class="w-full m-0 p-0">
                            <div>
                                @include('layouts.sidebar', ['isOpen' => 'isOpen'])
                            </div>
                            <!-- Page Content -->
                            <div class="min-h-screen min-w-screen bg-gray-100 overflow-y-auto" x-bind:class="{ 'ml-60': isOpen }">
                                <!-- Page Heading -->
                                @if (isset($header))
                                <header class="w-100 bg-white shadow">
                                    <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                        {{ $header }}
                                    </div>
                                </header>
                                @endif

                                <main>
                                    {{ $slot }}
                                </main>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


    </body>
</html>
