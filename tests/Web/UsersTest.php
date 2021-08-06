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
use URL;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetList(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(4)->createOne();

        /** @var User $user */
        $user = $this->faker->randomElement($firm->users);
        Passport::actingAs($user);

        $this->get('/users')->assertInertia(
            fn (Assert $page) => $page
                ->component('Users')
                ->has('users', fn (Assert $page) => $page
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
                ->where('user', $user->toArray())
        );
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
