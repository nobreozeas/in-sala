<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioAgendamento extends Model
{
    use HasFactory;

    protected $table = 'horarios_agendamentos';

    protected $fillable = [
        'id_usuario_criacao',
        'id_usuario_alteracao',
        'id_data_horario',
        'horario_inicio',
        'horario_fim',
        'status_horarios_agendamentos',
    ];

    public function dataHorario()
    {
        return $this->belongsTo(DataHorario::class, 'id_data_horario');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_horario_agendamento');
    }

    public function usuarioCriacao()
    {
        return $this->belongsTo(User::class, 'id_usuario_criacao');
    }

    public function usuarioAlteracao()
    {
        return $this->belongsTo(User::class, 'id_usuario_alteracao');
    }




}
