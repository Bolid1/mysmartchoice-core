<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Integration;
use App\Models\OAuth\Client as Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
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
        Passport::actingAs($user, [
            'view-integrations',
        ]);

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
        $user = User::factory()->hasClients(1)->createOne();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'create-integrations',
        ]);

        $this
            ->postJson(route('api.integrations.store'), [
                'title' => $title = $this->faker->jobTitle.' title', // some title less 5 characters length
                'description' => $description = $this->faker->sentence,
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'oauth2_client_id' => $client->getKey(),
                    'oauth2_scopes' => ['*'],
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
        /** @var User $user */
        $user = User::factory()->hasIntegrations(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        Passport::actingAs($user, [
            'view-integrations',
        ]);

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
        $user = User::factory()->hasIntegrations(1)->hasClients(1)->createOne();
        /** @var Integration $integration */
        $integration = $user->integrations->first();
        /** @var Client $client */
        $client = $user->clients->first();

        Passport::actingAs($user, [
            'update-integrations',
        ]);

        $this
            ->patchJson(route('api.integrations.update', $integration), [
                'title' => $newTitle = $this->faker->jobTitle.' title', // some title less 5 characters length
                'settings' => $settings = [
                    'auth' => 'oauth2',
                    'oauth2_client_id' => $client->getKey(),
                    'oauth2_scopes' => ['*'],
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
        /** @var User $user */
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
