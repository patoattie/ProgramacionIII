<?php
class Estacionamiento
{
	private static $_rutaEstacionados = "archivo/estacionados.txt";
	
	/*function __construct(argument)
	{
		# code...
	}*/

	public static function ingresarVehiculo($patente)
	{

	}

	public static function leerEstacionados()
	{
		$archivo = fopen($_rutaEstacionados, "r");
		$linea = "";
		$arrayDatos = array();
		$retorno = array();
		
		while (!feof($archivo))
		{
			//echo "Hola <br>";
			$linea = fgets($archivo);
			$arrayDatos = explode(";", $linea);
			$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1], $arrayDatos[2]);
			array_push($retorno, $auto);
		}

		fclose($archivo);

		return $retorno;
	}
}
?>