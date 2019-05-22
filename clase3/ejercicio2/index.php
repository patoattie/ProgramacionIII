<?php
	date_default_timezone_set("America/Argentina/Buenos_Aires");

	$metodo = $_SERVER["REQUEST_METHOD"];

	switch ($metodo)
	{
		case "GET":
			break;
		case "POST":
			switch ($_POST["accion"])
			{
				default:
					# code...
					break;
			}
			break;
		default:
			echo "Se invoco al metodo HTTP: $metodo";
			break;
	}
?>