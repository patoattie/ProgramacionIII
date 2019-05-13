<?php
	/*Crear una función que reciba como parámetro un string (​$palabra​) y un entero (​$max​).
	La función validará que la cantidad de caracteres que tiene $palabra​ no supere a ​$max​ y además deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas: 
	“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
	1 si la palabra pertenece a algún elemento del listado.
	0 en caso contrario.*/

	function palabraValida($palabra, $max)
	{
		$retorno = 0;
		$validas = array("Recuperatorio", "Parcial", "Programacion");

		if (strlen($palabra) <= $max)
		{
			foreach ($validas as $palabraValida)
			{
				if (strcmp($palabra, $palabraValida) == 0)
				{
					$retorno = 1;
					break;
				}
			}
		}

		return $retorno;
	}

	if (palabraValida($_GET["palabra"], $_GET["max"]) == 1)
	{
		echo "La palabra ingresada es válida";
	}
	else
	{
		echo "La palabra ingresada NO es válida";
	}
?>