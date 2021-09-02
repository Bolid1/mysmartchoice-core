<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\OAuthClient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use function route;

class OAuthClientsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        OAuthClient::factory()->count(3)->create();

        Passport::actingAs($user, [
            'view-oauth_clients',
        ]);

        $this
            ->getJson(route('api.oauth_clients.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user, [
            'create-oauth_clients',
        ]);

        $response = $this
            ->postJson(route('api.oauth_clients.store'), [
                'name' => $this->faker->jobTitle,
                'redirect' => $this->faker->url,
            ])
            ->assertStatus(201)
        ;

        /** @var OAuthClient $oAuthClient */
        $oAuthClient = $user->clients->first();

        $response
            ->assertJson([
                'data' => [
                    'secret' => $oAuthClient->secret,
                ],
            ])
        ;
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var OAuthClient $client */
        $client = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        Passport::actingAs($user, [
            'view-oauth_clients',
        ]);

        $this
            ->getJson(route('api.oauth_clients.show', $client->id))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $client->id,
                ],
            ])
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var OAuthClient $oAuthClient */
        $oAuthClient = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        Passport::actingAs($user, [
            'update-oauth_clients',
        ]);

        $this
            ->patchJson(route('api.oauth_clients.update', $oAuthClient), [
                'name' => $this->faker->jobTitle,
                'redirect' => $this->faker->url,
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $oAuthClient->id,
                ],
            ])
        ;
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var OAuthClient $oAuthClient */
        $oAuthClient = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        Passport::actingAs($user, [
            'delete-oauth_clients',
        ]);

        $this
            ->deleteJson(route('api.oauth_clients.destroy', $oAuthClient))
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $oAuthClient->id,
                    ],
                ]
            )
        ;

        self::assertNotNull($fresh = $oAuthClient->fresh());
        self::assertTrue($fresh->revoked);
    }
}
