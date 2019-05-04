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
            'tipo' => 2,
            'id_cat_pai' => 1
        ]);
        //Categoria Filho 2
        DB::table('categorias')->insert([
            'ativo'=> 1,
            'nome' => 'Cozinha',
            'tipo' => 2,
            'id_cat_pai' => 1
        ]);        
        
        //Inserir alguns Exemplos de Produtos
        //Produto 
        DB::table('produtos')->insert([
            'ativo' => 1,
            'nome'  => 'Lâmpada LED',
            'preco' => 23.20,
            'url_imagem' => '1.jpeg',
            'descricao' => 'Lâmpada luz contínua Fria 150w 220V ou 110V ( escolher ) , ideal para softbox. Especificação:Lampada Fluorescente Compac150w 5500k Equivale A Comum De 430w Conector E27!Itens Inclusos: 1-Lâmpada 5500k 150w Fluorescente 110 ou 220 escolher temos as duas.'
        ]);
        DB::table('produtos')->insert([
            'ativo' => 1,
            'nome'  => 'Fogão Cooktop',
            'preco' => 400.00,
            'url_imagem' => '2.jpg',
            'descricao' => 'Com um design robusto e uma linda mesa em vidro temperado, O Cooktop V500X da Fogatti vai proporcionar beleza e praticidade em sua cozinha. Com queimadores de última geração, que gastam menos tempo na preparação dos alimentos, podendo regular para cada tipo de prato, possibilitando uma sensível economia no consumo de gás. São tamanhos diferentes com seleções de potência divididas em Ultrarrápido, Rápido e Semirrápido. Em aço esmaltado os queimadores e suas grades tornam a limpeza mais fácil e rápida. Para sempre oferecer o melhor a você e a para a sua cozinha, os Cooktop são de alta qualidade, confiabilidade e sofisticação. Características do produto: - Marca: Fogatti; - Flange: Inox;- Acendimento: Automático;- Classificação Eficiência Energética: A;- Conjunto de Borracha: Sim;- Consumo: 0,142 KWh;- Dimensões da Embalagem: 735x170x510 (LxAxP em MM);- Dimensões do Nicho: 605x55x340 (LxAxP em MM);- Dimensões do Produto: 685x460 (LxP em MM);- Etiqueta INMETRO: Sim;- Exclusivo Pinos Anti-rotação Nas Trempes: Sim;- Frequência: 60 Hz;- Manípulos Removíveis: Sim;- Manual do Produto: img/2018/12/produto/4834/cooktop-new-order.pdf;- Mesa: Vidro Temperado De 6mm;- Potência: 6,3 W (127V); 10,5 W (220V);- Potência dos Queimadores: Semirrápido: 1.750W; Rápido: 3.000W;- Pressão do Gás: 28 a 37 mBar;- Sistema de Combustão: Italiano;- Sistema de Encaixe Exclusivo das Grades: Sim;- Tipo de Gás: GLP;- Tipo De Queimadores: 02 Queimadores Rápidos; 03 Queimadores Semirrápidos; Garantia: 12 Meses. Todos os nossos produtos são novos e originais, acompanham nota fiscal, que é enviada juntamente com a sua compra. O envio do produto será feito no prazo de até 15 dias úteis após a confirmação de pagamento.'
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
