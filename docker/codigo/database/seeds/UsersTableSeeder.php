<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model Usuario
        $modelUser = new User();
        $salt = $modelUser->_createSalt();
        $password = Hash::make($this->_criptoSenha($salt,'admin'));
        
        
        //Inserindo perfil de admin        
        DB::table('users')->insert([
            'ativo'=> 1,
            'nome' => 'Administrador',
            'perfil' => 1,            
            'email' => 'admin@teste.local',
            'password' => $password,
        ]);
    }//run
}//Classe 
