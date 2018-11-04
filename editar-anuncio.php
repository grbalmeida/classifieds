<?php 
	require_once 'componentes/header.php';
	require_once 'classes/Categorias.php';
	require_once 'classes/Anuncios.php';

	if(empty($_SESSION['c_login'])) {
		header('Location: index.php');
		exit;
	}

	$categorias = new Categorias($pdo);
	$anuncios = new Anuncios($pdo);

	if(!isset($_POST['id_anuncio']) || count($anuncios->getAnuncio($_POST['id_anuncio'])) == 0)
	{
		header('Location: meus-anuncios.php');
		exit;
	}

	if(isset($_POST['submit']))
	{
		if(!empty($_POST['categoria']) && !empty($_POST['titulo']) 
			&& !empty($_POST['valor']) && !empty($_POST['descricao']) 
			&& !empty($_POST['estado']))
		{
			$id_categoria = intval($_POST['categoria']);
			$titulo = $_POST['titulo'];
			$valor = floatval(str_replace(',', '.', $_POST['valor']));
			$descricao = $_POST['descricao'];
			$estado = intval($_POST['estado']);
			$id_anuncio = $_POST['id_anuncio'];
			$anuncios->editar($id_anuncio, $id_categoria, $titulo, $valor, $descricao, $estado);
			header('Location: meus-anuncios.php');
			exit;

			?>
			<div class="mt-3 alert alert-success">
				Produto editado com sucesso
			</div>
			<?php
		}
	}

	$informacoes = $anuncios->getAnuncio($_POST['id_anuncio'])[0];
?>
<div class="mt-3 container">
	<h1>Meus Anúncios - Editar Anúncio</h1>
	<form method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_anuncio" value="<?php echo $_POST['id_anuncio']; ?>">
		<div class="form-group">
			<label for="categoria">Categoria</label>
			<select name="categoria" id="categoria" class="form-control">
				<?php
				foreach($categorias->getCategorias() as $categoria):
					?>
					<option value="<?php echo $categoria['id']; ?>"
						<?php echo $informacoes['id_categoria'] == $categoria['id'] ? 'selected' : ''; ?>>
						<?php echo utf8_encode($categoria['nome']); ?>		
					</option>
					<?php
				endforeach;
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="titulo">Título</label>
			<input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $informacoes['titulo']; ?>">
		</div>
		<div class="form-group">
			<label for="valor">Valor</label>
			<input type="text" name="valor" id="valor" class="form-control" value="<?php echo $informacoes['valor']; ?>">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao"><?php echo $informacoes['descricao']; ?></textarea>
		</div>
		<div class="form-group">
			<label for="estado">Estado de Conservação</label>
			<select name="estado" id="estado" class="form-control">
				<option value="1" <?php echo $informacoes['estado'] == 1 ? 'selected' : '' ?>>Ruim</option>
				<option value="2" <?php echo $informacoes['estado'] == 2 ? 'selected' : '' ?>>Bom</option>
				<option value="3" <?php echo $informacoes['estado'] == 3 ? 'selected' : '' ?>>Ótimo</option>
			</select>
		</div>
		<input type="submit" name="submit" value="Salvar" class="btn btn-default">
	</form>
</div>
<?php require_once 'componentes/footer.php'; ?>