<?php

class producto
{
	private $_id;
	private $_nombre;
	private $_importador;
	private $_paisOrigen;
	private $_kilos;

	public function __construct()
	{
		$this->_id = 1;
		$this->_nombre = "PRODUCTO 1";
		$this->_importador = "ARCOR S.A.";
		$this->_paisOrigen = "MEXICO";
		$this->_kilos = 100;
	}

	public function mostrar()
	{
		echo "<br> ID: $this->_id <br> NOMBRE: $this->_nombre <br> IMPORTADOR: $this->_importador <br> PAIS DE ORIGEN: $this->_paisOrigen <br> KILOS: $this->_kilos <br>";
	}
}

?>