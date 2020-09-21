<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            
            // store_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedTinyInteger('store_id')->nullable(false)->autoIncrement();

            // manager_staff_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('manager_staff_id')->nullable(false);

            //address_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('address_id')->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (store_id)
            //$table->primary('store_id');

            // UNIQUE KEY idx_unique_manager (manager_staff_id)
            $table->unique('manager_staff_id', 'idx_unique_manager');

            // KEY idx_fk_address_id (address_id)
            $table->index('address_id', 'idx_fk_address_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
}
