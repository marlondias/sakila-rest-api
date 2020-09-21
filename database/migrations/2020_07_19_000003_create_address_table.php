<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {

            // address_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('address_id')->nullable(false)->autoIncrement();

            // address VARCHAR(50) NOT NULL
            $table->string('address', 50)->nullable(false);

            // address2 VARCHAR(50) DEFAULT NULL
            $table->string('address2', 50)->nullable()->default(null);

            // district VARCHAR(20) NOT NULL
            $table->string('district', 20)->nullable(false);

            // city_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('city_id')->nullable(false);

            // postal_code VARCHAR(10) DEFAULT NULL
            $table->string('postal_code', 10)->nullable()->default(null);

            // phone VARCHAR(20) NOT NULL
            $table->string('phone', 20)->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (address_id)
            //$table->primary('address_id');

            // KEY idx_fk_city_id (city_id)
            $table->index('city_id', 'idx_fk_city_id');

        });

        Schema::table('address', function (Blueprint $table) {

            // CONSTRAINT `fk_address_city` FOREIGN KEY (city_id) REFERENCES city (city_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('city_id')->references('city_id')->on('city')
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
        Schema::dropIfExists('address');
    }
}
