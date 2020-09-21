<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor', function (Blueprint $table) {

            // actor_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('actor_id')->nullable(false)->autoIncrement();

            // first_name VARCHAR(45) NOT NULL
            $table->string('first_name', 45)->nullable(false);

            // last_name VARCHAR(45) NOT NULL
            $table->string('last_name', 45)->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (actor_id)
            //$table->primary('actor_id');

            // KEY idx_actor_last_name (last_name)
            $table->index('last_name', 'idx_actor_last_name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor');
    }
}
