<?php
	//require_once("crearVehiculo.php");

	/*if (strcmp($_POST["accion"], "leer") == 0)
	{
		require_once("traerVehiculo.php");
	}*/

	date_default_timezone_set("America/Argentina/Buenos_Aires");

	$metodo = $_SERVER["REQUEST_METHOD"];

	switch ($metodo)
	{
		case "GET":
			echo "es GET";
			break;
		case "POST":
			switch ($_POST["accion"])
			{
				case "estacionar":
					require_once("clases/Estacionamiento.php");
					Estacionamiento::ingresarVehiculo($_POST["patente"]);
					break;

				case "facturar":
					require_once("clases/Estacionamiento.php");
					Estacionamiento::facturarVehiculo($_POST["patente"]);
					//echo Estacionamiento::calcularImporte("2019/05/18 22:57:59");
					break;
				
				default:
					# code...
					break;
			}
			break;
		case "PUT":
			echo "es PUT";
			break;
		case "DELETE":
			echo "es DELETE";
			break;
	}
?>