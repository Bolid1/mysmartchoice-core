<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
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
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        FirmIntegration::factory()->count(3)->create([
            'firm_id' => $firm->id,
            'integration_id' => $integration->id,
        ]);

        $this
            ->actingAs($user)
            ->get(route('firms.firm_integrations.index', compact('firm')))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('FirmIntegrations')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();
        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->actingAs($user)
            ->get(route('firms.firm_integrations.create', compact('firm')))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('FirmIntegrationEdit')
            )
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->actingAs($user)
            ->postJson(route('firms.firm_integrations.store', compact('firm')), [
                'integration_id' => $integration->id,
            ])
            ->assertStatus(303)
        ;

        /** @var FirmIntegration $firmIntegration */
        $firmIntegration = $firm->integrationsInstalls->first();

        self::assertEquals(FirmIntegration::STATUS_INSTALLED, $firmIntegration->status);
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
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
            ->actingAs($user)
            ->get(route('firms.firm_integrations.edit', ['firm' => $firm, 'firm_integration' => $firmIntegration]))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('FirmIntegrationEdit')
            )
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
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
            ->actingAs($user)
            ->patch(route('firms.firm_integrations.update', ['firm' => $firm, 'firm_integration' => $firmIntegration]), [
                // fixme: need more data for patch
            ])
            ->assertStatus(303)
            ->assertRedirect(route('firms.firm_integrations.edit', ['firm' => $firm, 'firm_integration' => $firmIntegration]))
        ;

        // self::assertEquals($newFieldValue, $firmIntegration->fresh()->field);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
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
            ->actingAs($user)
            ->delete(route('firms.firm_integrations.destroy', ['firm' => $firm, 'firm_integration' => $firmIntegration]))
            ->assertStatus(303)
            ->assertRedirect(route('firms.firm_integrations.index', compact('firm')))
        ;

        self::assertNull($firmIntegration->fresh());
        // or for soft deletes:
        // self::assertNotNull($firmIntegration->fresh());
    }
}
