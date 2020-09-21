<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {

            // payment_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedSmallInteger('payment_id')->nullable(false)->autoIncrement();

            // customer_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('customer_id')->nullable(false);

            // staff_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('staff_id')->nullable(false);

            // rental_id INT DEFAULT NULL
            $table->integer('rental_id')->nullable()->default(null);

            // amount DECIMAL(5,2) NOT NULL
            $table->decimal('amount', 5, 2)->nullable(false);

            // payment_date DATETIME NOT NULL
            $table->dateTime('payment_date')->nullable(false);

            // last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->useCurrent();

            // PRIMARY KEY  (payment_id)
            //$table->primary('payment_id');

            // KEY idx_fk_staff_id (staff_id)
            $table->index('staff_id', 'idx_fk_staff_id');

            // KEY idx_fk_customer_id (customer_id)
            $table->index('customer_id', 'idx_fk_customer_id');

        });

        Schema::table('payment', function (Blueprint $table) {

            // CONSTRAINT fk_payment_rental FOREIGN KEY (rental_id) REFERENCES rental (rental_id) ON DELETE SET NULL ON UPDATE CASCADE
            $table->foreign('rental_id')->references('rental_id')->on('rental')
            ->onDelete('set null')->onUpdate('cascade');

            // CONSTRAINT fk_payment_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id) ON DELETE RESTRICT ON UPDATE CASCADE,
            $table->foreign('customer_id')->references('customer_id')->on('customer')
            ->onDelete('restrict')->onUpdate('cascade');

            // CONSTRAINT fk_payment_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('staff_id')->references('staff_id')->on('staff')
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
        Schema::dropIfExists('payment');
    }
}
