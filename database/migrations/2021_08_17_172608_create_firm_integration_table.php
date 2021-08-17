<?php

use App\Models\Firm;
use App\Models\Integration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmIntegrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('firm_integration', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Firm::class)->nullable(false);
            $table->foreignIdFor(Integration::class)->nullable(false);
            $table->string('status', '20')->nullable(false);
            $table->json('settings')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('firm_integration');
    }
}
