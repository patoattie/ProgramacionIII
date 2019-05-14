<?php
	require_once("Vehiculo.php");
	$vehiculos = array();

	$vehiculos = Vehiculo::leerArchivo("./archivo/vehiculos.txt");

	foreach ($vehiculos as $unAuto)
	{
		$unAuto->mostrar();
	}
?>