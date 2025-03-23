<x-app-layout>
    <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        {{--        <div>--}}
        {{--            <a href="/">--}}
        {{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
        {{--            </a>--}}
        {{--        </div>--}}

        <div class="min-h-3/4 w-full sm:max-w-md m-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
