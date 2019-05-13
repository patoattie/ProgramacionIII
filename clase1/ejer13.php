<?php
	/*Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por pantalla.
	“Perro”, “Gato”, “Ratón”, “Araña”, “Mosca”
	“1986”, “1996”, “2015”, “78”, “86”
	“php”, “mysql”, “html5”, “typescript”, “ajax”
	Para cargar los arrays utilizar la función array_push​. Para juntarlos, utilizar la función array_merge​.*/

	$animales = array();
	$numeros = array();
	$lenguajes = array();
	$total = array();

	$animal = "Perro";
	array_push($animales, $animal);
	$animal = "Gato";
	array_push($animales, $animal);
	$animal = "Ratón";
	array_push($animales, $animal);
	$animal = "Araña";
	array_push($animales, $animal);
	$animal = "Mosca";
	array_push($animales, $animal);

	$numero = "1986";
	array_push($numeros, $numero);
	$numero = "1996";
	array_push($numeros, $numero);
	$numero = "2015";
	array_push($numeros, $numero);
	$numero = "78";
	array_push($numeros, $numero);
	$numero = "86";
	array_push($numeros, $numero);

	$lenguaje = "php";
	array_push($lenguajes, $lenguaje);
	$lenguaje = "mysql";
	array_push($lenguajes, $lenguaje);
	$lenguaje = "html5";
	array_push($lenguajes, $lenguaje);
	$lenguaje = "typescript";
	array_push($lenguajes, $lenguaje);
	$lenguaje = "ajax";
	array_push($lenguajes, $lenguaje);

	$total = array_merge($animales, $numeros, $lenguajes);

	foreach ($total as $value)
	{
		echo "$value<br>";
	}
?>