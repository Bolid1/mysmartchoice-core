<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Account;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Laravel\Passport\Passport;
use Tests\TestCase;
use function compact;
use function route;

class AccountsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(5)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->getJson(route('firms.accounts.index', compact('firm', 'account')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Accounts')
            )
        ;
    }

    public function testCreate(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->getJson(route('firms.accounts.create', compact('firm', 'account')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('AccountEdit')
            )
        ;
    }

    public function testStore(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);

        $response = $this
            ->postJson(route('firms.accounts.store', compact('firm')), $data = [
                'title' => 'FooBarBaz',
                'balance' => 123.32,
                'currency' => 'RUB',
            ])
            ->assertStatus(303)
        ;

        /** @var Account $account */
        $account = $firm->accounts->first();
        self::assertNotNull($account);
        self::assertEquals($data['title'], $account->title);
        self::assertEquals($data['balance'], $account->balance);
        self::assertEquals($data['currency'], $account->currency);

        $response->assertRedirect(route('firms.accounts.edit', compact('firm', 'account')));
    }

    public function testShow(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->getJson(route('firms.accounts.show', compact('firm', 'account')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Account')
            )
        ;
    }

    public function testEdit(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->getJson(route('firms.accounts.edit', compact('firm', 'account')))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('AccountEdit')
            )
        ;
    }

    public function testUpdate(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->patchJson(route('firms.accounts.update', compact('firm', 'account')), [
                'title' => $title = 'FooBarBaz',
            ])
            ->assertStatus(303)
            ->assertRedirect(route('firms.accounts.edit', compact('firm', 'account')))
        ;

        $fresh = $account->fresh();

        self::assertNotNull($fresh);
        self::assertNull($fresh->deleted_at);
        self::assertEquals($title, $fresh->title);
    }

    public function testDestroy(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->hasAccounts(1)->createOne();
        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);
        /** @var Account $account */
        $account = $firm->accounts->first();

        $this
            ->deleteJson(route('firms.accounts.destroy', compact('firm', 'account')))
            ->assertStatus(303)
            ->assertRedirect(route('firms.accounts.index', compact('firm')))
        ;

        $fresh = $account->fresh();

        self::assertNotNull($fresh);
        self::assertNotNull($fresh->deleted_at);
    }
}
