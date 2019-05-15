<?php
require_once "Vehiculo.php";

class Estacionamiento
{
	/*function __construct(argument)
	{
		# code...
	}*/

	public static function ingresarVehiculo($patente)
	{
		$vehiculoIngresado = new Vehiculo($patente, date("Y/m/d H:i:s"));
		$vehiculo = Estacionamiento::buscarEstacionadoCSV($patente);

		if (is_null($vehiculo))
		{
			Estacionamiento::guardarCSV($vehiculoIngresado);
			echo "<br>Vehiculo patente ".$vehiculoIngresado->getPatente()." ingresado satisfactoriamente en CSV en fecha ".$vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente ".$vehiculo->getPatente()." ya fue ingresado en CSV en fecha ".$vehiculo->getIngreso();
		}

		$vehiculo = Estacionamiento::buscarEstacionadoJSON($patente);

		if (is_null($vehiculo))
		{
			Estacionamiento::guardarJSON($vehiculoIngresado);
			echo "<br>Vehiculo patente ".$vehiculoIngresado->getPatente()." ingresado satisfactoriamente en JSON en fecha ".$vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente ".$vehiculo->getPatente()." ya fue ingresado en JSON en fecha ".$vehiculo->getIngreso();
		}
	}

	public static function guardarCSV($vehiculo)
	{
		$archivo = fopen("archivo/estacionados.csv", "a");
		$linea = $vehiculo->getPatente().";".$vehiculo->getIngreso();
		fputs($archivo, $linea."\n");
		fclose($archivo);
	}

	public static function guardarJSON($vehiculo)
	{
		$archivo = fopen("archivo/estacionados.txt", "a");
		$linea = json_encode($vehiculo);
		fputs($archivo, $linea."\n");
		fclose($archivo);
	}

	public static function leerEstacionadosCSV()
	{
		$archivo = fopen("archivo/estacionados.csv", "r") or die("No existe el archivo archivo/estacionados.csv");
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		while (!feof($archivo))
		{
			$linea = fgets($archivo);
			if (strpos($linea, ";") != false)
			{
				$arrayDatos = explode(";", $linea);
				$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1]);
				array_push($retorno, $auto);
			}
		}

		fclose($archivo);

		return $retorno;
	}

	public static function buscarEstacionadoCSV($patente)
	{
		$arrayVehiculos = Estacionamiento::leerEstacionadosCSV();
		$retorno = null;

		foreach ($arrayVehiculos as $unAuto)
		{
			if ($patente === $unAuto->getPatente())
			{
				$retorno = $unAuto;
				break;
			}
		}

		return $retorno;
	}

	public static function leerEstacionadosJSON()
	{
		$archivo = fopen("archivo/estacionados.txt", "r") or die("No existe el archivo archivo/estacionados.txt");
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		while (!feof($archivo))
		{
			$linea = fgets($archivo);
			if (!is_null($linea))
			{
				$arrayDatos = json_decode($linea);
				$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1]);
				array_push($retorno, $auto);
			}
		}

		fclose($archivo);

		return $retorno;
	}

	public static function buscarEstacionadoJSON($patente)
	{
		$arrayVehiculos = Estacionamiento::leerEstacionadosJSON();
		$retorno = null;

		foreach ($arrayVehiculos as $unAuto)
		{
			if ($patente === $unAuto->getPatente())
			{
				$retorno = $unAuto;
				break;
			}
		}

		return $retorno;
	}
}
?>