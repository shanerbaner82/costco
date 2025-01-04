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
            $table->dateTime('requested_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('follow_up_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_product', function (Blueprint $table) {
            $table->dropColumn('requested_at');
            $table->dropColumn('sent_at');
            $table->dropColumn('follow_up_at');
        });
    }
};
