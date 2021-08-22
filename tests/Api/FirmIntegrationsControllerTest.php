<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use function compact;
use function route;

class FirmIntegrationsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        FirmIntegration::factory()->count(3)->create([
            'firm_id' => $firm->id,
            'integration_id' => $integration->id,
        ]);

        $this
            ->getJson(route('api.firms.firm_integrations.index', compact('firm')))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        // fixme: need more data checks
                    ],
                ],
            ])
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->postJson(route('api.firms.firm_integrations.store', compact('firm')), [
                'integration_id' => $integration->id,
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    // fixme: need more data checks
                ],
            ])
        ;
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        /** @var FirmIntegration $firmIntegration */
        $firmIntegration = FirmIntegration::factory()->createOne([
            'firm_id' => $firm->id,
            'integration_id' => $integration->id,
        ]);

        $this
            ->getJson(route('api.firms.firm_integrations.show', [
                'firm' => $firm,
                'firm_integration' => $firmIntegration,
            ]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $firmIntegration->id,
                    // fixme: need more data checks
                ],
            ])
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        /** @var FirmIntegration $firmIntegration */
        $firmIntegration = FirmIntegration::factory()->createOne([
            'firm_id' => $firm->id,
            'integration_id' => $integration->id,
        ]);

        $this
            ->patchJson(route('api.firms.firm_integrations.update', [
                'firm' => $firm,
                'firm_integration' => $firmIntegration,
            ]), [
                // fixme: need more data for patch
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $firmIntegration->id,
                    // fixme: need more data for checks
                ],
            ])
        ;
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        /** @var FirmIntegration $firmIntegration */
        $firmIntegration = FirmIntegration::factory()->createOne([
            'firm_id' => $firm->id,
            'integration_id' => $integration->id,
        ]);

        $this
            ->deleteJson(route('api.firms.firm_integrations.destroy', [
                'firm' => $firm,
                'firm_integration' => $firmIntegration,
            ]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $firmIntegration->id,
                        // fixme: need more data for checks
                    ],
                ]
            )
        ;

        self::assertNull($firmIntegration->fresh());
        // or for soft deletes:
        // self::assertNotNull($firmIntegration->fresh());
    }
}
