<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public User $user;

    #[Rule(['required', 'string', 'min:2', 'max:24', 'unique:'.User::class.',name'])]
    public $name = '';

    #[Rule(['required', 'email', 'max:254', 'unique:'.User::class.',email'])]
    public $email = '';

    #[Rule('nullable', 'max:24')]
    public ?string $contact_nr;

    #[Rule('nullable', 'string')]
    public ?string $gender;

    #[Rule(['nullable', 'date'])]
    public $email_verified_at;

    #[Rule(['nullable', 'date'])]
    public $last_game;

    #[Rule(['sometimes'])]
    public $password;

    public $messages = [
        'name.required' => 'A name is required',
        'name.unique' => 'A name has to be unique',
        'name.string' => 'A name needs to be a regular string',
        'name.min' => 'A name needs at least 2 characters',
        'name.max' => 'A name can not be longer than 24 characters',
        'email.required' => 'A valid email address is required',
        'email.email' => 'A valid email address is required',
        'email.unique' => 'The email has to be unique',
    ];

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
        $this->contact_nr = $this->user->contact_nr;
        $this->gender = $this->user->gender;
        $this->last_game = $this->user->last_game;
        $this->email_verified_at = $this->user->email_verified_at;
    }

    public function store(): User
    {
        $this->validate();
        $this->user->makeVisible(['password']);
        $user = User::create($this->user->toArray());
        $this->user->makeHidden(['password']);

        return $user;
    }

    public function update()
    {
        $this->validate();
        $this->user->update($this->all());
        $this->user->refresh();
    }
}
