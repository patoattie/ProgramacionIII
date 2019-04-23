<?php
	/*Realizar un programa que guarde su nombre en $nombre y su apellido en $apellido. Luego
	mostrar el contenido de las variables con el siguiente formato: Pérez, Juan. Utilizar el operador
	de concatenación.*/

	//$nombre = "Patricio";
	//$apellido = "Attie";
	$nombre = $_GET["nombre"];
	$apellido = $_GET["apellido"];
	echo $apellido.", ".$nombre;
	//var_dump($_GET);
?>