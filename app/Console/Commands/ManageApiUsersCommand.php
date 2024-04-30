<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\form;
use function Laravel\Prompts\select;

class ManageApiUsersCommand extends Command
{
    protected $signature = 'api:manage-users';

    protected $description = 'Create a new user to access the API';

    public function handle(): void
    {
        $action = select(
            'What would you like to do?',
            ['Get existing user', 'Create new user']
        );

        match ($action) {
            'Get existing user' => $this->getUser(),
            'Create new user'   => $this->createUser(),
        };
    }

    public function createUser()
    {
        $responses = form()
            ->text(
                'Please enter your name',
                required: true,
                name: 'name'
            )
            ->text(
                'Email Address',
                required: true,
                name: 'email',
                validate:['email' => 'email|unique:users']
            )
            ->password(
                'Password',
                required: true,
                name: 'password'
            )
            ->submit();

        $user = User::create([
            'name' => $responses['name'],
            'password' => $responses['password'],
            'email' => $responses['email']
        ]);

        $this->info('New user ' . $user->email . ' has been created.');
        $this->info('Please save your api token, you will need this to sample greatness');
        $this->info($user->api_token);

    }
}
