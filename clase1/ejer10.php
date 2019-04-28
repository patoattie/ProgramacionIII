<?php
	/*Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
	Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
	salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
	las estructuras while y foreach.*/

	$arrNumeros = array(0);
	$numero = 0;
	$cont = 0;
	define("MINIMO", 1);
	define("CANTIDAD", 10);
	define("INTERVALO", 2);

	$numero = MINIMO;
	for($i = 0; $i < CANTIDAD; $i++)
	{ 
		$arrNumeros[$i] = $numero;
		$numero += INTERVALO;
	}

	echo "Impresión con estructura for <br>";
	for($i = 0; $i < CANTIDAD; $i++)
	{ 
		echo "$arrNumeros[$i]<br>";
	}

	echo "Impresión con estructura while <br>";
	while($cont < CANTIDAD)
	{
		echo "$arrNumeros[$cont]<br>";
		$cont++;
	}

	echo "Impresión con estructura foreach <br>";
	foreach ($arrNumeros as $unNumero)
	{
		echo "$unNumero<br>";
	}
?>