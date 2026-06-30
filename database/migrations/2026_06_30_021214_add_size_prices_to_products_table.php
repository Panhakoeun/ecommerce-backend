<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_s', 10, 2)->default(0)->after('price');
            $table->decimal('price_m', 10, 2)->default(0)->after('price_s');
            $table->decimal('price_l', 10, 2)->default(0)->after('price_m');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_s', 'price_m', 'price_l']);
        });
    }
};
