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
    // public function up()
    // {
    //     Schema::create('sell_data', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('order_id'); // Reference to orders table
    //         $table->decimal('total_amount', 10, 2);
    //         $table->dateTime('sale_date')->default(now());
    //         $table->timestamps();
    //     });
    // }

    public function down()
    {
        Schema::dropIfExists('sell_data');
    }
};

