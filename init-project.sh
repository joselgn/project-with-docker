#!/bin/bash
#Limpando bash
clear

#Verificando o Package Manager do SO
if [ -f "/etc/redhat-release" ];then
   PKG_MANAGER=yum
fi
if [ -f "/etc/arch-release" ];then
  PKG_MANAGER=pacman
fi
if [ -f "/etc/gentoo-release" ];then
  PKG_MANAGER=emerge
fi
if [ -f "/etc/SuSE-release" ];then
  PKG_MANAGER=zypp
fi
if [ -f "/etc/debian_version" ];then
  PKG_MANAGER=apt-get
fi


echo "\n\n ================ Updating package manager =============================";
#Atualizando o Packge Manager
$PKG_MANAGER -y update;

echo "\n\n ================ Installing basic packs and git =============================";
#Instalando dependências necessárias
$PKG_MANAGER -y install git wget curl vim;

#Verificando o IP local
IP_LOCAL=$(ip route get 8.8.8.8 | head -1 | awk '{print $7}');
PORT_LOCAL_APP=8081;
PORT_LOCAL_BD=3306;

echo "\n\n ================ Installing docker =============================";
#Instalando o Docker
curl -fsSL https://get.docker.com | sh;

#Instalando o docker-compose
echo "\n\n ================ Installing docker-compose =============================";
if [ $PKG_MANAGER==yum ]; then
    echo "YUM install docker-compose\n";
    $PKG_MANAGER install -y epel-release;
    $PKG_MANAGER install -y python-pip;	
    pip install docker-compose;
	pip install --upgrade pip;
	systemctl enable docker.service;
	systemctl start docker.service;
else
    echo "PKG Managar : $PKG_MANAGER Installing docker-compose";
    curl -L "https://github.com/docker/compose/releases/download/1.23.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose;
    chmod +x /usr/local/bin/docker-compose;
fi

docker-compose --version;
echo "\n\n ================ docker-compose End Install =============================";
#Permissão ao usuário para o docker
usermod -aG docker $USER;
#Criando pasta de projeto para a aplicação
cd /home/;

echo "\n\n ================ Cloning the project into '/home/project' =============================";
#Clonando o Projeto
git clone https://github.com/joselgn/project-with-docker.git project;
cd project;
#DOCKER ========= 
cd docker;

echo "\n\n ================ Setting up the application =============================";
#Configurando aplicação
cd codigo;
#Substituindo variáveis no arquivo
touch .env;
while read line
do
    eval echo "$line">> .env 
done < "./.env.example";
#Criando a imagem da aplicação
cd ../;

echo "\n\n ================ Creating app image from Dockerfile =============================";
docker build -t lojavirtual-img .; 

echo "\n\n ================ Setting up the containers =============================";
#Executando o docker-compose
docker-compose up -d;
#Permissao storage 
chmod -R 777 codigo;
#Executando comandos de configuração da aplicação
docker exec -ti lojavirtual-docker sh -c "chmod -Rf 777 /var/www/html/storage && chown -Rf apache:root /var/www/html/storage";
docker exec -ti lojavirtual-docker sh -c "cd /var/www/html && php composer.phar update";
docker exec -ti lojavirtual-docker sh -c "cd /var/www/html && php artisan key:generate && php artisan config:cache";
#Restaurando BD de teste
cd mariadb/bd;
docker exec -ti mariaDB sh -c "mysql --user=root --password=root --execute='create database lojavirtualdb'";
#docker exec -ti mariaDB sh -c "cd /home/bd && /usr/bin/mysql --user=root --password=root lojavirtualdb < lojavirtualdb.sql";
#cat lojavirtualdb.sql | docker exec -i mariaDB /usr/bin/mysql -u root --password=root lojavirtualdb;
#docker exec -ti mariaDB sh -c "cd /home/bd && mysql -u root --password=root --database=lojavirtualdb < lojavirtualdb.sql"
docker exec -ti lojavirtual-docker sh -c "cd /var/www/html && php artisan migrate";
docker exec -ti lojavirtual-docker sh -c "cd /var/www/html && php artisan db:seed --class=UsersTableSeeder";

#Visualizando containers ativos
echo "\n\n\n\n\n :::Containers ativos::: \n\n";
echo "\n\n ================ Active containers =============================";
docker container ls;
echo "\n\n>>>>>>>>>>>>>>>>>>>>>>> Fim do Script <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n
      Acesse o navegador no seguinte endereço http://$IP_LOCAL:8081/public/index.php \n\n
	  Thank you for contributing with me !!!! \n\n
      >>>>>>>>>>>>>>>>>>>>>>>>>>>xxxxxxxxxxxxxxx<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<";
exit;