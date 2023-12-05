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
        Schema::create('ibadah_user', function (Blueprint $table) {
            $table->unsignedBigInteger('ibadah_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(['ibadah_id', 'user_id']);

            $table->foreign('ibadah_id')->references('id')->on('ibadahs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibadah_user');
    }
};
