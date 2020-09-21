<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film', function (Blueprint $table) {

            // film_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('film_id')->nullable(false)->autoIncrement();

            // title VARCHAR(128) NOT NULL
            $table->string('title', 128)->nullable(false);

            // description TEXT DEFAULT NULL,
            $table->text('description')->nullable()->default(null);

            // release_year YEAR DEFAULT NULL
            $table->year('release_year')->nullable()->default(null);

            // language_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('language_id')->nullable(false);

            // original_language_id TINYINT UNSIGNED DEFAULT NULL
            $table->unsignedTinyInteger('original_language_id')->nullable()->default(null);

            // rental_duration TINYINT UNSIGNED NOT NULL DEFAULT 3
            $table->unsignedTinyInteger('rental_duration')->nullable(false)->default(3);

            // rental_rate DECIMAL(4,2) NOT NULL DEFAULT 4.99
            $table->decimal('rental_rate', 4, 2)->nullable(false)->default(4.99);

            // length SMALLINT UNSIGNED DEFAULT NULL
            $table->unsignedSmallInteger('length')->nullable()->default(null);

            // replacement_cost DECIMAL(5,2) NOT NULL DEFAULT 19.99
            $table->decimal('replacement_cost', 5, 2)->nullable(false)->default(19.99);

            // rating ENUM('G','PG','PG-13','R','NC-17') DEFAULT 'G'
            $table->enum('rating', ['G','PG','PG-13','R','NC-17'])->nullable()->default('G');

            // special_features SET('Trailers','Commentaries','Deleted Scenes','Behind the Scenes') DEFAULT NULL
            $table->set('special_features', ['Trailers','Commentaries','Deleted Scenes','Behind the Scenes'])
            ->nullable()->default(null);

            // last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->useCurrent();

            // PRIMARY KEY  (film_id)
            //$table->primary('film_id');

            // KEY idx_title (title)
            $table->index('title', 'idx_title');

            // KEY idx_fk_language_id (language_id)
            $table->index('language_id', 'idx_fk_language_id');

            // KEY idx_fk_original_language_id (original_language_id)
            $table->index('original_language_id', 'idx_fk_original_language_id');

        });

        Schema::table('film', function (Blueprint $table) {

            // CONSTRAINT fk_film_language FOREIGN KEY (language_id) REFERENCES language (language_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('language_id')->references('language_id')->on('language')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_film_language_original FOREIGN KEY (original_language_id) REFERENCES language (language_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('original_language_id')->references('language_id')->on('language')
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
        Schema::dropIfExists('film');
    }
}
