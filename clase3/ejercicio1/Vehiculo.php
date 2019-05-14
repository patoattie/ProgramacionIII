<?php
	class Vehiculo
	{
		private $patente;
		private $ingreso;
		private $importe;

		public function __construct($patente, $ingreso, $importe)
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
				//echo "Hola <br>";
				$linea = fgets($archivo);
				$arrayDatos = explode(";", $linea);
				$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1], $arrayDatos[2]);
				array_push($retorno, $auto);
			}

			fclose($archivo);

			return $retorno;
		}

		public function mostrar()
		{
			echo "$this->patente;$this->ingreso;$this->importe<br>";
		}
	}
?>