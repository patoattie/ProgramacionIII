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
		//$arrayJSON = array();

		if (is_null($vehiculo))
		{
			Estacionamiento::guardarCSV($vehiculoIngresado);
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en CSV en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente() . " ya fue ingresado en CSV en fecha " . $vehiculo->getIngreso();
		}

		$vehiculo = Estacionamiento::buscarEstacionadoJSON($patente);

		if (is_null($vehiculo))
		{
			Estacionamiento::guardarJSON($vehiculoIngresado);
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en JSON en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente()." ya fue ingresado en JSON en fecha " . $vehiculo->getIngreso();
		}

		//$arrayJSON = Estacionamiento::leerEstacionadosArrayJSON();
		$vehiculo = Estacionamiento::buscarEstacionadoArrayJSON($patente);

		if (is_null($vehiculo))
		{
			Estacionamiento::guardarArrayJSON($vehiculoIngresado);
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en Array JSON en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente() . " ya fue ingresado en Array JSON en fecha " . $vehiculo->getIngreso();
		}
	}

	public static function guardarCSV($vehiculo)
	{
		//$linea = $vehiculo->getPatente().";".$vehiculo->getIngreso();
		$arrayDatos = $vehiculo->toArray();
		$linea = implode(";", $arrayDatos);
		$archivo = fopen("archivo/estacionados.csv", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public static function guardarJSON($vehiculo)
	{
		//$arrayDatos = $vehiculo->toArray();
		$linea = json_encode($vehiculo->toArray());
		$archivo = fopen("archivo/estacionados.txt", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public static function guardarArrayJSON($vehiculo)
	{
		$datoJSON = json_encode($vehiculo->toArray());

		$archivo = fopen("archivo/estacionados.json", "r") or die("No existe el archivo archivo/estacionados.json");
		$linea = fgets($archivo);
		fclose($archivo);

		if ((string)$linea != "") //Evito las lineas vacias
		{
			$linea = "," . $linea;
		}
		$linea = $linea . $datoJSON;

		$archivo = fopen("archivo/estacionados.json", "w");
		fputs($archivo, $linea);
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
			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.
				$auto = new Vehiculo($arrayDatos["patente"], $arrayDatos["ingreso"]);
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

	public static function leerEstacionadosArrayJSON()
	{
		$archivo = fopen("archivo/estacionados.json", "r") or die("No existe el archivo archivo/estacionados.json");
		$linea = fgets($archivo);
		$arrayJSON = array();
		$arrayDatos = array();
		$retorno = array();

		if (strpos($linea, ",") != false)
		{
			$arrayJSON = explode(",", $linea);

			foreach ($arrayJSON as $datoJSON)
			{
				$arrayDatos = json_decode($datoJSON, true); //El segundo parametro en true para que trate la salida como array.

				$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1]);
				array_push($retorno, $auto);
			}
		}

		fclose($archivo);

		return $retorno;
	}

	public static function buscarEstacionadoArrayJSON($patente)
	{
		$arrayVehiculos = Estacionamiento::leerEstacionadosArrayJSON();
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