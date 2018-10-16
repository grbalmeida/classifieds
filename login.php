<?php 
	require_once 'componentes/header.php'; 
	if(isset($_SESSION['c_login']))
	{
		header('Location: index.php');
		exit;
	}
?>
<div class="container mt-3">
	<h1>Login</h1>
	<?php 
	require_once 'classes/Usuarios.php';
	$usuario = new Usuarios($pdo);

	if(isset($_POST['submit']))
	{
		if(!empty($_POST['email']) && !empty($_POST['senha']))
		{
			$email = $_POST['email'];
			$senha = $_POST['senha'];

			if($usuario->login($email, md5($senha)))
			{	
				?>
				<script>window.location.href = window.location.href.replace('login.php', '')</script>
				<?php
			} else {
				?>
				<div class="alert alert-danger">E-mail ou senha errados</div>
				<?php
			}
		}
	}

	?>
	<form method="POST">
		<?php require_once 'componentes/email-senha.php'; ?>
		<input type="submit" name="submit" value="Logar" class="btn btn-default">
	</form>
</div>
<?php require_once 'componentes/footer.php'; ?>