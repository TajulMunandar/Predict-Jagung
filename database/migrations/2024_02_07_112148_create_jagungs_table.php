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
        Schema::create('jagungs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan')->constrained('kecamatans')->onUpdate('cascade')->onDelete('restrict');
            $table->double('areaLahan');
            $table->double('areaPanen');
            $table->year('priode');
            $table->double('totalProduktivitas');
            $table->double('totalProduksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jagungs');
    }
};
