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
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_alteracao')->nullable();
            $table->string('nome', 100);
            $table->text('descricao', 255);
            $table->string('imagem', 255);
            $table->float('largura');
            $table->float('comprimento');
            $table->string('capacidade');
            $table->enum('status_sala', [1, 2])->default(1)->comment('1 - Ativo, 2 - Inativo');
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
        Schema::dropIfExists('salas');
    }
};
