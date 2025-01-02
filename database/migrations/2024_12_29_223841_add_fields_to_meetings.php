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
        Schema::table('meetings', function (Blueprint $table) {
            $table->text('menu')->nullable();
            $table->text('shopping_list')->nullable();
            $table->text('test_kitchen')->nullable();
            $table->text('samples')->nullable();
            $table->text('recap')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('menu');
            $table->dropColumn('shopping_list');
            $table->dropColumn('test_kitchen');
            $table->dropColumn('samples');
            $table->dropColumn('recap');
        });
    }
};
