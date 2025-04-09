<div class="dark:bg-gray-800 h-48 mt-6 hover:text-gray-300 rounded-lg rounded-lg border-[1px]
border-gray-300 dark:border-0 m-1">
    <a href="{{route('offer.show', $offer)}}">
        <div class="p-2 gap-4">
            <div class="pb-1 pl-2 flex items-center">
                {{-- <img class="h-20 w-20 rounded-full mr-3" alt="{{$offer->slug}}" src="{{$offer->getURLImage()}}"/> --}}
                <h3 class="w-3/4 text-lg text-gray-600 dark:text-gray-400">{{$offer->name}}</h3>
                <h3 class="w-1/4 text-gray-600 dark:text-gray-400">@if($offer->salary)
                        {{$offer->salary}} zł/
                        @if($offer->payment)
                            {{$offer->payment}}
                        @endif
                    @else
                        <p>Wypłata do ustalenia</p>
                    @endif</h3>
                <h3 class="w-1/4 text-gray-600 dark:text-gray-400">@if($offer->employment)
                        {{$offer->employment}}
                    @else
                        <p>Brak umowy o pracę</p>
                @endif</h3>
            </div>
            <div class="right-0 pl-2">
                <h3 class="text-gray-600 dark:text-gray-400">@if($offer->category_id)
                        {{$offer->category->name}}
                    @else
                        <p>Brak kategorii</p>
                    @endif</h3>
                <h3 class="text-gray-600 dark:text-gray-400">@if($offer->work_mode)
                        {{$offer->work_mode}}
                    @else
                        <p>Brak trybu pracy</p>
                @endif</h3>
            </div>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="">

            </div>
            {{--            <p class="text-gray-600 dark:text-gray-400">{{$offer->shortDescription()}}</p>--}}
        </div>
    </a>
</div>
