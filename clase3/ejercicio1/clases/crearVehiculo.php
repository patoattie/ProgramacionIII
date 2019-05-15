<?php
	require_once("Vehiculo.php");

	$vehiculo = new Vehiculo("DDD147", "12/05/2019", 18);

	Vehiculo::guardarVehiculo($vehiculo, "./archivo/vehiculos.txt");
?>