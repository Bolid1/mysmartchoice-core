<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FirmsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms($cnt = 3)->createOne();
        Passport::actingAs($user);

        $this
            ->getJson(route('api.firms.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
            ->assertJsonCount($cnt, 'data')
        ;
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user);

        $this
            ->postJson(route('api.firms.store'), [
                'title' => $title = 'Firm title'
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    // fixme: need more data checks
                ],
            ])
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
        Passport::actingAs($user);

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->getJson(route('api.firms.show', $firm))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $firm->id,
                    // fixme: need more data checks
                ],
            ])
        ;
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();
        Passport::actingAs($user);

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->patchJson(route('api.firms.update', $firm), [
                // fixme: need more data for patch
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $firm->id,
                    // fixme: need more data for checks
                ],
            ])
        ;
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(1)->createOne();
        Passport::actingAs($user);

        /** @var Firm $firm */
        $firm = $user->firms->first();

        $this
            ->deleteJson(route('api.firms.destroy', $firm))
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $firm->id,
                        // fixme: need more data for checks
                    ],
                ]
            )
        ;

        self::assertNull($firm->fresh());
        // or for soft deletes:
        // self::assertNotNull($firm->fresh());
    }
}
