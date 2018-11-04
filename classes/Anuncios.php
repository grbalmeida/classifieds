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
		$query = 'SELECT id, id_categoria, titulo, descricao, valor, 
			estado, (select anuncios_imagens.url from anuncios_imagens where 
			anuncios_imagens.id_anuncio = anuncios.id limit 1) as url FROM anuncios 
			WHERE id_usuario = :id_usuario';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':id_usuario', $_SESSION['c_login']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function adicionar(int $id_categoria, string $titulo, float $valor, 
		string $descricao, int $estado) : void
	{
		$query = 'INSERT INTO anuncios(id_usuario, id_categoria, 
			titulo, valor, descricao, estado) VALUES (:id_usuario, :id_categoria, 
			:titulo, :valor, :descricao, :estado)';
		$sql = $this->pdo->prepare($query);
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
		$query = 'DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':id_anuncio', $id_anuncio);
		$sql->execute();
	}

	public function getAnuncio(int $id_anuncio) : array
	{
		$anuncio = [];
		$id_usuario = $_SESSION['c_login'];
		$query = 'SELECT id_categoria, titulo, descricao, valor, estado FROM 
		anuncios WHERE id = :id_anuncio AND id_usuario = :id_usuario';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':id_anuncio', $id_anuncio);
		$sql->bindValue(':id_usuario', $id_usuario);
		$sql->execute();

		if($sql->rowCount() > 0) 
		{
			$anuncio[] = $sql->fetch(PDO::FETCH_ASSOC);
		}
		return $anuncio;
	}

	public function editar(int $id_anuncio, int $id_categoria, string $titulo, 
		$valor, string $descricao, int $estado) : void
	{
		$id_usuario = $_SESSION['c_login'];
		$query = 'UPDATE anuncios SET titulo = :titulo, id_categoria = :id_categoria, 
		descricao = :descricao, valor = :valor, estado = :estado WHERE id = 
		:id_anuncio AND id_usuario = :id_usuario';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':titulo', $titulo);
		$sql->bindValue(':id_categoria', $id_categoria);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':estado', $estado);
		$sql->bindValue(':id_anuncio', $id_anuncio);
		$sql->bindValue(':id_usuario', $id_usuario);
		$sql->execute();
	}
}