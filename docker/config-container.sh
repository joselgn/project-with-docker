#!/bin/bash
#Limpando bash
clear
php composer.phar install;
php artisan migrate;
exit;
