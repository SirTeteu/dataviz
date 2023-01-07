<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefugiadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refugiados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fundamentacao');
            $table->string('sexo');
            $table->string('idade');
            $table->string('pais');
            $table->string('tipo_processo');
            $table->string('ano_inicio');
            $table->string('ano_decisao');

            $table->unsignedInteger('estado_codigo');
            $table->foreign('estado_codigo')->references('codigo')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refugiados');
    }
}
