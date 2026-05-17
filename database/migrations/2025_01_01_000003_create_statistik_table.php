<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // penduduk, pendidikan, pekerjaan, agama
            $table->string('label');
            $table->integer('nilai')->default(0);
            $table->string('satuan')->default('jiwa');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik');
    }
};
