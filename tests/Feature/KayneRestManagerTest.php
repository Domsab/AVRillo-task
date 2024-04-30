<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quotes;
use App\QuotesManager;
use App\Services\KanyeRestService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function test_user_can_get_quotes(): void
    {
        Http::fake([
            KanyeRestService::KANYE_REST_ENDPOINT => Http::response([
                'type'       => 'example',
                'id'         => 'some id',
                'attributes' => [
                    'email'      => 'some email',
                    'uuid'       => 'some uuid',
                    'created_at' => 'some created_at',
                    'updated_at' => 'some updated_at',
                ],
            ], 200),
        ]);

        $user = User::factory()->create();
        Auth::loginUsingId($user->id);

        $response = $this->withToken($user->api_token)->get(
            uri:'/kanye-rest-quotes',
        );

        $response->assertStatus(200);
        dd($response->getContent());
    }
}
