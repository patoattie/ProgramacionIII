<?php
	/*Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
	distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
	año es. Utilizar una estructura selectiva múltiple.*/

	$fecha = date("d/m/Y");
	$mes = date("m");
	$estacion = "";

	switch ($mes) {
		case 1:
		case 2:
		case 3:
			$estacion = "Verano";
			break;
		case 4:
		case 5:
		case 6:
			$estacion = "Otoño";
			break;
		case 7:
		case 8:
		case 9:
			$estacion = "Invierno";
			break;
		case 10:
		case 11:
		case 12:
			$estacion = "Primavera";
			break;
	}

	echo "Fecha del sistema: $fecha <br>";
	echo "Estación: $estacion";
?>