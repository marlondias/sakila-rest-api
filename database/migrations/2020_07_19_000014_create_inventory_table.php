<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {

            // inventory_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedMediumInteger('inventory_id')->nullable(false)->autoIncrement();

            // film_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('film_id')->nullable(false);

            // store_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('store_id')->nullable(false);

            // last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (inventory_id)
            //$table->primary('inventory_id');

            // KEY idx_fk_film_id (film_id)
            $table->index('film_id', 'idx_fk_film_id');

            // KEY idx_store_id_film_id (store_id,film_id)
            $table->index(['store_id', 'film_id'], 'idx_store_id_film_id');

        });

        Schema::table('inventory', function (Blueprint $table) {

            // CONSTRAINT fk_inventory_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('store_id')->references('store_id')->on('store')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_inventory_film FOREIGN KEY (film_id) REFERENCES film (film_id) ON DELETE RESTRICT ON UPDATE CASCADE
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
        Schema::dropIfExists('inventory');
    }
}
