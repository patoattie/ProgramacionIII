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
			switch ($_GET["accion"])
			{
				/*caso 3 por GET:Se pide los estacionados y se muestra el listado .*/
				case "estacionados":
					require_once("clases/Estacionamiento.php");
					Estacionamiento::mostrarEstacionadosCSV();
					echo "<br>";
					Estacionamiento::mostrarEstacionadosJSON();
					echo "<br>";
					Estacionamiento::mostrarEstacionadosArrayJSON();
					break;

				/*caso 4 por GET:Se pide los facturados, mostrando todos los datos y la suma total facturada*/
				case "facturados":
					require_once("clases/Estacionamiento.php");
					Estacionamiento::mostrarFacturadosCSV();
					echo "<br>";
					Estacionamiento::mostrarFacturadosJSON();
					echo "<br>";
					Estacionamiento::mostrarFacturadosArrayJSON();
					break;
			}
			break;
		case "POST":
			switch ($_POST["accion"])
			{
				/*caso 1 por POST: Se ingresan los la patente del vehículo( si no está estacionado ) guarda la patente y la fecha com la hora de ingreso en archivo:
					a) archivo separado por comas “estacionados.csv”
					b) archivo de un objeto json por renglón”estacionados.txt”
					c) un array de json que representa a los vehículos estacionados “estacionados.json”*/
				case "estacionar":
					require_once("clases/Estacionamiento.php");
					Estacionamiento::ingresarVehiculo($_POST["patente"]);
					break;

				/*caso 2 por POST: Se ingresan los la patente del vehículo( y está estacionado )
				  saca los datos del archivo “estacionados” y hace la cuenta , se cobra $15 el minuto,
				  y se guardan los datos en el archivo “facturados” (.csv ; .txt; .json)*/
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
		default:
			echo "Se invoco al metodo HTTP: $metodo";
			break;
	}
?>