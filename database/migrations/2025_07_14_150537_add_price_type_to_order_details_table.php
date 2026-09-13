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
    public function up(): void
{
    Schema::table('order_details', function (Blueprint $table) {
        $table->string('price_type')->after('unit_price')->default('retail_price'); // หรือ nullable ก็ได้
    });
}

public function down(): void
{
    Schema::table('order_details', function (Blueprint $table) {
        $table->dropColumn('price_type');
    });
}

};
