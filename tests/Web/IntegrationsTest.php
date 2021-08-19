<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;
use function route;

class IntegrationsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(3)->createOne();
        Passport::actingAs($user);

        $this
            ->get(route('integrations.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integrations')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->get(route('integrations.create', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('IntegrationEdit')
            )
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->hasClients(1)->createOne();
        Passport::actingAs($user);
        /** @var Client $client */
        $client = $user->clients->first();

        $this
            ->post(route('integrations.store'), [
                'title' => $title = $this->faker->jobTitle.' title', // some title less 5 characters length
                'description' => $description = $this->faker->sentence,
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'oauth2_client_id' => $client->getKey(),
                ],
            ])
            ->assertStatus(303)
        ;

        /** @var Integration $integration */
        $integration = $user->integrations->first();
        self::assertNotNull($integration);
        self::assertEquals($title, $integration->title);
        self::assertEquals($description, $integration->description);
        self::assertEquals($settings, $integration->settings);
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->get(route('integrations.show', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integration')
            )
        ;
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->get(route('integrations.edit', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('IntegrationEdit')
            )
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->patch(route('integrations.update', $integration), [
                'title' => $newTitle = $this->faker->jobTitle.' title', // some title less 5 characters length
            ])
            ->assertStatus(303)
            ->assertRedirect(route('integrations.edit', $integration))
        ;

        self::assertEquals($newTitle, $integration->fresh()->title);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->deleteJson(route('integrations.destroy', $integration))
            ->assertStatus(303)
            ->assertRedirect(route('integrations.index'))
        ;
    }
}
