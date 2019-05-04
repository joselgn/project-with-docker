COMO RODAR O AMBIENTE

*** Caso esteja utilizando linux RPM (CentOS, Rhel) ou DEBIAN (Ubuntu, Elementary OS) existe um script de bash do linux chamado "init-project.sh" que fará todo o passo-a-passo para que o ambiente seja montado e configurado e no término do script aparecerá um link para que possa acessar a aplicação do seu computador.


INTRODUÇÃO:
	A aplicação se trata de uma loja virtual sem a utilização do e-commerce, esta loja está utilizando o Framework Laravel (PHP) bem como o banco de dados MariaDB (MYSQL), tabém está sendo utilizado nesta aplicação jQuery e Jqwidgets para JavaScript, para o layout foi utilizado o bootstrap (css)
	Detalhes da aplicação:
		-> Aplicação em container com  Docker;
		-> Banco de dados em container com Docker;
		-> Container da aplicação separada do container de banco de dados;
		



A) Para distribuição Linux:
    1 - Caso esteja utilizando distribuição linux execute o arquivo "init-project.sh" em modo root:~> sudo sh init-project.sh;
    2 - Para baixar o arquivo "init-project.sh" basta utilizar o wget:~> wget https://raw.githubusercontent.com/joselgn/project-with-docker/master/init-project.sh
		*** Caso não possua o wget instalado, faça o download do arquivo pelo browser.
    3 - Perfil de acesso. inicialmente o perfil de acesso disponibilizado é o de administrador:~> email: admin@teste.local   senha: admin

// ==================================================================================================================================================================== \\

B) Caso a opção "A" não seja possível:


  [ Em Breve descrição disponível ]

Agora só testar a aplicação.




