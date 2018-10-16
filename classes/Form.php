<?php

class Form
{
	public function estaPreenchido($atributos) : bool
	{

		$inputs = func_get_args();

		foreach($inputs as $input)
		{
			if(empty($_POST[$input]))
			{
				return false;
			}
		}
		return true;
	}

	public function eUmEmailValido(string $email) : bool
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public function temUmTamanhoValido(array $campos) : bool
	{
		foreach($campos as $campo => $tamanho)
		{
			if(strlen($_POST[$campo]) <= $tamanho != 1)
			{
				return false;
			}
		}
		return true;
	}
}