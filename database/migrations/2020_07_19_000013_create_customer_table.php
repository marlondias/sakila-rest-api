<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {

            // customer_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('customer_id')->nullable(false)->autoIncrement();

            // store_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('store_id')->nullable(false);

            // first_name VARCHAR(45) NOT NULL
            $table->string('first_name', 45)->nullable(false);

            // last_name VARCHAR(45) NOT NULL
            $table->string('last_name', 45)->nullable(false);

            // email VARCHAR(50) DEFAULT NULL
            $table->string('email', 50)->nullable()->default(null);

            // address_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('address_id')->nullable(false);

            // active BOOLEAN NOT NULL DEFAULT TRUE
            $table->boolean('active')->nullable(false)->default(true);

            // create_date DATETIME NOT NULL
            $table->dateTime('create_date')->nullable(false);

            // last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (customer_id)
            //$table->primary('customer_id');

            // KEY idx_fk_store_id (store_id)
            $table->index('store_id', 'idx_fk_store_id');

            // KEY idx_fk_address_id (address_id)
            $table->index('address_id', 'idx_fk_address_id');

            // KEY idx_last_name (last_name)
            $table->index('last_name', 'idx_last_name');

        });

        Schema::table('customer', function (Blueprint $table) {

            // CONSTRAINT fk_customer_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON DELETE RESTRICT ON UPDATE CASCADE,
            $table->foreign('address_id')->references('address_id')->on('address')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_customer_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('store_id')->references('store_id')->on('store')
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
        Schema::dropIfExists('customer');
    }
}
