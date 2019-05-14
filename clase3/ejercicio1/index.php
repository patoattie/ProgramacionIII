<?php
	//require_once("crearVehiculo.php");

	/*if (strcmp($_POST["accion"], "leer") == 0)
	{
		require_once("traerVehiculo.php");
	}*/

	$metodo = $_SERVER["REQUEST_METHOD"];

	switch ($metodo)
	{
		case "GET":
			echo "es GET";
			break;
		case "POST":
			echo "es POST";
			break;
		case "PUT":
			echo "es PUT";
			break;
		case "DELETE":
			echo "es DELETE";
			break;
	}
?>