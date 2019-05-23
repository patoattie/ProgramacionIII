<?php
	require_once("clases/usuario-login.php");
	date_default_timezone_set("America/Argentina/Buenos_Aires");

	$metodo = $_SERVER["REQUEST_METHOD"];

	switch ($metodo)
	{
		case "GET":
			break;
		case "POST":
			switch ($_POST["accion"])
			{
				case "alta":
					UsuarioLogin::altaUsuario($_POST["email"], $_POST["clave"], $_POST["alias"]);
					break;
				case "ingreso":
					UsuarioLogin::ingresoUsuario($_POST["email"], $_POST["clave"]);
					break;
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