<div>
    <table class="table-auto w-full md:w-auto">
        <thead class="whitespace-nowrap">
        <tr class="bg-gray-100">
            <th class="p-2 text-left text-gray-900 font-semibold">Date</th>
            <th class="p-2 text-left text-red-700">Home Team</th>
            <th class="p-2 text-left text-blue-700">Visitor</th>
            <th class="p-2 text-gray-900 text-center">Score</th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($dates as $date)
            @foreach ($date->events as $event)
                @if ($team->id === $event->team_1->id)
                    <tr>
                        <td class="p-2">
                            <div class="flex justify-start">
                                <div class="mr-2">
                                    <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <img src="{{ secure_asset('svg/file-pdf.svg') }}" alt="" width="16" height="16">
                                    </a>
                                </div>
                                <div>
                                    <a href="/dates/{{ $date->id }}" wire:navigate>
                                        {{ $event->date->date->format('jS \o\f M Y') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-green-600">
                            <strong>{{ @$team->name }}</strong>
                        </td>
                        <td class="p-2">
                            <a href="/teams/show/{{ $event->team_2->id }}" wire:navigate>
                                {{ $event->team_2->name }}
                            </a>
                        </td>
                        <td class="p-2 text-center">
                            @if($event->team_2->name === 'BYE')
                                <span class="green">BYE</span>
                            @elseif ($event->score1 !== null)
                                <strong class="{{ $event->score1 > 7 ? 'green' : 'red' }}">{{ $event->score1 }}</strong>/{{ $event->score2 }}
                            @elseif($event->score1 === 0 && $event->score2 === 0)
                                <span class="red">Not in</span>
                            @else
                                ----
                            @endif
                        </td>
                    </tr>
                @elseif($team->id === $event->team_2->id)
                    <tr>
                        <td class="p-2">
                            <div class="flex justify-start">
                                <div class="mr-2">
                                    <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <img src="{{ secure_asset('svg/file-pdf.svg') }}" alt="" width="16" height="16">
                                    </a>
                                </div>
                                <div>
                                    <a href="/dates/{{ $date->id }}" wire:navigate>
                                        {{ $event->date->date->format('jS \o\f M Y') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="p-2">
                            <a href="/teams/show/{{ $event->team_1->id }}" wire:navigate>
                                {{ $event->team_1->name }}
                            </a>
                        </td>
                        <td class="p-2 text-green-600">
                            <strong>{{ @$team->name }}</strong>
                        </td>
                        <td class="text-center">
                            @if($event->team_2->name === 'BYE')
                                <span class="green">BYE</span>
                            @elseif ($event->score2 !== null)
                                {{ $event->score1 }}/<strong class="{{ $event->score2 > 7 ? 'green' : 'red' }}">{{ $event->score2 }}</strong>
                            @elseif($event->score1 === 0 && $event->score2 === 0)
                                <span class="red">Not in</span>
                            @else
                                ----
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
