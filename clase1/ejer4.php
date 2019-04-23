<?php
	/*Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
	supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
	se sumaron.*/

	$n = 1;
	$calculo = "".($n - 1);
	$suma = 0;

	while($n + $suma < 1000)
	{
		$calculo = $calculo." + $n ";
		$suma += $n;
		$n++;
	}

	$calculo = $calculo." = $suma";

	echo $calculo;

?>