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

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetList(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers($usersCount = 4)->createOne();

        /** @var User $user */
        $user = $firm->users->first();
        Passport::actingAs($user);

        $this->get("/firms/{$firm->id}/users")->assertInertia(
            fn (Assert $page) => $page
                ->component('Users')
                ->has('firm', fn (Assert $pageFirm) => $pageFirm
                    ->where('id', $firm->id)
                    ->where('title', $firm->title)
                    ->has('created_at')
                    ->has('updated_at')
                )
                ->has('users', fn (Assert $page) => $page
                    ->has('data', $usersCount, fn (Assert $page) => $page
                        ->where('id', $user->id)
                        ->where('name', $user->name)
                        ->where('email', $user->email)
                        ->has('created_at')
                        ->has('updated_at')
                    )
                    ->has('links', fn (Assert $page) => $page
                        ->whereAll([
                            'first' => URL::to("/firms/{$firm->id}/users?page=1"),
                            'last' => URL::to("/firms/{$firm->id}/users?page=1"),
                            'next' => null,
                            'prev' => null,
                        ])
                    )
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
                                'url' => URL::to("/firms/{$firm->id}/users?page=1"),
                            ],
                            [
                                'active' => false,
                                'label' => 'Next &raquo;',
                                'url' => null,
                            ],
                        ],
                        'path' => URL::to("/firms/{$firm->id}/users"),
                        'per_page' => 15,
                        'to' => $usersCount,
                        'total' => $usersCount,
                    ])
                )
        )
        ;
    }

    public function testEdit(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(1)->createOne();

        /** @var User $user */
        $user = User::find($firm->users->first()->id);
        Passport::actingAs($user);

        $this->get("/users/{$user->id}/edit")->assertInertia(
            fn (Assert $page) => $page
                ->component('UserEdit')
                ->has('user', fn (Assert $page) => $page
                    ->where('id', $user->id)
                    ->where('name', $user->name)
                    ->where('email', $user->email)
                    ->has('created_at')
                    ->has('updated_at')
                )
        )
        ;
    }

    /**
     * Update the single user.
     *
     * @return void
     */
    public function testUpdateUser(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user);

        do {
            $newName = $this->faker->name;
            // Prevent same name generation
        } while ($newName === $user->name);

        $response = $this->patch(
            "/users/{$user->id}",
            [
                'name' => $newName,
            ]
        );

        $response->assertStatus(303);
        $response->assertRedirect("/users/{$user->id}/edit");
    }

    /**
     * Update the single user with errors.
     *
     * @return void
     */
    public function testUpdateUserFailed(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user);

        $response = $this->patch(
            "/users/{$user->id}",
            [
                // More than 255 symbols
                'name' => $this->faker->words(255),
            ],
            [
                // Special checks for inertia
                'X-Inertia' => true,
                'Referer' => $referer = URL::to("/users/{$user->id}/edit"),
            ]
        );

        $response->assertStatus(303);
        $response->assertRedirect($referer);
    }
}
