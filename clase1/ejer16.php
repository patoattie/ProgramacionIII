<?php
	/*Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden de las letras del Array.
	Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.*/

	function invertirPalabra($palabra)
	{
		$inversa = "";

		for ($i = strlen($palabra); $i > 0; $i--)
		{ 
			$inversa = $inversa . substr($palabra, $i - 1, 1);
		}

		return $inversa;
	}

	echo invertirPalabra($_GET["palabra"]);
?>