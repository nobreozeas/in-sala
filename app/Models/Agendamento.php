<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'id_usuario_criacao',
        'id_usuario_alteracao',
        'id_data_horario',
        'id_horario_agendamento',
        'id_sala',
        'status_agendamento',
        'motivo_cancelamento'
    ];

    public function dataHorario()
    {
        return $this->belongsTo(DataHorario::class, 'id_data_horario');
    }

    public function horarioAgendamento()
    {
        return $this->belongsTo(HorarioAgendamento::class, 'id_horario_agendamento');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
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
