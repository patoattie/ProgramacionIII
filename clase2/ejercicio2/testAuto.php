<?php
	/*En testAuto.php :
	● Crear dos objetos “Auto” de la misma marca y distinto color.
	● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
	● Crear un objeto “Auto” utilizando la sobrecarga restante.
	● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500 al atributo precio.
	● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado obtenido.
	● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
	● Utilizar el método de clase “ MostrarAuto ” para mostrar cada los objetos impares (1, 3, 5)*/

	//● Crear dos objetos “Auto” de la misma marca y distinto color.
	$auto1 = new Auto("azul", 110, "ford", "01/03/2018");
	$auto2 = new Auto("rojo", 120, "ford", "10/03/2018");
?>