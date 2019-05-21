<?php
class ManejadorArchivos
{
	public static function cambiarNombre($archivoOrigen, $nombreNuevo)
	{
		$archivoDestino = pathinfo($archivoOrigen, PATHINFO_DIRNAME) . "/" . $nombreNuevo . "." . pathinfo($archivoOrigen, PATHINFO_EXTENSION);
		return $archivoDestino;
	}

	public static function hacerBackup($archivo)
	{
		copy($archivo, "backup/" . pathinfo($archivo, PATHINFO_FILENAME) . "_" . date("YmdHis") . "." . pathinfo($archivo, PATHINFO_EXTENSION));
	}
}
?>