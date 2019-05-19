<?php
require_once "Vehiculo.php";

class Estacionamiento
{
	/*function __construct(argument)
	{
		# code...
	}*/


	/*caso 1 por POST: Se ingresan los la patente del vehículo( si no está estacionado ) guarda la patente y la fecha con la hora de ingreso en archivo:*/
	public static function ingresarVehiculo($patente)
	{
		//Creo el objeto con el vehiculo que quiero dar de alta.
		$vehiculoIngresado = new Vehiculo($patente, date("Y/m/d H:i:s"));

		//a) archivo separado por comas “estacionados.csv”
		$vehiculo = Estacionamiento::buscarEstacionadoCSV($patente);
		if (is_null($vehiculo))
		{
			Estacionamiento::guardarCSV($vehiculoIngresado, "archivo/estacionados.csv");
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en CSV en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente() . " ya fue ingresado en CSV en fecha " . $vehiculo->getIngreso();
		}

		//b) archivo de un objeto json por renglón”estacionados.txt”
		$vehiculo = Estacionamiento::buscarEstacionadoJSON($patente);
		if (is_null($vehiculo))
		{
			Estacionamiento::guardarJSON($vehiculoIngresado, "archivo/estacionados.txt");
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en JSON en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente()." ya fue ingresado en JSON en fecha " . $vehiculo->getIngreso();
		}

		//c) un array de json que representa a los vehículos estacionados “estacionados.json”
		$vehiculo = Estacionamiento::buscarEstacionadoArrayJSON($patente);
		if (is_null($vehiculo))
		{
			Estacionamiento::guardarArrayJSON($vehiculoIngresado, "archivo/estacionados.json");
			echo "<br>Vehiculo patente " . $vehiculoIngresado->getPatente() . " ingresado satisfactoriamente en Array JSON en fecha " . $vehiculoIngresado->getIngreso();
		}
		else
		{
			echo "<br>El vehiculo patente " . $vehiculo->getPatente() . " ya fue ingresado en Array JSON en fecha " . $vehiculo->getIngreso();
		}
	}


	/*caso 2 por POST: Se ingresan los la patente del vehículo( y está estacionado ) saca los datos del archivo “estacionados” y hace la cuenta , se cobra $15 el minuto, y se guardan los datos en el archivo “facturados” (.csv ; .txt; .json)*/
	public static function facturarVehiculo($patente)
	{
		//Creo el objeto con el vehiculo que quiero dar de alta.
		$vehiculoFacturado = null;
		$importe = (float)0;
		$ingreso = "";

		//a) archivo separado por comas “estacionados.csv”
		$vehiculo = Estacionamiento::buscarEstacionadoCSV($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarCSV($vehiculoFacturado, "archivo/facturados.csv");
			echo "<br>Vehiculo patente " . $vehiculoFacturado->getPatente() . " facturado satisfactoriamente en CSV con importe " . $vehiculoFacturado->getImporte();
		}
		else
		{
			echo "<br>El vehiculo patente $patente no esta estacionado en CSV";
		}

		//b) archivo de un objeto json por renglón”estacionados.txt”
		$vehiculo = Estacionamiento::buscarEstacionadoJSON($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarJSON($vehiculoFacturado, "archivo/facturados.txt");
			echo "<br>Vehiculo patente " . $vehiculoFacturado->getPatente() . " facturado satisfactoriamente en JSON con importe " . $vehiculoFacturado->getImporte();
		}
		else
		{
			echo "<br>El vehiculo patente $patente no esta estacionado en JSON";
		}

		//c) un array de json que representa a los vehículos estacionados “estacionados.json”
		$vehiculo = Estacionamiento::buscarEstacionadoArrayJSON($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarArrayJSON($vehiculoFacturado, "archivo/facturados.json");
			echo "<br>Vehiculo patente " . $vehiculoFacturado->getPatente() . " facturado satisfactoriamente en Array JSON con importe " . $vehiculoFacturado->getImporte();
		}
		else
		{
			echo "<br>El vehiculo patente $patente no esta estacionado en Array JSON";
		}
	}

	public static function guardarCSV($vehiculo, $ruta)
	{
		$linea = implode(",", $vehiculo->toArray());
		$archivo = fopen($ruta, "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public static function guardarJSON($vehiculo, $ruta)
	{
		$linea = json_encode($vehiculo->toArray());
		$archivo = fopen($ruta, "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public static function guardarArrayJSON($vehiculo, $ruta)
	{
		$arrayJSON = array();

		$archivo = fopen($ruta, "r") or die("No existe el archivo $ruta");
		$linea = fgets($archivo);
		fclose($archivo);

		if ((string)$linea != "") //Evito las lineas vacias
		{
			$arrayJSON = json_decode($linea, true);
		}
		array_push($arrayJSON, $vehiculo->toArray());

		$archivo = fopen($ruta, "w");
		fputs($archivo, json_encode($arrayJSON));
		fclose($archivo);
	}

	public static function leerEstacionadosCSV()
	{
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		$archivo = fopen("archivo/estacionados.csv", "r") or die("No existe el archivo archivo/estacionados.csv");

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = explode(",", $linea);
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
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		$archivo = fopen("archivo/estacionados.txt", "r") or die("No existe el archivo archivo/estacionados.txt");

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
		$arrayJSON = array();
		$retorno = array();

		$archivo = fopen("archivo/estacionados.json", "r") or die("No existe el archivo archivo/estacionados.json");
		$linea = fgets($archivo);
		fclose($archivo);

		if ((string)$linea != "") //Evito lineas vacias
		{
			$arrayJSON = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.

			foreach ($arrayJSON as $unJSON)
			{
				$auto = new Vehiculo($unJSON["patente"], $unJSON["ingreso"]);
				array_push($retorno, $auto);
			}
		}

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

	public static function calcularImporte($ingreso)
	{
		$horaActual = new DateTime(date("Y/m/d H:i:s"));
		$horaIngreso = new DateTime($ingreso);
		$cantidadMinutos = ($horaIngreso->diff($horaActual))->format("%i");
		return ($cantidadMinutos * 15);
	}
}
?>