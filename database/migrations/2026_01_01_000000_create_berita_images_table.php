<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('berita')->cascadeOnDelete();
            $table->string('foto');
            $table->boolean('is_utama')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_images');
    }
};
