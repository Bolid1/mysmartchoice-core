<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Display a listing of the users.
     *
     * @return void
     */
    public function testGetList(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(4)->createOne();

        /** @var User $user */
        $user = $this->faker->randomElement($firm->users);
        Passport::actingAs($user);

        $response = $this->get("/api/firms/{$firm->id}/users");

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one user');
    }

    /**
     * Display the single user.
     *
     * @return void
     */
    public function testShowUser(): void
    {
        /** @var Firm $firm */
        $firm = Firm::factory()->hasUsers(4)->createOne();

        /** @var User $user */
        $actingUser = $firm->users->first();
        Passport::actingAs($actingUser);

        /** @var User $user */
        $user = $firm->users->last();

        $response = $this->get("/api/users/{$user->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one user');
        self::assertArrayHasKey('id', $data, 'User in response should contains key "id"');
        self::assertEquals($user->id, $data['id'], 'User in response should has same value for "id" as in DB');
        self::assertArrayHasKey('name', $data, 'User in response should contains key "name"');
        self::assertEquals($user->name, $data['name'], 'User in response should has same value for "name" as in DB');
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
            "/api/users/{$user->id}",
            [
                'name' => $newName,
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one user');
        self::assertArrayHasKey('id', $data, 'User in response should contains key "id"');
        self::assertEquals($user->id, $data['id'], 'User in response should has same value for "id" as in DB');
        self::assertArrayHasKey('name', $data, 'User in response should contains key "name"');
        self::assertEquals(
            $newName,
            $data['name'],
            'User in response should has same value for "name" as given in request'
        );

        $user->refresh();
        self::assertEquals($newName, $user->name, 'User name should be changed in DB');
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

        $response = $this->patchJson(
            "/api/users/{$user->id}",
            [
                // More than 255 symbols
                'name' => $this->faker->words(255),
            ]
        );

        $response->assertStatus(422);

        $response->assertJsonStructure(
            [
                'message',
                'errors' => [
                    'name',
                ],
            ]
        );

        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name must be a string.',
                    ],
                ],
            ]
        );
    }
}