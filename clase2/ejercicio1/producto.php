<?php

class producto
{
	private $id;
	private $nombre;
	private $importador;
	private $paisOrigen;
	private $kilos;

	public function __construct()
	{
		$this->id = 101;
		$this->nombre = "PRODUCTO 1";
		$this->importador = "ARCOR S.A.";
		$this->paisOrigen = "MEXICO";
		$this->kilos = 100;
	}

	public function mostrar()
	{
		echo "<br> ID: $this->id <br> NOMBRE: $this->nombre <br> IMPORTADOR: $this->importador <br> PAIS DE ORIGEN: $this->paisOrigen <br> KILOS: $this->kilos <br>";
	}

	public function getKilos()
	{
		return $this->kilos;
	}
}

?>