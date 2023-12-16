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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.13/css/froala_editor.pkgd.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-dialog z-index="z-50" blur="md" align="center" />
    <x-notifications position="top-center" />
    <div class="min-h-screen flex flex-col h-screen">

        <!-- main container -->
        <div class="flex-1 flex flex-row overflow-y-hidden">

            <main class="flex-1  overflow-y-auto bg-gray-100 " id="elementtoScrollToID">
                <header class="bg-transparent  z-10 p-2">

                </header>
                <div class="">
                    {{ $slot }}
                </div>


            </main>

            <nav class="order-first sm:w-56 bg-white relative">
                <div class="absolute top-0 w-full bg-white p-2 border-b">
                    <div class=" flex items-center gap-2">
                        <a href="{{ route('dashboard') }}" wire:navigate>
                            <x-application-logo imgclass="h-7 w-7" class="block h-6 w-6 fill-current text-gray-800" />
                        </a>
                        <div class="font-black">
                            {{ config('app.name') }} {{ config('app.version') }}
                        </div>
                    </div>
                </div>
                <div class="overflow-y-auto h-screen py-12 px-2 soft-scrollbar ">
                    <div class="space-y-2">

                        <div
                            class="px-5 py-2  {{ request()->path() === 'dashboard' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}    cursor-pointer   rounded-lg ">
                            <a href="{{ route('dashboard') }}" wire:navigate>
                                <div class="flex items-center gap-2">
                                    <x-icon name="home" class="w-5 h-5" />
                                    <div class="flex-1">
                                        Dashboard
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div
                        class="px-5 py-2  {{ request()->path() === 'master' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}   cursor-pointer   rounded-lg ">
                        <a href="{{ route('master') }}" wire:navigate>
                            <div class="flex items-center gap-2">
                                <x-icon name="cube" class="w-5 h-5" />
                                <div class="flex-1">
                                    Master Data
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- <div class="px-5 py-2   cursor-pointer   rounded-lg ">
                            <a href="{{ route('document') }}">
                                <div class="flex items-center gap-2">
                                    <x-icon name="newspaper" class="w-5 h-5" />
                                    <div class="flex-1">
                                        Berita
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    <div
                        class="px-5 py-2 {{ request()->path() === 'document' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}   cursor-pointer   rounded-lg ">
                        <a href="{{ route('document') }}" wire:navigate>
                            <div class="flex items-center gap-2">
                                <x-icon name="document-duplicate" class="w-5 h-5" />
                                <div class="flex-1">
                                    Dokumen
                                </div>
                            </div>
                        </a>
                    </div>
                    <div
                        class="px-5 py-2 {{ request()->path() === 'laporan' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}   cursor-pointer   rounded-lg ">
                        <a href="{{ route('laporan') }}" wire:navigate>
                            <div class="flex items-center gap-2">
                                <x-icon name="presentation-chart-bar" class="w-5 h-5" />
                                <div class="flex-1">
                                    Laporan
                                </div>
                            </div>
                        </a>
                    </div>

                    <div
                        class="px-5 py-2 {{ request()->path() === 'pengguna' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}   cursor-pointer   rounded-lg ">
                        <a href="{{ route('pengguna') }}" wire:navigate>
                            <div class="flex items-center gap-2">
                                <x-icon name="users" class="w-5 h-5" />
                                <div class="flex-1">
                                    Pengguna
                                </div>
                            </div>
                        </a>
                    </div>

                    <div
                        class="px-5 py-2 {{ request()->path() === 'settings' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-900 hover:text-emerald-800 hover:underline' }}   cursor-pointer   rounded-lg ">
                        <a href="{{ route('settings') }}" wire:navigate>
                            <div class="flex items-center gap-2">
                                <x-icon name="cog" class="w-5 h-5" />
                                <div class="flex-1">
                                    Pengaturan
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-5 py-2   cursor-pointer   rounded-lg ">
                        <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="flex items-center gap-2">
                                <x-icon name="logout" class="w-5 h-5" />
                                <div class="flex-1">
                                    Logout / Keluar
                                </div>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div class="absolute bottom-0 w-full bg-white p-2 border-t">

                    <livewire:components.navigation />
                </div>

            </nav>


            @if (isset($rside))
                <aside class="sm:w-96 bg-yellow-100 overflow-y-auto">{{ $rside }}</aside>
            @endif
        </div>
        <!-- end main container -->


    </div>

    {{-- <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

        </div> --}}



    @stack('scripts')

    @livewireChartsScripts

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('downloadZip', ({
                url,
                redirectPath = null
            }) => {

                window.open(url, "_self");
                if (redirectPath) {
                    setTimeout(function() {
                        window.location.href = redirectPath;
                    }, 1000);
                }

            });

        });
    </script>



</body>

</html>
