<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Firm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Firm::query()
            ->with('accounts')
            ->chunkById(
                100,
                fn (Collection $firms) => $firms->each(static function (Firm $firm) {
                    if (!$firm->accounts_count) {
                        Account::factory()
                            ->count(10)
                            ->create([
                                'firm_id' => $firm->id,
                            ])
                        ;
                    }
                })
            )
        ;
    }
}
