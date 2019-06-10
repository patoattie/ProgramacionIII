<?php
	date_default_timezone_set("America/Argentina/Buenos_Aires");

	$metodo = $_SERVER["REQUEST_METHOD"];

	switch ($metodo)
	{
		case "GET":
			switch ($_GET["accion"])
			{
				case "consulta":
					require_once("clases/consultar-helado.php");

					ConsultarHelado::consultaHelado($_GET["tipo"], $_GET["sabor"], $_GET["cantidad"]);
					break;
			}
			break;
		case "POST":
			switch ($_POST["accion"])
			{
				case "carga":
					require_once("clases/helado-carga.php");

					HeladoCarga::altaHelado($_POST["tipo"], $_POST["sabor"], $_POST["stock"], $_POST["precio"]);
					break;
				case "ingreso":
					UsuarioLogin::ingresoUsuario($_POST["email"], $_POST["clave"]);
					break;
				default:
					# code...
					break;
			}
			break;
		case "PUT":
			parse_str(file_get_contents("php://input"), $_PUT);
			var_dump($_PUT);
			break;
		default:
			echo "Se invoco al metodo HTTP: $metodo";
			break;
	}
?>