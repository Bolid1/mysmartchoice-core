<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('firm_id')->nullable(false);
            $table->string('title', 255)->nullable(false);
            // 1'000'000'000,00
            $table->float('balance', 12)->nullable(false);
            $table->char('currency', 3)->nullable(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
}
