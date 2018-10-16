<?php 
	require_once 'componentes/header.php'; 
	require_once 'classes/Usuarios.php';
	require_once 'classes/Form.php';

	$usuario = new Usuarios($pdo);
	$form = new Form();

	if(isset($_POST['submit']))
	{
		if($form->estaPreenchido('nome', 'email', 'senha') 
			&& $form->eUmEmailValido($_POST['email'])
			&& $form->temUmTamanhoValido(['email' => 100, 'nome' => 100]))
		{
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$senha = md5($_POST['senha']);
			$telefone = $_POST['telefone'];

			if($usuario->emailJaEstaCadastrado($email))
			{	
				?>
					<div class="mt-3 alert alert-warning">
						Este usuário já existe! <a href="login.php" class="alert-link">Faça o login agora</a>
					</div>
				<?php	
			} else {
				$usuario->cadastrar($nome, $email, $senha, $telefone);
				?>
				<div class="mt-3 alert alert-success">
					<strong>Parabéns!</strong> Cadastrado com sucesso. <a href="login.php" class="alert-link">Faça o login agora</a>
				</div>
				<?php
			}

		} else 
		{
			?>
			<div class="mt-3 alert alert-warning">Preencha todos os campos</div>
			<?php
		}
	} 
?>
<div class="container mt-3">
	<h1>Cadastre-se</h1>
	<form method="POST">
		<div class="form-group">
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" class="form-control">
		</div>
		<div class="form-group">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" class="form-control">
		</div>
		<div class="form-group">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" class="form-control">
		</div>
		<div class="form-group">
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone" class="form-control">
		</div>
		<input type="submit" value="Cadastrar" class="btn btn-default" name="submit">
	</form>
</div>	
<?php require_once 'componentes/footer.php'; ?>