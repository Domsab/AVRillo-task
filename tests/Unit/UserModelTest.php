<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

#[Group('kanye-rest')]
class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_api_token_is_created(): void
    {
        $user = User::create([
            'name'     => 'Kanye West',
            'email'    => 'not@adidas.com',
            'password' => 'not-a-fish',
        ]);

        $this->assertNotEmpty($user->api_token);

        $this->assertEquals(User::API_TOKEN_LENGTH, strlen($user->api_token));

        $this->assertDatabaseHas('users', [
            'name'  => 'Kanye West',
            'email' => 'not@adidas.com',
            'api_token' => $user->api_token,
        ]);
    }

    public function test_user_relationships(): void
    {
        $user = User::factory()->create();

        $user->quotes()->createMany([
            ['quote' => 'A pessimist is a person who has had to listen to too many optimists'],
            ['quote' => 'Better to remain silent and be thought a fool than to speak out and remove all doubt'],
        ]);

        $this->assertDatabaseHas('quotes', [
            'user_id' => $user->id,
            'quote'  => 'A pessimist is a person who has had to listen to too many optimists',
        ]);

        $this->assertDatabaseHas('quotes', [
            'user_id' => $user->id,
            'quote'  => 'Better to remain silent and be thought a fool than to speak out and remove all doubt',
        ]);
    }
}
