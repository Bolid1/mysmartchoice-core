<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\OAuthClient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
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

        $this
            ->actingAs($user)
            ->get(route('oauth_clients.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuthClients')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->get(route('oauth_clients.create'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuthClientEdit')
            )
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->postJson(route('oauth_clients.store'), [
                'name' => $this->faker->jobTitle,
                'redirect' => $this->faker->url,
            ])
            ->assertStatus(303)
        ;

        self::assertNotNull($user->clients->first());
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        /** @var OAuthClient $oAuthClient */
        $oAuthClient = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->get(route('oauth_clients.show', $oAuthClient))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuthClient')
                    ->has('oauth_client', fn (Assert $page) => $page
                        ->where('name', $oAuthClient->name)
                        ->where('secret', $oAuthClient->secret)
                        ->etc()
                    )
            )
        ;
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        /** @var OAuthClient $oAuthClient */
        $oAuthClient = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->get(route('oauth_clients.edit', $oAuthClient))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('OAuthClientEdit')
                    ->has('oauth_client', fn (Assert $page) => $page
                        ->where('name', $oAuthClient->name)
                        ->where('secret', $oAuthClient->secret)
                        ->etc()
                    )
            )
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

        $this
            ->actingAs($user)
            ->patch(route('oauth_clients.update', $oAuthClient), [
                'name' => $this->faker->jobTitle,
                'redirect' => $this->faker->url,
            ])
            ->assertStatus(303)
            ->assertRedirect(route('oauth_clients.edit', $oAuthClient))
        ;

        // self::assertEquals($newFieldValue, $oAuthClient->fresh()->field);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        /** @var OAuthClient $oAuthClient */
        $oAuthClient = OAuthClient::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->delete(route('oauth_clients.destroy', $oAuthClient))
            ->assertStatus(303)
            ->assertRedirect(route('oauth_clients.index'))
        ;

        self::assertNotNull($fresh = $oAuthClient->fresh());
        self::assertTrue($fresh->revoked);
    }
}
