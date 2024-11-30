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
        Schema::create('meeting_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Meeting::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('meeting_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Meeting::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Vendor::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_product');
        Schema::dropIfExists('meeting_vendor');
    }
};
