<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->unique();
            $table->string('name');
            $table->enum('type', ['ทั่วไป', 'ร้านค้า', 'ช่าง'])->default('ทั่วไป');
            $table->string('phone');
            $table->string('contact_person')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_building')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_subdistrict')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
