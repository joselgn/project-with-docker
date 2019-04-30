@extends('welcome')
@extends('slide-produtos') <!--Extende Layout de ultimos produtos cadastrados -->

<?php
    if($perfil==1){
        $menulateral =  'menu-lateral-admin';
        $conteudo    =  'admin';
    }else{
        $menulateral = 'menu-lateral';
        $conteudo = 'produtos';
    }
?>

@extends($menulateral)
@extends($conteudo)
