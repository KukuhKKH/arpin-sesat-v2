<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_materials', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Kode');
            $table->string('name')->comment('Nama');
            $table->string('unit')->comment('Satuan');
            $table->string('total')->comment('Total Barang Sekarang');
            $table->string('price')->comment('Harga');
            $table->char('type', 1)->comment('1: Bahan Baku; 2: Bahan Penolong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
