<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_text', function (Blueprint $table) {

            // film_id SMALLINT NOT NULL
            $table->smallInteger('film_id')->nullable(false);

            // title VARCHAR(255) NOT NULL
            $table->string('title', 255)->nullable(false);

            // description TEXT
            $table->text('description')->nullable();

            // PRIMARY KEY  (film_id),
            $table->primary('film_id');

            // FULLTEXT KEY idx_title_description (title,description)
            //$table->index(['title', 'description'], 'idx_title_description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_text');
    }
}
