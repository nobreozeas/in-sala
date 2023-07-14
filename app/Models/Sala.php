<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'salas';

    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'capacidade',
        'status_sala',
        'comprimento',
        'largura',
        'id_usuario_criacao',
        'id_usuario_alteracao',

    ];
}
