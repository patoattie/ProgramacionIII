<?php
	/*Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
	contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
	lapiceras.*/

	define("CANTIDAD", 3);
	/*$color = "";
	$marca = "";
	$trazo = "";
	$precio = (float)0;*/
	$lapicera = array();
	$lapiceras = array();

	$lapicera["color"] = "Rojo";
	$lapicera["marca"] = "BIC";
	$lapicera["trazo"] = "Fino";
	$lapicera["precio"] = 12.5;

	array_push($lapiceras, $lapicera);

	$lapicera["color"] = "Azul";
	$lapicera["marca"] = "Sylvapen";
	$lapicera["trazo"] = "Medio";
	$lapicera["precio"] = 20.3;

	array_push($lapiceras, $lapicera);

	$lapicera["color"] = "Negro";
	$lapicera["marca"] = "Faber";
	$lapicera["trazo"] = "Grueso";
	$lapicera["precio"] = 18;

	array_push($lapiceras, $lapicera);

	for ($i=0; $i < 3; $i++)
	{ 
		foreach ($lapiceras[$i] as $key => $value)
		{
			echo "$key: $value<br>";
		}
	}
?>