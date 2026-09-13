<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('product_name'); // ตรวจสอบว่ามีคอลัมน์นี้
            $table->string('category');
            $table->string('group');
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->string('seller')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('retail_price', 10, 2)->nullable();
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->string('stock_unit');
            $table->string('sales_unit');
            $table->integer('min_stock')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('products');
    }
};
