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
        Schema::table('customers', function (Blueprint $table) {
            $table->decimal('total_spent', 10, 2)->default(0)->after('type');
            $table->integer('purchase_count')->default(0)->after('total_spent');
            $table->boolean('is_wholesale')->default(false)->after('purchase_count');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['total_spent', 'purchase_count', 'is_wholesale']);
        });
    }
};
