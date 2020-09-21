<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_category', function (Blueprint $table) {

            // film_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('film_id')->nullable(false);

            // category_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('category_id')->nullable(false);

            // last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY (film_id, category_id)
            $table->primary(['film_id', 'category_id']);

        });

        Schema::table('film_category', function (Blueprint $table) {

            // CONSTRAINT fk_film_category_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('film_id')->references('film_id')->on('film')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_film_category_category FOREIGN KEY (category_id) REFERENCES category (category_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('category_id')->references('category_id')->on('category')
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
        Schema::dropIfExists('film_category');
    }
}
