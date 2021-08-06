<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FirmsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetList(): void
    {
        /** @var User $user */
        $user = User::factory()->hasFirms(4)->createOne();
        Passport::actingAs($user);

        $this->get('/dashboard')->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('firms', fn (Assert $page) => $page
                    ->has('data')
                    ->has('links')
                    ->has('total')
                    // @TODO: How to skip this props?
                    ->has('current_page')
                    ->has('first_page_url')
                    ->has('from')
                    ->has('last_page')
                    ->has('last_page_url')
                    ->has('next_page_url')
                    ->has('path')
                    ->has('per_page')
                    ->has('prev_page_url')
                    ->has('to')
                )
        );
    }

    public function testShow(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->createOne();

        /** @var User $user */
        $user = User::find($firm->users->first()->id);
        Passport::actingAs($user);

        $this->get("/firms/{$firm->id}")->assertInertia(
            fn (Assert $page) => $page
                ->component('Firm')
                ->where('firm', $firm->toArray())
        );
    }
}
