<div class="p-3">
    <x-input-label for="tasks" :value="__('Zadania dla pracownika')"/>
    @foreach($jobDescriptions['tasks'] as $key => $value)
        <div class="flex">
            <div class=" w-full">
                <x-text-input id="tasks" class="block mt-1 w-full" name="tasks[]"
                              :value="old('tasks')" autofocus autocomplete="tasks" wire:model="jobDescriptions.{{$key}}.name"/>
                <x-input-error :messages="$errors->get('tasks')" class="mt-2"/>
            </div>
            <button wire:click.prevent="addDescription('tasks')" class="ml-4 pl-3 pr-3 text-white rounded-lg bg-orange hover:bg-orange-500">Dodaj</button>
        </div>
    @endforeach

    <x-input-label for="expectancies" :value="__('Twoje oczekiwania')"/>
    @foreach($jobDescriptions['expectancies'] as $expectancy)
        <div class="flex">
            <div class=" w-full">
                <x-text-input id="expectancies" class="block mt-1 w-full" name="expectancies[]"
                              :value="old('expectancies')" autofocus autocomplete="expectancies"/>
                <x-input-error :messages="$errors->get('expectancies')" class="mt-2"/>
            </div>
            <button wire:click.prevent="addDescription('expectancies')" class="ml-4 pl-3 pr-3 text-white rounded-lg bg-orange hover:bg-orange-500">Dodaj</button>
        </div>
    @endforeach

    <x-input-label for="additionals" :value="__('Dodatkowe umiejętności pracownika')"/>
    @foreach($jobDescriptions['additionals'] as $additional)
        <div class="flex">
            <div class=" w-full">
                <x-text-input id="additionals" class="block mt-1 w-full" name="additionals[]"
                              :value="old('additionals')" autofocus autocomplete="additionals"/>
                <x-input-error :messages="$errors->get('additionals')" class="mt-2"/>
            </div>
            <button wire:click.prevent="addDescription('additionals')" class="ml-4 pl-3 pr-3 text-white rounded-lg bg-orange hover:bg-orange-500">Dodaj</button>
        </div>
    @endforeach

    <x-input-label for="assurances" :value="__('Twoje zapewnienia dla pracownika')"/>
    @foreach($jobDescriptions['assurances'] as $assurance)
        <div class="flex">
            <div class=" w-full">
                <x-text-input id="assurances" class="block mt-1 w-full" name="assurances[]"
                              :value="old('assurances')" autofocus autocomplete="assurances"/>
                <x-input-error :messages="$errors->get('assurances')" class="mt-2"/>
            </div>
            <button wire:click.prevent="addDescription('assurances')" class="ml-4 pl-3 pr-3 text-white rounded-lg bg-orange hover:bg-orange-500">Dodaj</button>
        </div>
    @endforeach

    <x-input-label for="expectancies" :value="__('Wymagane umiejętności')"/>
    @foreach($jobDescriptions['skills'] as $skill)
        <div class="flex">
                <div class="flex gap-3 w-full">
                    <select id="skills_skill" name="skills[]" placeholder="Wybierz Twoje oczekiwania..."
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700
                            dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                            focus:ring-indigo-500 dark:focus:ring-indigo-600 w-4/5">
                        <option value=""></option>
                        @foreach($skills as $skill)
                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                        @endforeach
                    </select>
                    <select id="skill_level" name="skills[]" placeholder="Wybierz Twoje oczekiwania..."
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700
                            dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                            focus:ring-indigo-500 dark:focus:ring-indigo-600 w-1/5">
                        <option value=""></option>
                        @foreach($skillLevel as $skillLvl)
                            <option value="{{$skillLvl->value}}">{{$skillLvl->value}}</option>
                        @endforeach
                    </select>
                </div>
            <button wire:click.prevent="addDescription('skills')" class="ml-4 pl-3 pr-3 text-white rounded-lg bg-orange hover:bg-orange-500">Dodaj</button>
        </div>
    @endforeach
</div>
