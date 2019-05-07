<?php

class container
{
	private $id;
	private $tamaño;
	private $capacidad;
	private $arrayProductos;

	public function __construct()
	{
		$this->id = 1;
		$this->tamaño = "MEDIANO";
		$this->capacidad = 2500;
		$this->arrayProductos = array();
	}

	public function agregarProducto($producto)
	{
		$existe = false;

		if($producto->getKilos() <= $this->getCapacidadLibre())
		{
			foreach ($this->arrayProductos as $value)
			{
				if($producto === $value)
				{
					$existe = true;
					break;
				}
			}

			if(!$existe)
			{
				array_push($this->arrayProductos, $producto);
			}
		}
		else
		{
			echo "<br> NO HAY LUGAR DISPONIBLE EN EL CONTENEDOR";
		}
	}

	public function getCapacidadLibre()
	{
		$libre = $this->capacidad;

		foreach ($this->arrayProductos as $value)
		{
			$libre -= $value->getKilos();
		}

		return $libre;
	}

	public function mostrar()
	{
		$libre = $this->getCapacidadLibre();

		echo "<br> ID: $this->id <br> TAMAÑO: $this->tamaño <br> CAPACIDAD TOTAL: $this->capacidad <br> CAPACIDAD DISPONIBLE: $libre <br>";
		echo "Detalle de Productos:<br>";
		foreach ($this->arrayProductos as $value)
		{
			$hayProductos = true;
			$value->mostrar();
		}

		if($libre === $this->capacidad)
		{
			echo "EL CONTENEDOR ESTA VACIO<br>";
		}
	}
}

?>