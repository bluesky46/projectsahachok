<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // เชื่อมกับ products.id
            $table->integer('quantity');  // จำนวนที่เพิ่ม(บวก)หรือลด(ลบ)
            $table->string('movement_type');  // เช่น 'เข้า', 'ออก', 'คืนสินค้า', 'ปรับปรุง'
            $table->text('note')->nullable();  // หมายเหตุเพิ่มเติม ถ้าต้องการ
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}
