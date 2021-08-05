<?php

declare(strict_types=1);

use App\Models\Firm;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

class CreateUserFirmTable extends Migration
{
    /**
     * The database schema.
     *
     * @var Builder
     */
    private Builder $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create(
            'user_firm',
            function (Blueprint $table) {
                $user = new User();
                $firm = new Firm();

                $table->id();

                $table->foreignIdFor($user);
                $table->foreignIdFor($firm);

                $table->timestamps();

                $table->unique([$user->getForeignKey(), $firm->getForeignKey()], 'user_firm_uniq_idx');
                // Left non uniq for less database usage
                $table->index([$firm->getForeignKey(), $user->getForeignKey()], 'firm_user_uniq_idx');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('user_firm');
    }
}
