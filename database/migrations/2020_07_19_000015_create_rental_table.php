<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental', function (Blueprint $table) {

            // rental_id INT NOT NULL AUTO_INCREMENT
            $table->integer('rental_id')->nullable(false)->autoIncrement();

            // rental_date DATETIME NOT NULL
            $table->dateTime('rental_date')->nullable(false);

            // inventory_id MEDIUMINT UNSIGNED NOT NULL
            $table->unsignedMediumInteger('inventory_id')->nullable(false);

            // customer_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('customer_id')->nullable(false);

            // return_date DATETIME DEFAULT NULL
            $table->dateTime('return_date')->nullable()->default(null);

            // staff_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('staff_id')->nullable(false);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY (rental_id)
            //$table->primary('rental_id');

            // UNIQUE KEY (rental_date,inventory_id,customer_id)
            $table->unique(['rental_date', 'inventory_id', 'customer_id'], 'rental_date');

            // KEY idx_fk_inventory_id (inventory_id)
            $table->index('inventory_id', 'idx_fk_inventory_id');

            // KEY idx_fk_customer_id (customer_id)
            $table->index('customer_id', 'idx_fk_customer_id');

            // KEY idx_fk_staff_id (staff_id)
            $table->index('staff_id', 'idx_fk_staff_id');

        });

        Schema::table('rental', function (Blueprint $table) {

            // CONSTRAINT fk_rental_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('staff_id')->references('staff_id')->on('staff')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_rental_inventory FOREIGN KEY (inventory_id) REFERENCES inventory (inventory_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('inventory_id')->references('inventory_id')->on('inventory')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_rental_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('customer_id')->references('customer_id')->on('customer')
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
        Schema::dropIfExists('rental');
    }
}
