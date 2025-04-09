<x-app-layout>
    {{-- @if($messagesCategoryComparison || $messagesSkillComparison)
        <div class="flex justify-end bg-orange-600 mx-32 mt-10 p-4 rounded-lg">
            <div>
                @foreach($messagesSkillComparison as $key => $value)
                    <h1 class="text-white">{{$value}}</h1>
                @endforeach
                @foreach($messagesCategoryComparison as $key => $value)
                <div class="flex flex-col md:flex-row justify-between">
                    <h1 class="text-white md:w-3/4 text-center md:text-left">{{$value}}</h1> --}}
                    {{-- Przycisk "Zmień" --}}
                    {{-- <div class="flex items-center justify-center mt-6 md:mt-0">
                        <a href="{{ route('profile.edit') }}" class="bg-white text-orange hover:text-orange-300 py-2 px-4 rounded-lg">Zmień</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif --}}
    <div class="md:flex gap-x-6 mt-3">
        {{-- Lewy panel --}}
        <div class="ml-32 border-[1px] border-gray-300 dark:border-0 dark:bg-gray-800/50 p-6 w-3/4 rounded-lg">
            <div class="flex">
                {{-- <img alt="{{$offer->slug}}" class="w-36 h-36 rounded-full object-cover" src="{{$offer->getURLImage()}}" /> --}}
                <div class="pl-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl text-gray-600 dark:text-gray-400">{{$offer->name}}</h1>
                        <h2 class="ml-64 text-right">{{$offer->formatedDate()}}</h2>
                    </div>
                    <div class="flex mt-4">
                        <p>{{$offer->category->name}}</p>
                        <p class="ml-7">{{$offer->employment}}</p>
                        <p class="ml-7">{{$offer->contract}}</p>
                    </div>
                    <div class="flex mt-4">
                        @if($offer->salary && $offer->payment)
                            <p>{{$offer->salary}} {{$offer->payment}}</p>
                        @else
                            <p>Cena do ustalenia</p>
                        @endif
                        <p class="ml-7">Wolne miejsca: {{$offer->vacancy}}</p>
                    </div>
                </div>
            </div>
{{--            <div class="pt-4">--}}
{{--                <p>{!! $offer->description !!}</p>--}}
{{--            </div>--}}
            <div>
                <h1 class="mt-6 font-bold">Opis pracy</h1>
                <p>{{$offer->description}}</p>
                @if($skills)
                    <h2 class="mt-6 font-bold">Wymagane umiejętności</h2>
                    <ul>
                        @foreach($skills as $skill)
                            <li>{{$skill->skill}}: {{$skill->skill_level}}</li>
                        @endforeach
                    </ul>
                @endif
                <h2 class="mt-6 font-bold">Twoje zadania:</h2>
                <ul>
                    @foreach($offer->tasks as $task)
                        <li>{{$task}}</li>
                    @endforeach
                </ul>
                <h2 class="mt-6 font-bold">Nasze oczekiwania:</h2>
                <ul>
                    @foreach($offer->expectancies as $expectance)
                        <li>{{$expectance}}</li>
                    @endforeach
                </ul>
                <h2 class="mt-6 font-bold">Mile widziane:</h2>
                <ul>
                    @foreach($offer->additionals as $additional)
                        <li>{{$additional}}</li>
                    @endforeach
                </ul>
                <h2 class="mt-6 font-bold">Zapewniamy:</h2>
                <ul>
                    @foreach($offer->assurances as $assurance)
                        <li>{{$assurance}}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Prawy panel --}}
        <div class="mr-32 border-[1px] border-gray-300 dark:border-0 dark:bg-gray-800/50 p-6 rounded-lg w-1/4">
            <div class="flex justify-center">
                @if($canNotApply == 'userMadeThisOffer')
                    <a href="{{route('offer.myoffers')}}" class="text-xl text-white bg-orange hover:bg-orange-500 p-4 rounded-2xl hover:bg-gray-800
                transition-colors transition-colors content-center">
                        ZOBACZ SZCZEGÓŁY TWOJEJ OFERTY
                    </a>
                @elseif($canNotApply == 'userHasApplied')
                    <h1>Twoja aplikacja została już nadana.</h1>
                    <form method="get" action="{{route('offer-application.index')}}">
                        <button type="submit" class="text-xl text-white bg-orange hover:bg-orange-500 p-4 rounded-2xl hover:bg-gray-800
                transition-colors transition-colors content-center">OBSERWUJ STATUS APLIKACJI</button>
                    </form>
                    @else
                    <a href="{{route('offer-application.create', $offer)}}" class="text-xl text-white bg-orange hover:bg-orange-500 p-4 rounded-2xl hover:bg-gray-800
                transition-colors transition-colors content-center">
                        APLIKUJ TERAZ
                    </a>
                @endif

            </div>
            <livewire:favourites-button :offer="$offer"/>

        </div>
    </div>
    @if($category_offers)
        <div class="ml-32 mr-32 gap-x-6 pl-3 pr-3 pb-3">
            <div class="p-6 bg-gray-200/50 dark:bg-gray-800/50 rounded-lg border-[1px] border-gray-300 dark:border-0">
                <h1>Polecane oferty o tej samej kategorii</h1>
                <div class="grid xl:col-span-4 lg:grid-cols-3 md:grid-cols-2 sm:col-span-1">
                    @foreach($category_offers as $offer_cat)
                        <x-offer-item :offer="$offer_cat"></x-offer-item>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
