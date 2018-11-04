<?php require_once 'database/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Classificados</title>
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="/" class="navbar-brand">Classificados</a>
			</div>
			<div>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<?php if(!empty($_SESSION['c_login'])): ?>
						<a href="meus-anuncios.php" class="text-white">Meus Anúncios</a>
						<a href="sair.php" class="text-white">Sair</a>
						<?php else: ?>
						<a href="cadastre-se.php" class="text-white">Cadastre-se</a> | 
						<a href="login.php" class="text-white">Login</a>
						<?php endif; ?>
					</li>
				</ul>
			</div>
		</div>
	</nav>