<?php

declare(strict_types=1);

namespace Tests\Api\OAuth;

use App\Models\OAuth\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'view-oauth_clients',
        ]);

        $this
            ->getJson('/api/oauth/clients')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    $client->toArray(),
                ],
            ])
        ;
    }

    public function testStore(): void
    {
        $user = User::factory()->createOne();

        Passport::actingAs($user, [
            'create-oauth_clients',
        ]);

        $this
            ->postJson('/api/oauth/clients', $data = [
                'name' => 'Foo Bar',
                'redirect' => 'https://example.com',
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => $data,
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'created_at',
                    'updated_at',
                ],
            ])
        ;
    }

    public function testShow(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'view-oauth_clients',
        ]);

        $this
            ->getJson('/api/oauth/clients/'.$client->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => $client->toArray(),
            ])
        ;
    }

    public function testUpdate(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'update-oauth_clients',
        ]);

        $this
            ->putJson('/api/oauth/clients/'.$client->id, $data = [
                'name' => 'Foo Bar',
                'redirect' => 'https://example.com',
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => $data,
            ])
        ;
    }

    public function testDestroy(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'delete-oauth_clients',
        ]);

        $this
            ->deleteJson('/api/oauth/clients/'.$client->id)
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $client->id,
                    ],
                ]
            )
        ;
    }
}
