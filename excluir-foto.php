<?php

require 'database/config.php';

if(empty($_SESSION['c_login']))
{
	header('Location: login.php');
	exit;
}

require 'classes/Anuncios.php';
$anuncios = new Anuncios($pdo);

if(!empty($_GET['id']))
	$id_anuncio = $anuncios->excluirFoto($_GET['id']);

if(isset($id_anuncio)) 
{
	header('Location: editar-anuncio.php');
}
else 
{
	header('Location: meus-anuncios.php');
}