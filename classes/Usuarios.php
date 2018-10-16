<?php

class Usuarios
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function cadastrar(string $nome, string $email, string $senha, string $telefone) : void
	{
		$sql = $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha, telefone) VALUES (?, ?, ?, ?)');
		$sql->execute([$nome, $email, $senha, $telefone]);
	}

	public function emailJaEstaCadastrado(string $email) : bool
	{
		$sql = $this->pdo->prepare('SELECT COUNT(email) AS count FROM usuarios WHERE email = :email');
		$sql->bindValue(':email', $email);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);

		if($dados['count'] == 0)
		{
			return false;
		}

		return true;
	}

	public function login(string $email, string $senha) : bool
	{
		$sql = $this->pdo->prepare('SELECT id FROM usuarios WHERE email = ? AND senha = ?');
		$sql->execute([$email, $senha]);

		if($sql->rowCount() > 0)
		{
			$dado = $sql->fetch(PDO::FETCH_ASSOC);
			$_SESSION['c_login'] = $dado['id'];
			return true;
		}
		return false;
	}
}