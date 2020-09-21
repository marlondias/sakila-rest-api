<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_actor', function (Blueprint $table) {

            // actor_id SMALLINT UNSIGNED NOT NULL,
            $table->unsignedSmallInteger('actor_id')->nullable(false);

            // film_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('film_id')->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (actor_id,film_id)
            $table->primary(['actor_id', 'film_id']);

            // KEY idx_fk_film_id (`film_id`)
            $table->index('film_id', 'idx_fk_film_id');

        });

        Schema::table('film_actor', function (Blueprint $table) {

            // CONSTRAINT fk_film_actor_actor FOREIGN KEY (actor_id) REFERENCES actor (actor_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('actor_id')->references('actor_id')->on('actor')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_film_actor_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('film_id')->references('film_id')->on('film')
            ->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_actor');
    }
}
