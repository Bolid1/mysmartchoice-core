<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Managers\UsersManager;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use App\Models\OAuth\Client;
use App\Models\User;
use App\Models\UserFirm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use function compact;
use function env;
use function now;

/**
 * Набор команд для развёртывания
 * локального приложения под разработчика.
 */
class DeveloperSeeder extends Seeder
{
    private UsersManager $usersManager;

    /**
     * @param UsersManager $usersManager
     */
    public function __construct(UsersManager $usersManager)
    {
        $this->usersManager = $usersManager;
    }

    public function run(): void
    {
        if (!$email = (string)env('DEVELOPER_EMAIL')) {
            Log::warning(
                'Try to seed developer info without DEVELOPER_EMAIL, please define it in .env file'
            );

            return;
        }

        $user = $this->seedUser($email);
        $firm = $this->seedFirm($user);
        $this->seedZenMoneyIntegration($user, $firm);
    }

    /**
     * @param string $email
     *
     * @return User
     */
    private function seedUser(string $email): User
    {
        $user = User::firstWhere('email', $email) ?: $this->usersManager->register([
            'name' => env('DEVELOPER_NAME') ?: $email,
            'password' => $password = env('DEVELOPER_PASSWORD') ?: 'password',
        ]);

        if (isset($password)) {
            Log::info('Created developer user!', compact('email', 'password'));
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @return Firm
     */
    private function seedFirm(User $user): mixed
    {
        if (null === $firm = $user->firms()->first()) {
            $firm = Firm::factory()->makeOne([
                'title' => 'My first firm',
            ]);

            UserFirm::insert([
                'user_id' => $user->id,
                'firm_id' => $firm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $firm;
    }

    private function seedZenMoneyIntegration(User $user, Firm $firm): void
    {
        $integration = Integration::firstOrCreate(
            [
                'owner_id' => $user->id,
                'title' => 'ZenMoney',
            ],
            [
                'description' => 'Красивый способ учёта и планирования личных финансов',
                'status' => Integration::STATUS_DRAFT,
                'settings' => '{"auth": "oauth2", "authorize_uri": "http://localhost:8090/oauth/msc/auth"}',
            ],
        );

        FirmIntegration::firstOrCreate(
            [
                'firm_id' => $firm->id,
                'integration_id' => $integration->id,
            ],
            [
                'status' => 'installed',
                'settings' => null,
            ],
        );

        $clientId = env('ZEN_CLIENT_ID');
        $clientSecret = env('ZEN_CLIENT_SECRET');
        if ($clientId && $clientSecret) {
            Client::firstOrCreate(
                [
                    'id' => $clientId,
                ],
                [
                    'user_id' => $user->id,
                    'name' => 'ZenMoney',
                    'secret' => $clientSecret,
                    'provider' => null,
                    'redirect' => env('ZEN_URI') ?: 'http://localhost:8090/oauth/msc/code',
                    'personal_access_client' => false,
                    'password_client' => false,
                    'revoked' => false,
                ],
            );
        }
    }
}
