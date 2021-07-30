<?php

namespace Tests\Feature;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FirmsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Display a listing of the firms.
     *
     * @return void
     */
    public function testGetList(): void
    {
        Firm::factory()->count(40)->create();

        /** @var User $user */
        $user = User::factory()->createOne();
        Passport::actingAs($user);


        $response = $this->get('/api/firms');

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'title',
                    ],
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one firm');
    }

    /**
     * Display the single firm.
     *
     * @return void
     */
    public function testShowFirm(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var Firm $firm */
        $firm = Firm::factory()->createOne();

        Passport::actingAs($user);

        $response = $this->get("/api/firms/{$firm->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                ],
            ]
        );

        $data = $response->json('data');

        self::assertNotEmpty($data, 'Should has at least one firm');
        self::assertArrayHasKey('id', $data, 'Firm in response should contains key "id"');
        self::assertEquals($firm->id, $data['id'], 'Firm in response should has same value for "id" as in DB');
        self::assertArrayHasKey('title', $data, 'Firm in response should contains key "title"');
        self::assertEquals($firm->title, $data['title'], 'Firm in response should has same value for "title" as in DB');
    }
}
