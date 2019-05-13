<?php
	/*Crear una función llamada ​esPar​ que reciba un valor entero como parámetro y devuelva TRUE si este número es par ó FALSE​ si es impar.
	Reutilizando el código anterior, crear la función esImpar​.*/

	function esPar($numero)
	{
		$retorno = false;

		if ($numero % 2 == 0)
		{
			$retorno = true;
		}

		return $retorno;
	}

	function esImpar($numero)
	{
		return !esPar($numero);
	}

	$dato = (int)$_GET["numero"];

	if (esPar($dato))
	{
		echo "El numero ingresado ($dato) es PAR";
	}

	if (esImpar($dato))
	{
		echo "El numero ingresado ($dato) es IMPAR";
	}
?>