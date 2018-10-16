<?php

class Categorias
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getCategorias() : array
	{
		$sql = $this->pdo->query('SELECT id, nome FROM categorias');
		$categorias = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $categorias;
	}
}