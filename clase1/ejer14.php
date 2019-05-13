<?php
	/*Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los Arrays de Arrays.*/

	$animales = array("Perro", "Gato", "Ratón", "Araña", "Mosca");
	$numeros = array("1986", "1996", "2015", "78", "86");
	$lenguajes = array("php", "mysql", "html5", "typescript", "ajax");

	$asociativo = array("animales" => $animales, "numeros" => $numeros, "lenguajes" => $lenguajes);
	$indexado = array($animales, $numeros, $lenguajes);

	echo "Muestro asociativo: <br><br>";
	foreach ($asociativo as $key => $value)
	{
		echo "$key<br>";
		foreach ($value as $valor)
		{
			echo "$valor; ";
		}
		echo "<br>";
	}
?>