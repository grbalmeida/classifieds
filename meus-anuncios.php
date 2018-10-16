<?php 
	require_once 'componentes/header.php';

	if(empty($_SESSION['c_login']))
	{
		header('Location: index.php');
		exit;
	}
?>
<div class="mt-3 container">
	<h1>Meus Anúncios</h1>
	<a href="add-anuncio.php" class="btn btn-default">Adicionar Anúncio</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Foto</th>
				<th>Título</th>
				<th>Valor</th>
				<th>Ações</th>
			</tr>
		</thead>
		<?php
		require_once 'classes/Anuncios.php';
		$anuncios = new Anuncios($pdo);
		$meusAnuncios = $anuncios->getMeusAnuncios();
		foreach($meusAnuncios as $anuncio):
			?>
			<tr>
				<td>
					<?php if($anuncio['url']): ?>
					<img src="images/anuncios/<?php echo $anuncio['url']; ?>">
					<?php else: ?>
					<img src="images/anuncios/default.jpg" width="60">
					<?php endif; ?>
				</td>
				<td><?php echo $anuncio['titulo']; ?></td>
				<td><?php echo number_format($anuncio['valor'], 2, ',', '.') ?></td>
				<td>
					<form method="POST" action="excluir-anuncio.php">
						<input type="hidden" name="id_anuncio" value="<?php echo $anuncio['id']; ?>">
						<input type="submit" value="Excluir" class="btn btn-default mb-2">
					</form>
					<form method="POST" action="editar-anuncio.php">
						<input type="hidden" name="id_anuncio" value="<?php echo $anuncio['id']; ?>">
						<input type="submit" value="Editar" class="btn btn-primary">
					</form>
				</td>
			</tr>
			<?php
		endforeach;
		?>
	</table>
</div>
<?php require_once 'componentes/footer.php'; ?>