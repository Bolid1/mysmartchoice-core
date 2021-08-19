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
use Laravel\Passport\Passport;
use Tests\TestCase;
use function compact;
use function route;

class FirmIntegrationsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();

        $this
            ->getJson(route('firms.integrations.installs.create', compact('firm', 'integration')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('FirmIntegrationEdit')
            )
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

        $response = $this
            ->postJson(route('firms.integrations.installs.store', compact('firm', 'integration')))
            ->assertStatus(303)
        ;

        /** @var FirmIntegration $install */
        $install = $firm->integrationsInstalls->first();
        self::assertNotNull($install);
        self::assertEquals($install->firm_id, $firm->id);
        self::assertEquals($install->integration_id, $integration->id);

        $response->assertRedirect(route('firms.integrations.installs.edit', compact('firm', 'integration', 'install')));
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->hasIntegrations(1)->createOne();
        Passport::actingAs($user);
        /** @var Firm $firm */
        $firm = $user->firms->first();
        /** @var Integration $integration */
        $integration = $user->integrations->first();
        $install = FirmIntegration::create(compact('integration', 'firm'));

        $this
            ->getJson(route('firms.integrations.installs.edit', compact('firm', 'integration', 'install')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('FirmIntegrationEdit')
            )
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
        $install = FirmIntegration::create(compact('integration', 'firm'));

        $this
            ->patchJson(route('firms.integrations.installs.update', compact('firm', 'integration', 'install')), [
            ])
            ->assertStatus(303)
            ->assertRedirect(route('firms.integrations.installs.edit', compact('firm', 'integration', 'install')))
        ;
    }
}
