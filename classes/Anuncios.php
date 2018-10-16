<?php

class Anuncios
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getMeusAnuncios() : array
	{
		$sql = $this->pdo->prepare('SELECT id, id_categoria, titulo, descricao, valor, estados, (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncio.id limit 1) as url FROM anuncios WHERE id_usuario = :id_usuario');
		$sql->bindValue(':id_usuario', $_SESSION['c_login']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
}