<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;

trait WithUsersSelect
{
    public array $users;

    public string $carbon_sub = '20 years';

    public function MountWithUsersSelect(): void
    {
        $this->loadUsersList();
    }

    private function loadUsersList(): void
    {
        $date_filter = Carbon::now()->sub($this->carbon_sub);
        $this->users = User::where('last_game', '>', $date_filter)
            ->orderBy('name')
            ->whereNotIn('id', [1]) //get rid of the administrator
            ->get(['id', 'name', 'last_game'])
            /*->map(function (User $user) {
                return ['id' => $user->id, 'name' => $user->name.' ('.$user->last_game->format('d-m-Y').')'];
            })*/
            ->pluck('name', 'id')
            ->toArray();
    }

    public function updatedWithUsersSelect($model, $value): void
    {
        if ($model === 'carbon_sub') {
            $this->carbon_sub = $value;
            $this->loadUsersList();
            $this->dispatch('users-list-updated');
        }
    }
}
