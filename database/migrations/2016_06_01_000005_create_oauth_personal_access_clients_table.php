<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

class CreateOauthPersonalAccessClientsTable extends Migration
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
        $this->schema->create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('client_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('oauth_personal_access_clients');
    }

    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection(): string
    {
        return \config('passport.storage.database.connection');
    }
}
