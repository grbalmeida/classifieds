<?php

require 'database/config.php';
require 'classes/Anuncios.php';

if(empty($_SESSION['c_login']))
{
	header('Location: index.php');
	exit;
}

if(empty($_POST['id_anuncio']))
{
	header('Location: meus-anuncios.php');
	exit;
}

$anuncios = new Anuncios($pdo);
$id_anuncio = $_POST['id_anuncio'];
$anuncios->excluirAnuncio($id_anuncio);

$_SESSION['anuncio_excluido'] = $id_anuncio;
header('Location: meus-anuncios.php');
exit;