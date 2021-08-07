<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
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
        $user = User::factory()->hasFirms($firmsCount = 4)->createOne();
        Passport::actingAs($user);

        $this->get('/dashboard')->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('firms', fn (Assert $page) => $page
                    ->has('data', $firmsCount, fn (Assert $page) => $page
                        ->where('id', $user->firms->first()->id)
                        ->where('title', $user->firms->first()->title)
                        ->has('created_at')
                        ->has('updated_at')
                    )
                    ->where('links.first', URL::to('/dashboard?page=1'))
                    ->where('links.last', URL::to('/dashboard?page=1'))
                    ->has('links.next')
                    ->has('links.prev')
                    ->where('meta', [
                        'current_page' => 1,
                        'from' => 1,
                        'last_page' => 1,
                        'links' => [
                            [
                                'active' => false,
                                'label' => '&laquo; Previous',
                                'url' => null,
                            ],
                            [
                                'active' => true,
                                'label' => '1',
                                'url' => URL::to('dashboard?page=1'),
                            ],
                            [
                                'active' => false,
                                'label' => 'Next &raquo;',
                                'url' => null,
                            ],
                        ],
                        'path' => URL::to('dashboard'),
                        'per_page' => 15,
                        'to' => $firmsCount,
                        'total' => $firmsCount,
                    ])
                )
        )
        ;
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
                ->has('firm', fn (Assert $page) => $page
                    ->where('id', $user->firms->first()->id)
                    ->where('title', $user->firms->first()->title)
                    ->has('created_at')
                    ->has('updated_at')
                    ->has('users', 1, fn (Assert $page) => $page
                        ->whereAll([
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ])
                        ->has('created_at')
                        ->has('updated_at')
                    )
                )
        )
        ;
    }
}
