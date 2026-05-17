<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();

            // Identitas pengaju
            $table->string('nomor_referensi', 20)->unique(); // contoh: SKD-2025-000001
            $table->string('jenis_surat');                   // domisili | usaha | tidak_mampu | pengantar_ktpkk
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama');
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('no_hp');

            // Keperluan khusus per jenis surat
            $table->string('keperluan')->nullable();          // tujuan/keperluan surat
            $table->string('nama_usaha')->nullable();         // untuk surat usaha
            $table->string('jenis_usaha')->nullable();        // untuk surat usaha
            $table->string('nama_pasangan')->nullable();      // jika ada
            $table->text('keterangan_tambahan')->nullable();

            // Status pengajuan
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();        // alasan ditolak, dll
            $table->timestamp('diproses_at')->nullable();
            $table->timestamp('selesai_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
