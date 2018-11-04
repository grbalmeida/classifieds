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
		$sql = $this->pdo->prepare('SELECT id, id_categoria, titulo, descricao, valor, estado, (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url FROM anuncios WHERE id_usuario = :id_usuario');
		$sql->bindValue(':id_usuario', $_SESSION['c_login']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function adicionar(int $id_categoria, string $titulo, float $valor, string $descricao, int $estado) : void
	{
		$sql = $this->pdo->prepare('INSERT INTO anuncios(id_usuario, id_categoria, titulo, valor, descricao, estado) VALUES (:id_usuario, :id_categoria, :titulo, :valor, :descricao, :estado)');
		$sql->bindValue(':id_usuario', $_SESSION['c_login']);
		$sql->bindValue(':id_categoria', $id_categoria);
		$sql->bindValue(':titulo', $titulo);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':estado', $estado);
		$sql->execute();
	}

	public function excluirAnuncio(int $id_anuncio) : void
	{
		$this->excluirImagensAnuncio($id_anuncio);

		$sql = $this->pdo->prepare('DELETE FROM anuncios WHERE id = :id');
		$sql->bindValue(':id', $id_anuncio);
		$sql->execute();
	}

	private function excluirImagensAnuncio(int $id_anuncio) : void
	{
		$sql = $this->pdo->prepare('DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio');
		$sql->bindValue(':id_anuncio', $id_anuncio);
		$sql->execute();
	}
}