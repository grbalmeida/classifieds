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
			$anuncio = $sql->fetch(PDO::FETCH_ASSOC);
			$anuncio['fotos'] = [];
			$query = 'SELECT id, url FROM anuncios_imagens WHERE id_anuncio = :id_anuncio';
			$sql = $this->pdo->prepare($query);
			$sql->bindValue(':id_anuncio', $id_anuncio);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				$anuncio['fotos'] = $sql->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		return $anuncio;
	}

	public function editar(int $id_anuncio, int $id_categoria, string $titulo, 
		$valor, string $descricao, int $estado, array $fotos) : void
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

		if(count($fotos) > 0)
		{
			for($cont = 0; $cont < count($fotos['tmp_name']); $cont++)
			{
				$tipo = $fotos['type'][$cont];
				if(in_array($tipo, ['image/jpeg', 'image/png']))
				{
					$nome_arquivo = md5(time().rand(0, 99999)).'.jpg';
					$caminho = ''.$nome_arquivo;
					move_uploaded_file($fotos['tmp_name'][$cont], $caminho);
					list($largura_original, $altura_original) = getimagesize($caminho);
					$ratio = $largura_original / $altura_original;
					$largura = 500;
					$altura = 500;

					if($largura / $altura > $ratio)
						$largura = $altura * $ratio;
					else
						$altura = $largura / $ratio;

					$imagem = imagecreatetruecolor($largura, $altura);

					if($tipo = 'image/jpeg')
						$origi = imagecreatefromjpeg($caminho);
					elseif($tipo = 'image/png')
						$origi = imagecreatefrompng($caminho);	

					imagecopyresampled($imagem, $origi, 0, 0, 0, 0, $largura, $altura, 
						$largura_original, $altura_original);
					imagejpeg($imagem, $caminho, 80);
					$this->inserirImagensDoAnuncio($id_anuncio, $caminho);
				}
			}
		}
	}

	private function inserirImagensDoAnuncio(int $id_anuncio, string $url) : void
	{
		$query = 'INSERT INTO anuncios_imagens (id_anuncio, url) VALUES 
		(:id_anuncio, :url)';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':id_anuncio', $id_anuncio);
		$sql->bindValue(':url', $url);
		$sql->execute();
	}

	public function excluirFoto(int $id) : int
	{
		$id_anuncio = 0;
		$query = 'SELECT id_anuncio FROM anuncios_imagens WHERE id = :id';
		$sql = $this->pdo->prepare($query);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$id_anuncio = $sql->fetch(PDO::FETCH_ASSOC)['id_anuncio'];
		}

		$query = 'DELETE FROM anuncios_imagens WHERE id = :id';
		$sql = $this->pdo->prepare($query);
		$sql->bindValue(':id', $id);
		$sql->execute();

		return $id_anuncio;
	}

	public function getTotalAnuncios() : int
	{
		$query = 'SELECT COUNT(*) AS quantidade_anuncios FROM anuncios';
		$sql = $this->pdo->query($query);
		$quantidade = $sql->fetch(PDO::FETCH_ASSOC)['quantidade_anuncios'];
		return $quantidade;
	}
}