<?php require_once 'componentes/header.php'; ?>
	<div class="container-fluid mt-3">
		<div class="jumbotron">
			<?php 
				require 'classes/Anuncios.php';
				require 'classes/Usuarios.php';
				$anuncios = new Anuncios($pdo);
				$usuarios = new Usuarios($pdo);
				$total_anuncios = $anuncios->getTotalAnuncios();
				$total_usuarios = $usuarios->getTotalUsuarios();
			?>	
			<h3>Nós temos hoje <?php echo $total_anuncios; ?> anúncios.</h3>
			<p>E mais de <?php echo $total_usuarios; ?> usuários cadastrados.</p>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<h4>Filtros</h4>
			</div>
			<div class="col-sm-9">
				<h4>Últimos Anúncios</h4>
			</div>
		</div>
	</div>
<?php require_once 'componentes/footer.php'; ?>