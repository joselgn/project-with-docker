COMO RODAR O AMBIENTE

ATENÇÃO: Parte-se do princípio de que o docker já se encontra instalado na máquina bem como o git;

INTRODUÇÃO:
    A aplicação se trata de uma loja virtual sem a utilização do e-commerce, esta loja está utilizando o Framework Laravel (PHP) bem como o banco de dados MariaDB (MYSQL), tabém está sendo utilizado nesta aplicação jQuery e Jqwidgets para JavaScript, para o layout foi utilizado o bootstrap (css)

1 - Ir até ao diretório que deseja colocar a aplicação.
2 - Usar o git para clonar o projeto: git clone https://github.com/joselgn/lojavirtual.git
3 - Após o clone da aplicação, executar o docker compose para criação dos containers: docker-compose up -d
4 - Assim que finalizado a criação dos containers verificar se eles estão ativos e online: docker ps
5 - Deverão aparecer os seguintes container ativos "lojavirtual" e "mariaDB". Caso os containers não tenham subido executar o comando: docker-compose start
6 - Nesse ponto com os containers prontos e online, precisamos agora configurar a base de dados, para isso, pode ser utilizando SGBD de sua preferência:
		6.1 - Credenciais ~> Host: localhost / Usuario: root / senha: root
		6.2 - Caso o item 6.1 falhe, acessar o container com o comando: docker exec -ti mariaDB bash
		6.3 - Atualizar instaladores do pacote: apt-get update && apt-get install net-tools
		6.4 - Pegar o IP vinculado ao container: ifconfig
		6.5 - Tentar acessar com as seguintes credenciais: Host: IP_Container / Usuario: root / senha: root
7 - Criar o seguinte banco de dados "lojavirtualdb" ou executar o script: CREATE DATABASE lojavirtualdb;
8 - Acessar o container da aplicação: docker exec -ti lojavirtual bash
9 - Atualizar os pacotes instaladores: apt-get update
10 - Instalar as extensões php docker-php-ext-install pdo pdo_mysql
11 - Instalar o git: apt-get install git
12 - Acessar a pasta da aplicação: cd /var/www/html
13 - Instalar o composer da aplicação: php composer.phar install
14 - Reiniciar o apache: service apache2 restart
15 - Subir o container novamente: docker start lojavirtual
16 - Entrar no container na pasta da aplicação e utilizar o migration do laravel para criar a estrutura do BD: php artisan migrate
16 - Ainda na pasta da aplicação renomear o arquivo ".env.example" para ".env" e configurar com os dados adquiridos nos passos anteriores a conexão com o banco de dados.
17 - Na pasta da aplicação devemos gerar a key do Laravel: php artisan key:generate
18 - nesse momento a aplicação deverá estar funcionando e para acessar basta ir no browser e acessar pelo seguinte endereço: http://localhost:80/public/index.php
19 - Para criar o primeiro perfil de acesso vá em cadastrar e em seguida altere no BD tabela users a flag "perfil" de 2 (usuário) para 1 (administrador);

Agora só testar a aplicação.




