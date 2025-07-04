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
        Schema::create('shopee_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id')->unique();
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamp('expires_at'); // kapan token habis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopee_tokens');
    }
};
