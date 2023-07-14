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
        Schema::create('datas_horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_alteracao')->nullable();
            $table->unsignedBigInteger('id_sala');
            $table->date('data');
            $table->enum('status_datas_horarios', [1, 2])->default(1)->comment('1 - Disponível, 2 - Indisponível');
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
        Schema::dropIfExists('datas_horarios');
    }
};
