<?php

class container
{
	private $_id;
	private $_tamaño;
	private $_capacidad;

	public function __construct()
	{
		$this->_id = 100;
		$this->_tamaño = "GRANDE";
		$this->_capacidad = 2500;
	}

	public function mostrar()
	{
		echo "<br> ID: $this->_id <br> TAMAÑO: $this->_tamaño <br> CAPACIDAD: $this->_capacidad <br>";
	}
}

?>