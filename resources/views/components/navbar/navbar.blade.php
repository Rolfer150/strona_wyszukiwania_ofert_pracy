<nav class="sticky top-0 bg-white dark:bg-gray-900 border-b border-gray-300 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        {{--    Lewa część navbaru    --}}
        <div class="p-4 flex justify-center items-center">
            {{--        Strona główna        --}}
            <div class="shrink-0">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-9 w-auto fill-current hover:text-gray-900 dark:text-gray-400
                    dark:hover:text-white"/>
                </a>
            </div>
            {{--        Tryb jasny/ciemny        --}}
            <div class="shrink-0">

{{--                <button x-data @click="$store.darkMode.toggle()">Ciemny: <strong x-data x-text="$store.darkMode.dark"></strong></button>--}}

                {{--        Ikona trybu ciemnego        --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="moon cursor-pointer w-6 h-6 ml-12 text-gray-700 hover:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118
                    15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635
                    7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                </svg>
                {{--        Ikona trybu jasnego        --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="sun cursor-pointer w-6 h-6 ml-12 dark:text-gray-400 dark:hover:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21
                    12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636
                    5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                </svg>
            </div>
        </div>
        {{--    Środkowa część navbaru    --}}
        <div class="p-4 flex justify-center items-center shrink-0">
            {{--      Strona z ofertami pracy      --}}
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link href="{{route('livewire.search')}}">
                    {{ __('Oferty Pracy') }}
                </x-nav-link>
            </div>
            {{--      Strona z listą firm i informacjami na ich temat      --}}
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link href="{{route('livewire.employer')}}">
                    {{ __('Firmy') }}
                </x-nav-link>
            </div>
            {{--      Strona z listą profili użytkownika i informacjami na ich temat      --}}
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link href="{{route('livewire.user')}}">
                    {{ __('Profile') }}
                </x-nav-link>
            </div>
            {{--      Strona z kalkulatorem obliczania wypłat brutto/netto      --}}
            {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link href="{{route('livewire.salary-calculator')}}">
                    {{ __('Kalkulator Wypłaty') }}
                </x-nav-link>
            </div> --}}

{{--            <div>--}}
{{--                @if(Auth::user()->image_path)--}}
{{--                    <img src="{{ asset(Auth::user()->image_path) }}" alt="">--}}
{{--                @else--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                    </svg>--}}
{{--                @endif--}}
{{--            </div>--}}

        </div>
        {{--    Prawa część navbaru    --}}
        <div class=" p-4">
            <div class="space-x-8 sm:-my-px sm:ml-10  text-right">
                @if (Route::has('login'))
                    @auth
                        <x-navbar.dropdown-nav/>
                    @else
                        <x-nav-link href="{{ route('login') }}">
                            {{ __('Zaloguj się') }}
                        </x-nav-link>
                        @if (Route::has('register'))
                            <x-nav-link href="{{ route('register') }}">
                                {{ __('Zarejestruj się') }}
                            </x-nav-link>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>
