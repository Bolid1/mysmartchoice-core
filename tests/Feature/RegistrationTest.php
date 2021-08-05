<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister(): void
    {
        $response = $this->post(
            '/register',
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ]
        );

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNewUsersCanBeCreatedByCommand(): void
    {
        $this
            ->artisan('users:create')
            ->expectsQuestion('Name?', 'Test User')
            ->expectsQuestion('Email?', 'test@example.com')
            ->expectsQuestion('Password?', 'password')
            ->assertExitCode(0)
        ;
    }
}
