<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\Auth\RegisteredUserController::create
     */
    public function testRegistrationScreenCanBeRendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * @covers \App\Http\Controllers\Auth\RegisteredUserController::store
     */
    public function testNewUsersCanRegister(): void
    {
        $response = $this->post(
            '/register',
            [
                'name'                  => 'Test User',
                'email'                 => 'test@example.com',
                'password'              => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
