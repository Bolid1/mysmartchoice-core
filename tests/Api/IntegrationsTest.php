<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->getJson(route('api.integrations.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'owner_id',
                        'title',
                        'description',
                        'status',
                    ],
                ],
            ])
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user);

        $this
            ->postJson(route('api.integrations.store'), [
                'title' => $title = $this->faker->jobTitle,
                'description' => $description = $this->faker->sentence,
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'owner_id' => $user->id,
                    'title' => $title,
                    'description' => $description,
                    'status' => Integration::STATUS_DRAFT,
                ],
            ])
        ;
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->getJson(route('api.integrations.show', $integration))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $integration->id,
                    'owner_id' => $user->id,
                    'title' => $integration->title,
                    'description' => $integration->description,
                    'status' => $integration->status,
                ],
            ])
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
            ->patchJson(route('api.integrations.update', $integration), [
                'title' => $newTitle = $this->faker->sentence,
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $integration->id,
                    'owner_id' => $user->id,
                    'title' => $newTitle,
                    'description' => $integration->description,
                    'status' => $integration->status,
                ],
            ])
        ;
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->deleteJson(route('api.integrations.destroy', $integration))
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $integration->id,
                        'owner_id' => $user->id,
                        'title' => $integration->title,
                        'description' => $integration->description,
                        'status' => $integration->status,
                    ],
                ]
            )
        ;

        self::assertNotNull($integration->fresh());
    }
}
