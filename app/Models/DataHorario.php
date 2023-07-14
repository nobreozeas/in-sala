<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHorario extends Model
{
    use HasFactory;

    protected $table = 'datas_horarios';

    protected $fillable = [
        'id_usuario_criacao',
        'id_usuario_alteracao',
        'data',
        'id_sala',
        'status_datas_horarios',
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
    }

    public function horarios()
    {
        return $this->hasMany(HorarioAgendamento::class, 'id_data_horario');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_data_horario');
    }
    


}
