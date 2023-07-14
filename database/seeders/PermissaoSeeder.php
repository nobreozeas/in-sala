<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = [
            [
                "nome" => "Administrador"
            ],
            [
                "nome" => "Usuário"
            ],
        ];

        foreach ($permissoes as $permissao) {
            Permissao::create($permissao);
        }
    }
}
