<?php
	class Vehiculo
	{
		private $patente;
		private $ingreso;
		private $importe;

		public function __construct($patente, $ingreso, $importe = 0)
		{
			$this->patente = (string)$patente;
			$this->ingreso = (string)$ingreso;
			$this->importe = (float)$importe;
		}

		public static function leerArchivo($rutaArchivo)
		{
			$archivo = fopen($rutaArchivo, "r");
			$linea = "";
			$arrayDatos = array();
			$retorno = array();

			while (!feof($archivo))
			{
				$linea = fgets($archivo);
				$arrayDatos = explode(";", $linea);
				$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1], $arrayDatos[2]);
				array_push($retorno, $auto);
			}

			fclose($archivo);

			return $retorno;
		}

		public static function guardarVehiculo($vehiculo, $rutaArchivo)
		{
			$archivo = fopen($rutaArchivo, "a");
			$linea = implode(";", $vehiculo->toArray());
			fputs($archivo, "\n".$linea);
			fclose($archivo);
		}

		public function mostrar()
		{
			echo "$this->patente;$this->ingreso;$this->importe<br>";
		}

		public function toArray()
		{
			$retorno = array();

			array_push($retorno, $this->patente);
			array_push($retorno, $this->ingreso);
			array_push($retorno, $this->importe);

			return $retorno;
		}
	}
?>