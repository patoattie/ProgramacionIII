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
		$vehiculo = Estacionamiento::buscarEstacionado($patente);
		if (is_null($vehiculo))
		{
			$vehiculoIngresado = new Vehiculo($patente, date("Y/m/d H:i:s"));
			$archivo = fopen("archivo/estacionados.csv", "a");
			$linea = $vehiculoIngresado->getPatente().";".$vehiculoIngresado->getIngreso();
			fputs($archivo, $linea."\n");
			fclose($archivo);
			echo "<br>Vehiculo patente ".$vehiculoIngresado->getPatente()." ingresado satisfactoriamente en fecha ".$vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente ".$vehiculo->getPatente()." ya fue ingresado en fecha ".$vehiculo->getIngreso();
		}
	}

	public static function leerEstacionados()
	{
		$archivo = fopen("archivo/estacionados.csv", "r") or die("No existe el archivo");
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

	public static function buscarEstacionado($patente)
	{
		$arrayVehiculos = Estacionamiento::leerEstacionados();
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