<?php
	/*Escribir un programa que use la variable $operador que pueda almacenar los símbolos
	matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
	símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
	resultado por pantalla.*/

	$operador = $_GET["operador"];
	$op1 = (float)$_GET["op1"];
	$op2 = (float)$_GET["op2"];

	switch ($operador)
	{
		case " ":
			echo "$op1 + $op2 = ".($op1 + $op2);
			break;
		case "-":
			echo "$op1 - $op2 = ".($op1 - $op2);
			break;
		case "*":
			echo "$op1 * $op2 = ".($op1 * $op2);
			break;
		case "/":
			if($op2 != 0.0)
			{
				echo "$op1 / $op2 = ".($op1 / $op2);
			}
			else
			{
				echo "ERROR: Division por cero";
			}
			break;
		
		default:
			echo "ERROR: El operador debe ser ‘+’, ‘-’, ‘/’ y ‘*’";
			break;
	}
?>