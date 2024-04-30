<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quotes;
use App\Services\KanyeRestService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class KayneRestManagerTest extends TestCase
{
    public function test_new_user_is_allowed_get_quotes(): void
    {
        $user = User::factory()
            ->has(Quotes::factory()->count(5))
            ->create();

        Auth::loginUsingId($user->id);

        $response = $this->withToken($user->api_token)->get(
            uri:'/kanye-rest-quotes',
        );

        $response->assertStatus(200);
    }

    public function test_new_user_can_not_use_another_users_token(): void
    {
        $badUser = User::factory()
            ->has(Quotes::factory()->count(5))
            ->create();

        $user = User::factory()
            ->has(Quotes::factory()->count(5))
            ->create();

        Auth::loginUsingId($badUser->id);

        $response = $this->withToken($user->api_token)->get(
            uri:'/kanye-rest-quotes',
        );

        $response->assertStatus(401);
    }

    public function test_user_can_get_five_unique_quotes(): void
    {
        Http::fake([
            KanyeRestService::KANYE_REST_ENDPOINT => Http::sequence()
                ->push('example1', 200)
                ->push('example2', 200)
                ->push('example3', 200)
                ->push('example4', 200)
                ->push('example4', 200)
                ->push('example5', 200)
        ]);

        $user = User::factory()->create();
        Auth::loginUsingId($user->id);

        $response = $this->withToken($user->api_token)->get(
            uri:'/kanye-rest-refresh',
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('quotes', ['quote' => 'example1']);
        $this->assertDatabaseHas('quotes', ['quote' => 'example2']);
        $this->assertDatabaseHas('quotes', ['quote' => 'example3']);
        $this->assertDatabaseHas('quotes', ['quote' => 'example4']);
        $this->assertDatabaseHas('quotes', ['quote' => 'example5']);
    }
}
