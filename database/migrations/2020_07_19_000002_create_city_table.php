<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {

            // city_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('city_id')->nullable(false)->autoIncrement();

            // city VARCHAR(50) NOT NULL
            $table->string('city', 50)->nullable(false);

            // country_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('country_id')->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (city_id)
            //$table->primary('city_id');

            // KEY idx_fk_country_id (country_id)
            $table->index('country_id', 'idx_fk_country_id');

        });

        Schema::table('city', function (Blueprint $table) {

            // CONSTRAINT `fk_city_country` FOREIGN KEY (country_id) REFERENCES country (country_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('country_id')->references('country_id')->on('country')
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
        Schema::dropIfExists('city');
    }
}
