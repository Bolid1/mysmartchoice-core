<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Tests\TestCase;
use function route;

class IntegrationsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(3)->createOne();

        $this
            ->actingAs($user)
            ->get(route('integrations.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integrations/Integrations')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->actingAs($user)
            ->get(route('integrations.create', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integrations/IntegrationEdit')
            )
        ;
    }

    public function testStore(): void
    {
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->post(route('integrations.store'), [
                'title' => $title = $this->faker->jobTitle.' title', // some title less 5 characters length
                'description' => $description = $this->faker->sentence,
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'authorize_uri' => 'https://example.com',
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
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->actingAs($user)
            ->get(route('integrations.show', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integrations/Integration')
            )
        ;
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->actingAs($user)
            ->get(route('integrations.edit', $integration))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Integrations/IntegrationEdit')
            )
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->actingAs($user)
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
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        // Ensure that integration can be deleted
        $integration->status = Integration::STATUS_DRAFT;
        $integration->save();

        $this
            ->actingAs($user)
            ->deleteJson(route('integrations.destroy', $integration))
            ->assertStatus(303)
            ->assertRedirect(route('integrations.index'))
        ;
    }
}
