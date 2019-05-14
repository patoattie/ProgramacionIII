<?php
	/*Realizar una clase llamada “Auto” que posea los siguientes atributos privados :
	_color (String)
	_precio (Double)
	_marca (String).
	_fecha (DateTime)
	Realizar un constructor capaz de poder instanciar objetos pasándole todos los parámetros:
	Realizar un método de instancia llamado “ AgregarImpuestos”, que recibirá un doble por
	parámetro y que se sumará al precio del objeto.
	Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
	por parámetro y que mostrará todos los atributos de dicho objeto.
	Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto” . Sólo
	devolverá TRUE si ambos “Autos” son de la misma marca.
	Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
	de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
	la suma de los precios o cero si no se pudo realizar la operación.
	Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);*/

	class Auto
	{
		private $_color;
		private $_precio;
		private $_marca;
		private $_fecha;

		public function __construct($_color, $_precio, $_marca, $_fecha)
		{
			$this->_color = (string)$_color;
			$this->_precio = (double)$_precio;
			$this->_marca = (string)$_marca;
			$this->_fecha = new DateTime($_fecha);
		}

		public function aregarImpuestos($impuesto)
		{
			$this->_precio += (double)$impuesto;
		}

		public static function mostrarAuto($auto)
		{
			echo "Color: $this->_color <br>";
			echo "Precio: $this->_precio <br>";
			echo "Marca: $this->_marca <br>";
			echo "Fecha: $this->_fecha.format('d/m/Y') <br>";
		}

		public function equals($auto)
		{
			$retorno = false;

			if (strcmp($this->_marca, $auto->_marca) == 0)
			{
				$retorno = true;
			}

			return $retorno;
		}

		public static function add($autoUno, $autoDos)
		{
			$retorno = (double)0;

			if (strcmp($autoUno->_marca, $autoDos->_marca) == 0 && strcmp($autoUno->_color, $autoDos->_color) == 0)
			{
				$retorno = $autoUno->_precio + $autoDos->_precio;
			}

			return $retorno;
		}
	}
?>