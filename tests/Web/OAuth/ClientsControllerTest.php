<?php

declare(strict_types=1);

namespace Tests\Web\OAuth;

use App\Models\OAuth\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->actingAs($user)
            ->get('/oauth/clients')
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuth/Clients')
                    ->has('clients', 1, fn (Assert $pageClient) => $pageClient
                        ->where('id', $client->id)
                        ->where('name', $client->name)
                        ->where('redirect', $client->redirect)
                    )
            )
        ;
    }

    public function testCreate(): void
    {
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->get('/oauth/clients/create')
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuth/ClientEdit')
            )
        ;
    }

    public function testStore(): void
    {
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->postJson('/oauth/clients', $data = [
                'name' => 'Foo Bar',
                'redirect' => 'https://example.com',
            ])
            ->assertStatus(303)
        ;

        /* @var Client $client */
        self::assertNotNull($client = $user->clients->first());
        self::assertEquals($data['name'], $client->name);
        self::assertEquals($data['redirect'], $client->redirect);
    }

    public function testShow(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->actingAs($user)
            ->get("/oauth/clients/{$client->id}")
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuth/Client')
                    ->has('client', fn (Assert $pageClient) => $pageClient
                        ->where('id', $client->id)
                        ->where('name', $client->name)
                        ->where('secret', $client->secret)
                        ->has('created_at')
                        ->has('updated_at')
                        ->etc()
                    )
            )
        ;
    }

    public function testEdit(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->actingAs($user)
            ->get("/oauth/clients/{$client->id}/edit")
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuth/ClientEdit')
                    ->has('client', fn (Assert $pageClient) => $pageClient
                        ->where('id', $client->id)
                        ->where('name', $client->name)
                        ->where('secret', $client->secret)
                        ->has('created_at')
                        ->has('updated_at')
                        ->etc()
                    )
            )
        ;
    }

    public function testUpdate(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->actingAs($user)
            ->patch("/oauth/clients/{$client->id}", $data = [
                'name' => 'Foo Bar',
                'redirect' => 'https://example.com',
            ])
            ->assertStatus(303)
            ->assertRedirect("/oauth/clients/{$client->id}/edit")
        ;

        self::assertEquals($data['name'], $client->refresh()->name);
        self::assertEquals($data['redirect'], $client->redirect);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->hasClients()->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->actingAs($user)
            ->delete("/oauth/clients/{$client->id}")
            ->assertStatus(303)
            ->assertRedirect('/oauth/clients')
        ;

        self::assertNotNull($fresh = $client->fresh());
        self::assertTrue($fresh->revoked);
    }
}
