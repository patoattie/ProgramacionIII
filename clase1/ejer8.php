<?php
	/*Realizar un programa que en base al valor numérico de la variable $num, pueda mostrarse por
	pantalla, el nombre del número que tenga dentro escrito con palabras, para los números entre
	el 20 y el 60.
	Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.*/

	$num = $_GET["num"];
	$numletra = "";
	$esVeinte = false;

	if ($num >= 20 && $num <= 60)
	{
		switch (substr($num, 0, 1))
		{
			case '2':
				$numletra = "veint";
				$esVeinte = true;
				break;
			case '3':
				$numletra = "treinta";
				break;
			case '4':
				$numletra = "cuarenta";
				break;
			case '5':
				$numletra = "cincuenta";
				break;
			case '6':
				$numletra = "sesenta";
				break;
		}

		switch (substr($num, 1, 1))
		{
			case '0':
				if($esVeinte)
				{
					$numletra = $numletra."e";
				}
				break;
			case '1':
				if($esVeinte)
				{
					$numletra = $numletra."iuno";
				}
				else
				{
					$numletra = $numletra." y uno";
				}
				break;
			case '2':
				if($esVeinte)
				{
					$numletra = $numletra."idos";
				}
				else
				{
					$numletra = $numletra." y dos";
				}
				break;
			case '3':
				if($esVeinte)
				{
					$numletra = $numletra."itres";
				}
				else
				{
					$numletra = $numletra." y tres";
				}
				break;
			case '4':
				if($esVeinte)
				{
					$numletra = $numletra."icuatro";
				}
				else
				{
					$numletra = $numletra." y cuatro";
				}
				break;
			case '5':
				if($esVeinte)
				{
					$numletra = $numletra."icinco";
				}
				else
				{
					$numletra = $numletra." y cinco";
				}
				break;
			case '6':
				if($esVeinte)
				{
					$numletra = $numletra."iseis";
				}
				else
				{
					$numletra = $numletra." y seis";
				}
				break;
			case '7':
				if($esVeinte)
				{
					$numletra = $numletra."isiete";
				}
				else
				{
					$numletra = $numletra." y siete";
				}
				break;
			case '8':
				if($esVeinte)
				{
					$numletra = $numletra."iocho";
				}
				else
				{
					$numletra = $numletra." y ocho";
				}
				break;
			case '9':
				if($esVeinte)
				{
					$numletra = $numletra."inueve";
				}
				else
				{
					$numletra = $numletra." y nueve";
				}
				break;
		}

		echo "$num en letras: $numletra";
	}
	else
	{
		echo "El número debe estar comprendido entre el 20 y el 60.";
	}

?>