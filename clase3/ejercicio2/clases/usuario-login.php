<?php
require_once("usuario.php");

class UsuarioLogin
{
	public static function altaUsuario($email, $clave, $alias)
	{
		$usuario = new Usuario($email, $clave, $alias);
		Usuario::guardarUsuario($usuario);
		echo "<br>Se dio de alta el Usuario $alias - $email<br>";
	}

	public static function ingresoUsuario($email, $clave)
	{
		$usuarioValido = Usuario::obtenerUsuario($email, $clave);

		if (is_null($usuarioValido))
		{
			echo "<br>El usuario ingresado no existe<br>";
		}
		else
		{
			
		}
	}
}
?>