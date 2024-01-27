<?php

namespace App\Livewire\Admin\Calendar;

use App\Livewire\Forms\EventForm;
use App\Models\Date;
use App\Models\Event;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    public Season $season;

    public Collection $dates;

    public Collection $events;

    public EventForm $event;

    public Date $last_date;

    public Collection $teams;

    public Collection $venues;

    public function mount(Season $season)
    {
        $this->season = $season;
        $this->dates = Date::whereSeasonId($season->id)->orderBy('date')->get();
        $this->getFirstEvent();
        $this->teams = Team::whereSeasonId($season->id)->orderBy('name')->get();
        $venue_ids = Team::whereSeasonId($season->id)->get()->unique('venue_id')->pluck('venue_id')->toArray();
        $this->venues = Venue::whereIn('id', $venue_ids)->where('name', '<>', 'BYE')->orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.admin.calendar.create');
    }

    public function updating($name, $value)
    {
        if ($name === 'event.date_id' && $value) {
            $this->last_date = Date::find($value);
            $this->events = $this->last_date->events;
            $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
        } elseif ($name === 'event.team1') {
            $team = Team::find($value);
            $this->event->venue_id = $team?->venue_id;
        }
    }

    public function save()
    {
        $this->event->store();
        $this->dispatch('event-created');
        $this->last_date->refresh();
        $this->events = $this->last_date->events;
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function addNextWeek()
    {
        // first make sure it is set at the latest day to avoid doubles
        $this->last_date = $this->dates->last();

        // add a week and save it, refresh dates and events
        $next_week = $this->last_date->date->addWeek();
        $this->last_date = Date::create(['season_id' => $this->season->id, 'date' => $next_week]);
        $this->dates = Date::whereSeasonId($this->season->id)->orderBy('date')->get();
        $this->events = $this->last_date->events;

        // prepare the field for the next game
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function removeEvent($event_id)
    {
        Event::find($event_id)->delete();
        $this->last_date->refresh();
        $this->events = $this->last_date->events;
    }

    private function getFirstEvent()
    {
        $this->last_date = $this->dates->last();
        $this->events = $this->last_date->events;
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function concludeSeason()
    {
        // make sure the first playing date games are set to 0-0
        $date_id = $this->dates->first()->id;
        Event::whereDateId($date_id)->update(['score1' => 0, 'score2' => 0]);
        $this->redirect('/index', navigate: true);
    }
}