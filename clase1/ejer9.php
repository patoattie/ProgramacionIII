<?php
	/*Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
	función rand). Mediante una estructura condicional, determinar si el promedio de los números
	son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
	resultado.*/

	//$arrNum = array(rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10));
	$arrNum = array(0);
	$suma = 0;
	$promedio = (float)0;
	define("VALOR", 6);
	define("CANTIDAD", 5);
	define("MINIMO", 1);
	define("MAXIMO", 10);

	//foreach ($arrNum as $numero)
	for($i = 0; $i < CANTIDAD; $i++)
	{
		$arrNum[$i] = rand(MINIMO, MAXIMO);
		$suma += $arrNum[$i];
		echo "Indice $i: $arrNum[$i]<br>";
	}

	if(CANTIDAD == 0)
	{
		echo "ERROR. El array está vacío";
	}
	else
	{
		$promedio = $suma / CANTIDAD;
		if($promedio > VALOR)
		{
			echo "El promedio es mayor a ".VALOR;
		}
		elseif ($promedio < VALOR)
		{
			echo "El promedio es menor a ".VALOR;
		}
		else
		{
			echo "El promedio es igual a ".VALOR;
		}
	}
?>