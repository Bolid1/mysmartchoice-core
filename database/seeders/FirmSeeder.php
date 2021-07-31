<?php

namespace Database\Seeders;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class FirmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // There are five firms with 4 users
        // that works only in their firms
        /** @var Collection $firms */
        $firms = Firm::factory()
                     ->hasUsers(4)
                     ->count(5)
                     ->create()
        ;

        // There are support manager and developer,
        // who assist firms with their problems.
        User::factory()->count(2)->hasAttached($firms)->create();

        // And there are 3 consultants, that helps for some firms.
        User::factory()->hasAttached($firms->slice(0, 3))->createOne();
        User::factory()->hasAttached($firms->slice(1, 3))->createOne();
        User::factory()->hasAttached($firms->slice(0, 2))->createOne();
    }
}
