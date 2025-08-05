<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penerimas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_sekolah');
            $table->enum('tingkat', ['SD', 'SMP']);
            $table->string('kelas');
            $table->text('alamat');
            $table->string('kode_unik')->unique();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimas');
    }
};
