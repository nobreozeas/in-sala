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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sala');
            $table->unsignedBigInteger('id_data_horario');
            $table->unsignedBigInteger('id_horario_inicio');
            $table->unsignedBigInteger('id_horario_fim');
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_alteracao')->nullable();
            $table->enum('status_agendamento', [1, 2])->default(1)->comment('1 - Ativo, 2 - Inativo');
            $table->foreign('id_sala')->references('id')->on('salas');
            $table->foreign('id_data_horario')->references('id')->on('datas_horarios');
            $table->foreign('id_horario_inicio')->references('id')->on('horarios_agendamentos');
            $table->foreign('id_horario_fim')->references('id')->on('horarios_agendamentos');
            $table->foreign('id_usuario_criacao')->references('id')->on('users');
            $table->foreign('id_usuario_alteracao')->references('id')->on('users');
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
        Schema::dropIfExists('agendamentos');
    }
};
