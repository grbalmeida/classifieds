<?php require_once 'componentes/header.php'; ?>
	<div class="container-fluid mt-3">
		<div class="jumbotron">
			<?php 
				$pagina_atual = 1;

				if(!empty($_GET['p']))
				{
					$pagina_atual = $_GET['p'];
				}

				require 'classes/Anuncios.php';
				require 'classes/Usuarios.php';
				$anuncios = new Anuncios($pdo);
				$usuarios = new Usuarios($pdo);
				$total_anuncios = $anuncios->getTotalAnuncios();
				$total_usuarios = $usuarios->getTotalUsuarios();
				$porPagina = 2;
				$total_paginas = ceil($total_anuncios / $porPagina);
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
				<table class="table table-striped">
					<tbody>
						<?php foreach($anuncios->getUltimosAnuncios($pagina_atual, $porPagina) as $anuncio): ?>
							<tr>
								<td>
									<?php if($anuncio['url']): ?>
									<img src="<?php echo $anuncio['url']; ?>" width="60">
									<?php else: ?>
									<img src="images/anuncios/default.jpg" width="60">
									<?php endif; ?>
								</td>
								<td>
									<a href="produto.php?id=<?php echo $anuncio['id']; ?>"><?php echo $anuncio['titulo']; ?></a><br>
									<?php echo utf8_encode($anuncio['categoria']); ?>
								</td>
								<td><?php echo number_format($anuncio['valor'], 2, ',', '.') ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<ul class="pagination">
					<?php for($cont = 1; $cont <= $total_paginas; $cont++): ?>
						<li class="<?php echo $pagina_atual == $cont ? 'active' : ''; ?> page-item">
							<a class="page-link" href="index.php?p=<?php echo $cont; ?>">
								<?php echo $cont; ?>
							</a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
<?php require_once 'componentes/footer.php'; ?>