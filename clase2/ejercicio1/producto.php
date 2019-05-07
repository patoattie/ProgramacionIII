<?php

class producto
{
	private $id;
	private $nombre;
	private $importador;
	private $paisOrigen;
	private $kilos;

	public function __construct($id, $nombre, $importador, $paisOrigen, $kilos)
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->importador = $importador;
		$this->paisOrigen = $paisOrigen;
		$this->kilos = $kilos;
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