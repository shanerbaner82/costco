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
        Schema::create('buyer_meeting', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Buyer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Meeting::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_meeting');
    }
};
