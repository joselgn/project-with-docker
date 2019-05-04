<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Produto;


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
        $password = Hash::make($modelUser->_criptoSenha($salt,'admin'));
        
        
        //Inserindo perfil de admin        
        DB::table('users')->insert([
            'ativo'=> 1,
            'nome' => 'Administrador',
            'perfil' => 1,            
            'email' => 'admin@teste.local',
            'salt' => $salt,
            'password' => $password,
        ]);
        
        //Inserir alguns Exemplos de Categorias
        //Inserindo perfil de admin        
        //Categoria PAI
        DB::table('categorias')->insert([
            'ativo'=> 1,
            'nome' => 'Casa',
            'tipo' => 1            
        ]);
        //Categoria Filho 1
        DB::table('categorias')->insert([
            'ativo'=> 1,
            'nome' => 'Iluminação',
            'tipo' => 1,
            'id_cat_pai' => 1
        ]);
        //Categoria Filho 2
        DB::table('categorias')->insert([
            'ativo'=> 1,
            'nome' => 'Cozinha',
            'tipo' => 1,
            'id_cat_pai' => 1
        ]);        
        
        //Inserir alguns Exemplos de Produtos
        //Produto 
        DB::table('produtos')->insert([
            'ativo' => 1,
            'nome'  => 'Lâmpada LED',
            'preco' => 23.20,
            'url_imagem' => '1.jpeg'
        ]);
        DB::table('produtos')->insert([
            'ativo' => 1,
            'nome'  => 'Fogão Cooktop',
            'preco' => 400.00,
            'url_imagem' => '2.jpg'
        ]);
        
        //Inserir vínculo entre produto e categoria
        //Lampada - Iluminação
         DB::table('vin_prod_categ')->insert([            
            'id_prod'  => 1,
            'id_categ' => 2
        ]);
         //Fogão - - Cozinha
         DB::table('vin_prod_categ')->insert([            
            'id_prod'  => 2,
            'id_categ' => 3
        ]);
         
        //Inserindo algumas características
        //LED
        DB::table('caracteristicas')->insert([
            'ativo'=> 1,
            'nome' => 'LED'
        ]);
        //Preto
        DB::table('caracteristicas')->insert([
            'ativo'=> 1,
            'nome' => 'Preto'
        ]); 
        
        //Vinculo Característica produto
        //Lampada LED
        DB::table('vin_prod_carac')->insert([
            'id_prod'  => 1,
            'id_carac' => 1
        ]); 
        //Fogão Preto
        DB::table('vin_prod_carac')->insert([
            'id_prod'  => 2,
            'id_carac' => 2
        ]); 
        
        
        
         
        
    }//run
}//Classe 
