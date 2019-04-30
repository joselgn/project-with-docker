#!/bin/bash
clear

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


$PKG_MANAGER -y update;
$PKG_MANAGER -y install git wget curl;
curl -fsSL https://get.docker.com | sh;
curl -L "https://github.com/docker/compose/releases/download/1.23.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose;
chmod +x /usr/local/bin/docker-compose;
docker-compose --version;

mkdir /home/project; 
cd /home/project; 
git clone https://github.com/joselgn/ApiRestfullLaravel.git .


