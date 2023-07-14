<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HorarioAgendamentoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login');
Route::get('/registrar', [UserController::class,'registrar'])->name('registrar');
Route::post('/registrar', [UserController::class,'salvar'])->name('salvar');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

Route::prefix('/')->middleware('auth')->group(function(){

    Route::get('/', function () {
        return view('index');
    })->name('home');

    Route::prefix('agendamentos')->group(function(){
        Route::get('/', [AgendamentoController::class,'index'])->name('agendamentos.index');
        Route::get('/cadastrar', [AgendamentoController::class,'cadastrar'])->name('agendamentos.cadastrar');
        Route::post('/salvar', [AgendamentoController::class,'salvar'])->name('agendamentos.salvar');
        Route::get('/excluir/{id}', [AgendamentoController::class,'excluir'])->name('agendamentos.excluir');
        Route::post('/listar', [AgendamentoController::class,'listar'])->name('agendamentos.listar');
        Route::get('/cancelar/{id}', [AgendamentoController::class,'cancelar'])->name('agendamentos.cancelar');
        Route::get('/visualizar/{id}', [AgendamentoController::class,'visualizar'])->name('agendamentos.visualizar');
    });

    Route::prefix('salas')->group(function(){
        Route::get('/', [SalaController::class,'index'])->name('salas.index');
        Route::get('/cadastrar', [SalaController::class,'cadastrar'])->name('salas.cadastrar');
        Route::post('/salvar', [SalaController::class,'salvar'])->name('salas.salvar');
        Route::get('/editar/{id}', [SalaController::class,'editar'])->name('salas.editar');
        Route::post('/atualizar/{id}', [SalaController::class,'atualizar'])->name('salas.atualizar');
        Route::get('/deletar/{id}', [SalaController::class,'deletar'])->name('salas.deletar');
        Route::post('/listar', [SalaController::class,'listar'])->name('salas.listar');


    });

    Route::prefix('horarios')->group(function(){
        Route::get('/', [HorarioAgendamentoController::class,'index'])->name('horarios.index');
        Route::get('/cadastrar', [HorarioAgendamentoController::class,'cadastrar'])->name('horarios.cadastrar');
        Route::post('/salvar', [HorarioAgendamentoController::class,'salvar'])->name('horarios.salvar');
        Route::get('/editar/{id}', [HorarioAgendamentoController::class,'editar'])->name('horarios.editar');
        Route::post('/atualizar/{id}', [HorarioAgendamentoController::class,'atualizar'])->name('horarios.atualizar');
        Route::get('/excluir/{id}', [HorarioAgendamentoController::class,'excluir'])->name('horarios.excluir');
        Route::post('/listar', [HorarioAgendamentoController::class,'listar'])->name('horarios.listar');
        Route::post('/consultar-datas', [HorarioAgendamentoController::class,'consultaData'])->name('horarios.consultaData');
    });

    Route::prefix('usuarios')->group(function(){
        Route::get('/', [UserController::class,'index'])->name('usuarios.index');
        Route::get('/cadastrar', [UserController::class,'cadastrar'])->name('usuarios.cadastrar');
        Route::post('/salvar', [UserController::class,'salvar'])->name('usuarios.salvar');
        Route::get('/editar/{id}', [UserController::class,'editar'])->name('usuarios.editar');
        Route::post('/atualizar/{id}', [UserController::class,'atualizar'])->name('usuarios.atualizar');
        Route::get('/excluir/{id}', [UserController::class,'excluir'])->name('usuarios.excluir');
    });

});

