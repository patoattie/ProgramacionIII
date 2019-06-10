<?php
require_once("helado.php");

class ConsultarHelado
{
    public static function consultaHelado($tipo, $sabor, $cantidad)
    {
		if(Helado::validarTipo($tipo) == 1)
		{
            $arrayHelados = Helado::leerHelados("archivos/helados.txt");
            $otroTipo = "";
    
            if(strtolower($tipo) == "crema")
            {
                $otroTipo = "agua";
            }
            else
            {
                $otroTipo = "crema";
            }
    
            if(!Helado::hayStockTipoSabor($arrayHelados, $tipo, $sabor, $cantidad))
            {
                if(!Helado::hayStockTipoSabor($arrayHelados, $otroTipo, $sabor, $cantidad))
                {
                    echo "<br>NO HAY $tipo - $sabor - $cantidad<br>";
                }
                else
                {
                    echo "<br>NO HAY $tipo - $sabor - $cantidad PERO SI HAY $otroTipo - $sabor - $cantidad<br>";
                }
            }
            else
            {
                echo "<br>SI HAY $tipo - $sabor - $cantidad<br>";
            }
        }
		else
		{
			echo "<br>Tipo de Helado incorrecto. Ingresó $tipo pero debe ser CREMA o AGUA";
		}
    }
}
?>