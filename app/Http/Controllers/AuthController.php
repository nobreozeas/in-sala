<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {

        if (Auth::check() === true) {

            return view('index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {

        $regras = [
            'email' => 'required',
            'password' => 'required'
        ];

        $feedback = [
            'email.required' => 'O campo email é obrigatório',
            'password.required' => 'O campo senha é obrigatório'
        ];

        $request->validate($regras, $feedback);

        $user = User::where('email', $request->email)
        ->first();

        if (isset($user) && Hash::check($request->password, $user->password)) {

            $dados = [];
            $dados['usuario']['id'] = $user->id;
            $dados['usuario']['nome'] = $user->nome;
            $dados['usuario']['email'] = $user->email;
            $dados['usuario']['permissao'] = $user->id_permissao;

            session([
                'user' => $dados['usuario'],
            ]);


            Auth::login($user);


            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors([
                'msgErro' => 'Email ou senha inválidos'
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session([
            'user' => null
        ]);
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
