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
    
            if(Helado::hayStockRemanente($arrayHelados, $tipo, $sabor, $cantidad) < 0)
            {
                if(Helado::hayStockRemanente($arrayHelados, $otroTipo, $sabor, $cantidad) < 0)
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