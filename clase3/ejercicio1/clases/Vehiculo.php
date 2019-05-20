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

		public function mostrar()
		{
			echo "$this->patente || $this->ingreso";

			if ($this->importe != 0)
			{
				echo " || $this->importe<br>";
			}
			else
			{
				echo "<br>";
			}
		}

		public function toArray()
		{
			$retorno = array();

			/*array_push($retorno, $this->patente);
			array_push($retorno, $this->ingreso);
			array_push($retorno, $this->importe);*/

			$retorno["patente"] = trim($this->patente);
			$retorno["ingreso"] = trim($this->ingreso);
			if ($this->importe != 0)
			{
				$retorno["importe"] = $this->importe;
			}

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

		public function getImporte()
		{
			return $this->importe;
		}
	}
?>