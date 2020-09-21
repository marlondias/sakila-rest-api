<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {

            // staff_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->unsignedTinyInteger('staff_id')->nullable(false)->autoIncrement();

            // first_name VARCHAR(45) NOT NULL
            $table->string('first_name', 45)->nullable(false);

            // last_name VARCHAR(45) NOT NULL
            $table->string('last_name', 45)->nullable(false);

            // address_id SMALLINT UNSIGNED NOT NULL
            $table->unsignedSmallInteger('address_id')->nullable(false);

            // picture BLOB DEFAULT NULL
            $table->binary('picture')->nullable()->default(null);

            // email VARCHAR(50) DEFAULT NULL
            $table->string('email', 50)->nullable()->default(null);

            // store_id TINYINT UNSIGNED NOT NULL
            $table->unsignedTinyInteger('store_id')->nullable(false);

            // active BOOLEAN NOT NULL DEFAULT TRUE
            $table->boolean('active')->nullable(false)->default(true);

            // username VARCHAR(16) NOT NULL
            $table->string('username', 16)->nullable(false);

            // password VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
            $table->string('password', 40)->collation('utf8mb4_bin')
            ->nullable()->default(null);

            // last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('last_update')->nullable(false)->useCurrent();

            // PRIMARY KEY  (staff_id)
            //$table->primary('staff_id');

            //KEY idx_fk_store_id (store_id)
            $table->index('store_id', 'idx_fk_store_id');

            // KEY idx_fk_address_id (address_id)
            $table->index('address_id', 'idx_fk_address_id');

        });

        Schema::table('staff', function (Blueprint $table) {

            //CONSTRAINT fk_staff_store FOREIGN KEY (store_id) REFERENCES store (store_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('store_id')->references('store_id')->on('store')
            ->onDelete('restrict')->onUpdate('cascade');

            //CONSTRAINT fk_staff_address FOREIGN KEY (address_id) REFERENCES address (address_id) ON DELETE RESTRICT ON UPDATE CASCADE
            $table->foreign('address_id')->references('address_id')->on('address')
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
        Schema::dropIfExists('staff');
    }
}
