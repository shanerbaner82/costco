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
        Schema::table('meeting_product', function (Blueprint $table) {
            $table->boolean('requested')->default(false);
            $table->boolean('sent')->default(false);
            $table->boolean('follow_up')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_product', function (Blueprint $table) {
            $table->dropColumn('requested');
            $table->dropColumn('sent');
            $table->dropColumn('follow_up');
        });
    }
};
