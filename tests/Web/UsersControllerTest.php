<?php

declare(strict_types=1);

namespace Tests\Web;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\Assert;
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

        $this
            ->actingAs($user)
            ->get("/firms/{$firm->id}/users")
            ->assertInertia(
            fn (Assert $page) => $page
                ->component('Firms/Users')
                ->has('firm', fn (Assert $pageFirm) => $pageFirm
                    ->where('id', $firm->id)
                    ->where('title', $firm->title)
                    ->has('created_at')
                    ->has('updated_at')
                )
                ->has('users', $usersCount, fn (Assert $page) => $page
                    ->where('id', $user->id)
                    ->where('name', $user->name)
                    ->where('email', $user->email)
                    ->has('created_at')
                    ->has('updated_at')
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

        $this
            ->actingAs($user)
            ->get("/firms/{$firm->id}/users/{$user->id}/edit")
            ->assertInertia(
            fn (Assert $page) => $page
                ->component('Firms/UserEdit')
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
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers($usersCount = 4)->createOne();

        /** @var User $user */
        $user = $firm->users->first();

        do {
            $newName = $this->faker->name;
            // Prevent same name generation
        } while ($newName === $user->name);

        $this
            ->actingAs($user)
            ->patch(
            "/firms/{$firm->id}/users/{$user->id}",
            [
                'name' => $newName,
            ]
        )
            ->assertStatus(303)
            ->assertRedirect("/firms/{$firm->id}/users/{$user->id}/edit");
    }

    /**
     * Update the single user with errors.
     *
     * @return void
     */
    public function testUpdateUserFailed(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers($usersCount = 4)->createOne();

        /** @var User $user */
        $user = $firm->users->first();

        $this
            ->actingAs($user)
            ->patch(
            "/firms/{$firm->id}/users/{$user->id}",
            [
                // More than 255 symbols
                'name' => $this->faker->words(255),
            ],
            [
                // Special checks for inertia
                'X-Inertia' => true,
                'Referer' => $referer = URL::to("/users/{$user->id}/edit"),
            ]
        )
        ->assertStatus(303)
        ->assertRedirect($referer);
    }
}
