<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_alteracao')->nullable();
            $table->unsignedBigInteger('id_data_horario');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->enum('status_horarios_agendamentos', [1, 2])->default(1)->comment('1 - Disponível, 2 - Indisponível');
            $table->foreign('id_usuario_criacao')->references('id')->on('users');
            $table->foreign('id_usuario_alteracao')->references('id')->on('users');
            $table->foreign('id_data_horario')->references('id')->on('datas_horarios');
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
        Schema::dropIfExists('horarios_agendamentos');
    }
};
