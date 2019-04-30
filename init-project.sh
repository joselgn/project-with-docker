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

#Atualizando o Packge Manager
$PKG_MANAGER -y update;
#Instalando dependências necessárias
$PKG_MANAGER -y install git wget curl;
#Instalando o Docker
curl -fsSL https://get.docker.com | sh;
#Instalando o docker-compose
curl -L "https://github.com/docker/compose/releases/download/1.23.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose;
chmod +x /usr/local/bin/docker-compose;
docker-compose --version;
#Permissão ao usuário para o docker
usermod -aG docker $USER;
#Criando pasta de projeto para a aplicação
cd /home/;
#Clonando o Projeto
git clone https://github.com/joselgn/project-with-docker.git project;
cd project;
#DOCKER ========= 
#Criando a imagem da aplicação
cd docker;
docker build -t lojavirtual-img .;
#Executando o docker-compose
docker-compose up -d;
#Configurando aplicação
cd codigo;
#php composer.phar install;
docker container ls;
#Montando a estrutura do BD
docker exec -ti lojavirtual-docker bash;
php artisan migrate;






