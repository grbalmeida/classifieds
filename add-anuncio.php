<?php 
	require_once 'componentes/header.php';
	require_once 'classes/Categorias.php';
	require_once 'classes/Anuncios.php';

	if (empty($_SESSION['c_login'])) {
		header('Location: index.php');
		exit;
	}

	$categorias = new Categorias($pdo);
	$anuncios = new Anuncios($pdo);

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

			$anuncios->adicionar($id_categoria, $titulo, $valor, $descricao, $estado);

			?>
			<div class="mt-3 alert alert-success">
				Produto adicionado com sucesso
			</div>
			<?php
		}
	}
?>
<div class="mt-3 container">
	<h1>Meus Anúncios - Adicionar Anúncio</h1>
	<form method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="categoria">Categoria</label>
			<select name="categoria" id="categoria" class="form-control">
				<?php
				foreach($categorias->getCategorias() as $categoria):
					?>
					<option value="<?php echo $categoria['id']; ?>"><?php echo utf8_encode($categoria['nome']); ?></option>
					<?php
				endforeach;
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="titulo">Título</label>
			<input type="text" name="titulo" id="titulo" class="form-control">
		</div>
		<div class="form-group">
			<label for="valor">Valor</label>
			<input type="text" name="valor" id="valor" class="form-control">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao"></textarea>
		</div>
		<div class="form-group">
			<label for="estado">Estado de Conservação</label>
			<select name="estado" id="estado" class="form-control">
				<option value="1">Ruim</option>
				<option value="2">Bom</option>
				<option value="3">Ótimo</option>
			</select>
		</div>
		<input type="submit" name="submit" value="Adicionar" class="btn btn-default">
	</form>
</div>
<?php require_once 'componentes/footer.php'; ?>