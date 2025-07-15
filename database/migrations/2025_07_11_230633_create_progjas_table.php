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
        Schema::create('progjas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nama_progja');
            $table->date('tanggal_pelaksanaan');
            $table->string('sasaran');
            $table->text('hasil')->nullable();
            $table->text('indikator')->nullable();
            $table->string('penanggung_jawab');
            $table->string('kategori');
            $table->integer('anggaran');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progjas');
    }
};
