@if(str_contains(URL::current(), 'calendar/update'))
    @php
        $new = false;
    @endphp
@else
    @php
        $new = true;
    @endphp
@endif
<div>
    <div class="border border-green-500 bg-green-100 p-4 m-2">
        <x-calendar.explanation :dates="$dates" :new="$new"/>
    </div>
    <div class="border border-gray-500 mx-2 my-4">
        <div class="relative flex flex-col">
            <div class="py-3 px-6 mb-4 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                <div class="inline-block text-2xl text-blue-700">
                    Create or update games happening on {{ $last_date->date->format('jS \o\f M Y') }}
                </div>
            </div>

            <div class="flex flex-wrap p-2">
                <div class="w-full lg:w-2/3 px-4">
                    <form wire:submit="save">
                        <div class="border-indigo-400 border-2 rounded-md p-2 mb-4">
                            <x-calendar.playing-date :dates="$dates"/>
                        </div>

                        <div class="flex justify-between w-full border-green-500 border-2 rounded-md p-2 mb-4">
                            <x-calendar.team-choice teamNr="team1" :teams="$teams">
                                Home Team
                            </x-calendar.team-choice>
                            <x-calendar.team-choice teamNr="team2" :teams="$teams">
                                Visitors
                            </x-calendar.team-choice>
                        </div>

                        <div class="border-green-500 border-2 rounded-md p-2 mb-4">
                            <x-calendar.venue-choice :venues="$venues">
                                Venue <span class="text-gray-700">(autofilled with Home Team)</span>
                            </x-calendar.venue-choice>
                        </div>

                        <div class="block">
                            <x-primary-button wire:loading.attr="disabled">Create this game</x-primary-button>

                            <x-spinner target="save, event.team1, event.team2, event.venue_id"/>
                            <x-action-message class=" inline-block mx-3 text-2xl p-2" on="event-created">
                                Game saved!
                            </x-action-message>

                            <div class="mt-8">
                                <x-secondary-button class="bg-blue-300 hover:bg-blue-100" wire:click="createNewTeam">
                                    If a new team joins the season, you may create it here
                                </x-secondary-button>
                            </div>

                            @if($new === true)
                                <div class="mt-8">
                                    <x-secondary-button wire:click="concludeSeason">
                                        The new Season is created
                                    </x-secondary-button>
                                </div>
                            @else
                                <div class="mt-8">
                                    <x-secondary-button wire:click="continueToCalendar">
                                        When done, you may continue to the Calendar overview
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="w-full lg:w-1/3 px-4">
                    <x-spinner target="event.date_id"/>
                    <div wire:target="event.date_id" wire:loading.remove>
                        <x-calendar.events-list
                            :events="$events"
                            :dates="$dates"
                            :last_date="$last_date"

                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
