<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IntegrationsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        $user = User::factory()->hasIntegrations(3)->createOne();
        Passport::actingAs($user, [
            'view-integrations',
        ]);

        $this
            ->getJson('/api/integrations')
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
        $user = User::factory()->createOne();

        Passport::actingAs($user, [
            'create-integrations',
        ]);

        $this
            ->postJson('/api/integrations', [
                'title' => $title = $this->faker->jobTitle.' title', // some title less 5 characters length
                'description' => $description = $this->faker->sentence,
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'authorize_uri' => 'https://example.com',
                ],
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'owner_id' => $user->id,
                    'title' => $title,
                    'description' => $description,
                    'status' => Integration::STATUS_DRAFT,
                    'settings' => $settings,
                ],
            ])
        ;
    }

    public function testShow(): void
    {
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        Passport::actingAs($user, [
            'view-integrations',
        ]);

        $this
            ->getJson("/api/integrations/{$integration->id}")
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
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        Passport::actingAs($user, [
            'update-integrations',
        ]);

        $this
            ->patchJson("/api/integrations/{$integration->id}", [
                'title' => $newTitle = $this->faker->jobTitle.' title', // some title less 5 characters length
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'authorize_uri' => 'https://example.com',
                ],
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $integration->id,
                    'owner_id' => $user->id,
                    'title' => $newTitle,
                    'description' => $integration->description,
                    'status' => $integration->status,
                    'settings' => $settings,
                ],
            ])
        ;
    }

    public function testDestroy(): void
    {
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        // Ensure that integration can be deleted
        $integration->status = Integration::STATUS_DRAFT;
        $integration->save();

        Passport::actingAs($user, [
            'delete-integrations',
        ]);

        $this
            ->deleteJson("/api/integrations/{$integration->id}")
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
