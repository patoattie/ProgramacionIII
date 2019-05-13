<?php
	/*Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4 (hacer una función que las calcule invocando la función pow​).*/

	function calcularPotencia($base)
	{
		$potencia = 0;
		$exponente = 0;

		for ($i = 0; $i < 4; $i++)
		{
			$exponente = $i + 1;
			$potencia = pow($base, $exponente);

			echo "$base ^ $exponente = $potencia<br>";
		}
	}

	for ($i = 0; $i < 4; $i++)
	{ 
		calcularPotencia($i + 1);
	}
?>