<x-app-layout>
    <div class="md:flex gap-x-6 p-3">
        {{-- Lewa strona --}}
        <div class="ml-24 border-[1px] border-gray-300 dark:border-0 dark:bg-gray-800/50 p-6 w-1/3 rounded-lg justify-center">
            {{-- Lewy panel górny --}}
            <div class="">
                <div class="justify-center items-center">
                    <div class="flex justify-center">
                        <img alt="profile-image" class="w-36 h-36 rounded-full object-cover" src="{{ $user->getURLImage() }}" />
                    </div>

                    <div class="pl-4">
                        <div class="mt-4">
                            <h1 class="text-3xl text-gray-600 dark:text-gray-400 text-center font-bold">{{ $user->name }} {{ $user->surname }}</h1>
                        </div>
                        <div class="flex justify-center mt-4">
                            <a href="{{route('profile.edit')}}" class="text-xl text-white bg-orange hover:bg-orange-500 p-4 rounded-2xl hover:bg-gray-800
                            transition-colors transition-colors content-center">
                                ZMIEŃ SZCZEGÓŁY KONTA
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lewy dolny panel --}}
            <div class="mt-8">
                <div>
                    <div class="mt-4 mb-4">
                        <h1 class="text-2xl font-bold text-center">Informacje podstawowe</h1>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="mt-4">
                                <h1>Wiek:</h1>
                                <p>{{ $user->getAge() }}</p>
                            </div>
                            <div class="mt-4">
                                <h1>Lokacja:</h1>
                                @if($user->address)
                                <p>{{ $user->address['city'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="mt-4">
                                <h1>Adres email:</h1>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="mt-4">
                                <h1>Numer telefonu:</h1>
                                <p>{{ $user->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Prawa strona --}}
        <div class="mr-24 border-[1px] border-gray-300 dark:border-0 dark:bg-gray-800/50 p-6 rounded-lg w-2/3">
            {{-- Prawy panel --}}
            <div>
                <div>
                    <div>
                        <h1 class="text-2xl">Edukacja</h1>
                        <div class="flex">
                            <p class="mr-4">{{ $user->education }}</p>
                            <p>{{ $user->school }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h1 class="text-2xl">Branże pracy</h1>
                        <div class="flex">
                            @foreach($user->categories as $category)
                                <p class="mr-4">{{ $category->name }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8">
                        <h1 class="text-2xl">Umiejętności</h1>
                        <div class="flex">
                            @foreach($user->skills as $skill)
                                <p class="mr-4">{{$skill->name}}: {{$skill->skill_level}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h1 class="text-2xl">O mnie</h1>
                    <div class="mt-4">
                       <p>{{ $user->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        </div>

{{--    @if($category_offers)--}}
{{--        <div class="gap-x-6 pl-3 pr-3 pb-3">--}}
{{--            <div class="p-6 bg-gray-200/50 dark:bg-gray-800/50 rounded-lg border-[1px] border-gray-300 dark:border-0">--}}
{{--                <h1>Polecane oferty o tej samej kategorii</h1>--}}
{{--                <div class="grid xl:col-span-4 lg:grid-cols-3 md:grid-cols-2 sm:col-span-1">--}}
{{--                    @foreach($category_offers as $offer_cat)--}}
{{--                        <x-offer-item :offer="$offer_cat"></x-offer-item>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
</x-app-layout>

