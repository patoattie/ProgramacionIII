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

		//a) archivo separado por comas “facturados.csv”
		$vehiculo = Estacionamiento::buscarEstacionadoCSV($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarCSV($vehiculoFacturado, "archivo/facturados.csv"); //Agrego al archivo de facturados
			Estacionamiento::borrarEstacionadosCSV($patente); //Elimino del archivo de estacionados

			echo "<br>Vehiculo patente " . $vehiculoFacturado->getPatente() . " facturado satisfactoriamente en CSV con importe " . $vehiculoFacturado->getImporte();
		}
		else
		{
			echo "<br>El vehiculo patente $patente no esta estacionado en CSV";
		}

		//b) archivo de un objeto json por renglón ”facturados.txt”
		$vehiculo = Estacionamiento::buscarEstacionadoJSON($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarJSON($vehiculoFacturado, "archivo/facturados.txt"); //Agrego al archivo de facturados
			Estacionamiento::borrarEstacionadosJSON($patente); //Elimino del archivo de estacionados

			echo "<br>Vehiculo patente " . $vehiculoFacturado->getPatente() . " facturado satisfactoriamente en JSON con importe " . $vehiculoFacturado->getImporte();
		}
		else
		{
			echo "<br>El vehiculo patente $patente no esta estacionado en JSON";
		}

		//c) un array de json que representa a los vehículos estacionados “facturados.json”
		$vehiculo = Estacionamiento::buscarEstacionadoArrayJSON($patente);
		if (!is_null($vehiculo))
		{
			$ingreso = $vehiculo->getIngreso();
			$importe = Estacionamiento::calcularImporte($ingreso);
			$vehiculoFacturado = new Vehiculo($patente, $ingreso, $importe);

			Estacionamiento::guardarArrayJSON($vehiculoFacturado, "archivo/facturados.json"); //Agrego al archivo de facturados
			Estacionamiento::borrarEstacionadosArrayJSON($patente); //Elimino del archivo de estacionados

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

	public static function leerCSV($ruta)
	{
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		$archivo = fopen($ruta, "r") or die("No existe el archivo $ruta");

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = explode(",", $linea);

				if (!isset($arrayDatos[2]))
				{
					$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1]);
				}
				else
				{
					$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1], $arrayDatos[2]);
				}

				array_push($retorno, $auto);
			}
		}

		fclose($archivo);

		return $retorno;
	}

	public static function borrarEstacionadosCSV($patente)
	{
		$linea = "";
		$arrayOrigen = Estacionamiento::leerCSV("archivo/estacionados.csv");
		$arrayDestino = array();
		$retorno = false;

		foreach ($arrayOrigen as $vehiculo)
		{
			if ($vehiculo->getPatente() != $patente)
			{
				array_push($arrayDestino, $vehiculo);
			}
			else
			{
				$retorno = true;
			}
		}

		if ($retorno) //Solamente si borro el dato reescribo el archivo
		{
			$archivo = fopen("archivo/estacionados.csv", "w");

			foreach ($arrayDestino as $vehiculo)
			{
				$linea = implode(",", $vehiculo->toArray());
				fputs($archivo, $linea . "\n");
			}

			fclose($archivo);
		}

		return $retorno;
	}

	public static function buscarEstacionadoCSV($patente)
	{
		$arrayVehiculos = Estacionamiento::leerCSV("archivo/estacionados.csv");
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

	public static function mostrarEstacionadosCSV()
	{
		$arrayVehiculos = Estacionamiento::leerCSV("archivo/estacionados.csv");

		echo "LISTADO DE ESTACIONADOS (CSV)<br>";
		echo "_____________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
	}

	public static function mostrarFacturadosCSV()
	{
		$arrayVehiculos = Estacionamiento::leerCSV("archivo/facturados.csv");

		echo "LISTADO DE FACTURADOS (CSV)<br>";
		echo "_____________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
		echo "_____________________________<br>";
		echo "TOTAL FACTURADO: ";
		echo Estacionamiento::obtenerTotal($arrayVehiculos);
	}

	public static function leerJSON($ruta)
	{
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		$archivo = fopen($ruta, "r") or die("No existe el archivo $ruta");

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.

				if (!isset($arrayDatos["importe"]))
				{
					$auto = new Vehiculo($arrayDatos["patente"], $arrayDatos["ingreso"]);
				}
				else
				{
					$auto = new Vehiculo($arrayDatos["patente"], $arrayDatos["ingreso"], $arrayDatos["importe"]);
				}

				array_push($retorno, $auto);
			}
		}

		fclose($archivo);

		return $retorno;
	}

	public static function borrarEstacionadosJSON($patente)
	{
		$linea = "";
		$arrayOrigen = Estacionamiento::leerJSON("archivo/estacionados.txt");
		$arrayDestino = array();
		$retorno = false;

		foreach ($arrayOrigen as $vehiculo)
		{
			if ($vehiculo->getPatente() != $patente)
			{
				array_push($arrayDestino, $vehiculo);
			}
			else
			{
				$retorno = true;
			}
		}

		if ($retorno) //Solamente si borro el dato reescribo el archivo
		{
			$archivo = fopen("archivo/estacionados.txt", "w");

			foreach ($arrayDestino as $vehiculo)
			{
				$linea = json_encode($vehiculo->toArray());
				fputs($archivo, $linea . "\n");
			}

			fclose($archivo);
		}

		return $retorno;
	}

	public static function buscarEstacionadoJSON($patente)
	{
		$arrayVehiculos = Estacionamiento::leerJSON("archivo/estacionados.txt");
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

	public static function mostrarEstacionadosJSON()
	{
		$arrayVehiculos = Estacionamiento::leerJSON("archivo/estacionados.txt");

		echo "LISTADO DE ESTACIONADOS (JSON)<br>";
		echo "______________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
	}

	public static function mostrarFacturadosJSON()
	{
		$arrayVehiculos = Estacionamiento::leerJSON("archivo/facturados.txt");

		echo "LISTADO DE FACTURADOS (JSON)<br>";
		echo "_____________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
		echo "_____________________________<br>";
		echo "TOTAL FACTURADO: ";
		echo Estacionamiento::obtenerTotal($arrayVehiculos);
	}

	public static function leerArrayJSON($ruta)
	{
		$arrayJSON = array();
		$retorno = array();

		$archivo = fopen($ruta, "r") or die("No existe el archivo $ruta");
		$linea = fgets($archivo);
		fclose($archivo);

		if ((string)$linea != "") //Evito lineas vacias
		{
			$arrayJSON = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.

			foreach ($arrayJSON as $unJSON)
			{
				if (!isset($unJSON["importe"]))
				{
					$auto = new Vehiculo($unJSON["patente"], $unJSON["ingreso"]);
				}
				else
				{
					$auto = new Vehiculo($unJSON["patente"], $unJSON["ingreso"], $unJSON["importe"]);
				}

				array_push($retorno, $auto);
			}
		}

		return $retorno;
	}

	public static function borrarEstacionadosArrayJSON($patente)
	{
		$linea = "";
		$arrayOrigen = Estacionamiento::leerArrayJSON("archivo/estacionados.json");
		$arrayDestino = array();
		$retorno = false;

		foreach ($arrayOrigen as $vehiculo)
		{
			if ($vehiculo->getPatente() != $patente)
			{
				array_push($arrayDestino, $vehiculo->toArray());
			}
			else
			{
				$retorno = true;
			}
		}

		if ($retorno) //Solamente si borro el dato reescribo el archivo
		{
			$archivo = fopen("archivo/estacionados.json", "w");
			fputs($archivo, json_encode($arrayDestino));
			fclose($archivo);
		}

		return $retorno;
	}

	public static function buscarEstacionadoArrayJSON($patente)
	{
		$arrayVehiculos = Estacionamiento::leerArrayJSON("archivo/estacionados.json");
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

	public static function mostrarEstacionadosArrayJSON()
	{
		$arrayVehiculos = Estacionamiento::leerArrayJSON("archivo/estacionados.json");

		echo "LISTADO DE ESTACIONADOS (Array JSON)<br>";
		echo "____________________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
	}

	public static function mostrarFacturadosArrayJSON()
	{
		$arrayVehiculos = Estacionamiento::leerArrayJSON("archivo/facturados.json");

		echo "LISTADO DE FACTURADOS (Array JSON)<br>";
		echo "____________________________________<br>";
		Estacionamiento::listarVehiculos($arrayVehiculos);
		echo "____________________________________<br>";
		echo "TOTAL FACTURADO: ";
		echo Estacionamiento::obtenerTotal($arrayVehiculos);
	}

	public static function calcularImporte($ingreso)
	{
		$horaActual = new DateTime(date("Y/m/d H:i:s"));
		$horaIngreso = new DateTime($ingreso);
		$cantidadMinutos = ($horaIngreso->diff($horaActual))->format("%i");
		return ($cantidadMinutos * 15);
	}

	public static function listarVehiculos($arrayVehiculos)
	{
		foreach ($arrayVehiculos as $vehiculo)
		{
			$vehiculo->mostrar();
		}
	}

	public static function obtenerTotal($arrayVehiculos)
	{
		$total = (float)0;

		foreach ($arrayVehiculos as $vehiculo)
		{
			$total += $vehiculo->getImporte();
		}

		return $total;
	}
}
?>