<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function registrar()
    {
        return view('auth.registrar');
    }

    public function salvar(Request $request)
    {

        try {
            DB::beginTransaction();
            
            $user = User::where('email', $request->email)->first();

            if ($user) {
                throw new \Exception('Email já cadastrado');
            }

            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_permissao' => 2
            ]);

            DB::commit();

            if ($user) {
                return redirect()->route('login')->with([
                    'msgSucesso' => 'Usuário cadastrado com sucesso'
                ]);
            } else {
                throw new \Exception('Erro ao cadastrar usuário');
            }
        } catch (\Exception $e) {
            return redirect()->route('registrar')->withErrors([
                'msgErro' => $e->getMessage()
            ])->withInput();
        }
    }
}
