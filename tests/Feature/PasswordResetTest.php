<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\Auth\PasswordResetLinkController::create
     */
    public function testResetPasswordLinkScreenCanBeRendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    /**
     * @covers \App\Http\Controllers\Auth\PasswordResetLinkController::store
     */
    public function testResetPasswordLinkCanBeRequested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * @covers \App\Http\Controllers\Auth\PasswordResetLinkController::store
     * @covers \App\Http\Controllers\Auth\NewPasswordController::create
     */
    public function testResetPasswordScreenCanBeRendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    /**
     * @covers \App\Http\Controllers\Auth\PasswordResetLinkController::store
     * @covers \App\Http\Controllers\Auth\NewPasswordController::store
     */
    public function testPasswordCanBeResetWithValidToken(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
