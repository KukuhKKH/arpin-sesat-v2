<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_overheads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->text('description');
            $table->char('type', 1)->comment('1: Tetap; 2: Variabel');
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
        Schema::dropIfExists('overheads');
    }
}
