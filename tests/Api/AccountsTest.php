<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Account;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(20)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        $response = $this->getJson("/api/firms/{$firm->id}/accounts");

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'balance',
                    ],
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one account');
    }

    public function testShow(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        /** @var Account $account */
        $account = $firm->accounts->first();

        $response = $this->getJson("/api/firms/{$firm->id}/accounts/{$account->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $account->id,
                'created_at' => $account->created_at->toJSON(),
                'updated_at' => $account->updated_at->toJSON(),
                'title' => $account->title,
                'balance' => $account->balance,
                'firm_id' => $account->firm_id,
                'deleted_at' => $account->deleted_at,
            ],
        ]);
    }

    public function testStore(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        $response = $this->postJson("/api/firms/{$firm->id}/accounts", [
            'title' => $title = $this->faker->word(),
            'balance' => $balance = $this->faker->randomFloat(2, -1000000000, 1000000000),
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'data' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'title',
                        'balance',
                        'firm_id',
                        // 'deleted_at',
                ],
            ]
        );

        $response->assertJson([
            'data' => [
                'title' => $title,
                'balance' => $balance,
                'firm_id' => $firm->id,
            ],
        ]);
    }

    public function testUpdate(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        /** @var Account $account */
        $account = $firm->accounts->first();

        $response = $this->patchJson("/api/firms/{$firm->id}/accounts/{$account->id}", [
            'title' => $title = $this->faker->word(),
            'balance' => $balance = $this->faker->randomFloat(2, -1000000000, 1000000000),
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'created_at',
                    'updated_at',
                    'title',
                    'balance',
                    'firm_id',
                    // 'deleted_at',
                ],
            ]
        );

        $response->assertJson([
            'data' => [
                'title' => $title,
                'balance' => $balance,
                'firm_id' => $firm->id,
            ],
        ]);
    }

    public function testDestroy(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        /** @var Account $account */
        $account = $firm->accounts->first();

        self::assertNotNull(Account::withoutTrashed()->find($account->id));

        $response = $this->deleteJson("/api/firms/{$firm->id}/accounts/{$account->id}");

        $response->assertStatus(200);

        self::assertNotNull(Account::onlyTrashed()->find($account->id));
    }
}
