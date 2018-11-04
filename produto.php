<?php

require 'componentes/header.php';
require 'classes/Anuncios.php';
require 'classes/Usuarios.php';

$anuncios = new Anuncios($pdo);
$usuarios = new Usuarios($pdo);

if(empty($_GET['id']))
{
	header('Location: index.php');
	exit;
}

$id = $_GET['id'];
$informacoes = $anuncios->getAnuncio($id);

if(count($informacoes) == 0)
{
	header('Location: index.php');
	exit;
}

?>

<div class="container-fluid mt-2">
	<div class="row">
		<div class="col-4">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
			    <?php foreach($informacoes['fotos'] as $chave => $foto): ?>
			    	<div class="carousel-item <?php echo $chave == '0' ? 'active' : ''; ?>">
			      		<img class="d-block w-100" src="<?php echo $foto['url']; ?>">
			   		</div>
			    <?php endforeach; ?>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			  </a>
			</div>
		</div>
		<div class="col-8">
			<h1><?php echo $informacoes['titulo']; ?></h1>
			<h4><?php echo $informacoes['categoria']; ?></h4>
			<p><?php echo $informacoes['descricao']; ?></p>
			<h3>R$ <?php echo number_format($informacoes['valor'], 2); ?></h3>
			<?php if($informacoes['telefone']): ?>
				<h4>Telefone: <?php echo $informacoes['telefone']; ?></h4>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php require 'componentes/footer.php'; ?>