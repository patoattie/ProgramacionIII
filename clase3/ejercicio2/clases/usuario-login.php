<?php
require_once("usuario.php");

class UsuarioLogin
{
	public static function altaUsuario($email, $clave, $alias)
	{
		$usuario = new Usuario($email, $clave, $alias);
		$usuario->guardarAlta();
		echo "<br>Se dio de alta el Usuario $alias - $email<br>";
	}

	public static function ingresoUsuario($email, $clave)
	{
		$usuarioValido = UsuarioLogin::obtenerUsuario($email, $clave);

		if (is_null($usuarioValido))
		{
			echo "<br>El usuario ingresado no existe<br>";
		}
		else
		{
			$usuarioValido->guardarIngreso();
			echo "<br>Bienvenido " . $usuarioValido->getAlias() . "<br>";
		}
	}

	public static function obtenerUsuario($email, $clave)
	{
		$usuarioValido = null;

		foreach (Usuario::leerUsuarios() as $usuario)
		{
			if ($usuario->getEmail() === $email && $usuario->getClave() === $clave)
			{
				$usuarioValido = $usuario;
				break;
			}
		}

		return $usuarioValido;
	}
}
?>