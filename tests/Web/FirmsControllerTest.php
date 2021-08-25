<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Tests\TestCase;
use function route;

class FirmsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms($cnt = 3)->createOne();

        $this
            ->actingAs($user)
            ->get(route('firms.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Firms')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->get(route('firms.create'))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('FirmEdit')
            )
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $this
            ->actingAs($user)
            ->postJson(route('firms.store'), [
                'title' => $title = 'Firm title',
            ])
            ->assertStatus(303)
        ;

        /** @var Firm $firm */
        $firm = $user->firms->first();
        self::assertNotNull($firm);
        self::assertEquals($title, $firm->title);
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->actingAs($user)
            ->get(route('firms.show', $firm))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Firm')
            )
        ;
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->actingAs($user)
            ->get(route('firms.edit', $firm))
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('FirmEdit')
            )
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->actingAs($user)
            ->patch(route('firms.update', $firm), [
                // fixme: need more data for patch
            ])
            ->assertStatus(303)
            ->assertRedirect(route('firms.edit', $firm))
        ;

        // self::assertEquals($newFieldValue, $firm->fresh()->field);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->actingAs($user)
            ->delete(route('firms.destroy', $firm))
            ->assertStatus(303)
            ->assertRedirect(route('firms.index'))
        ;

        self::assertNull($firm->fresh());
        // or for soft deletes:
        // self::assertNotNull($firm->fresh());
    }
}
