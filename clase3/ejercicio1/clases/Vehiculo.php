<?php
	class Vehiculo
	{
		private $patente;
		private $ingreso;
		private $importe;

		public function __construct($patente, $ingreso, $importe = null)
		{
			$this->patente = (string)$patente;
			$this->ingreso = (string)$ingreso;
			$this->importe = (float)$importe;
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

		public function getPatente()
		{
			return $this->patente;
		}

		public function getIngreso()
		{
			return $this->ingreso;
		}
	}
?>