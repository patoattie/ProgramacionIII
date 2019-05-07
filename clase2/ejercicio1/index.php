<?php

require_once "producto.php";
require_once "container.php";

$miC = new container(1, "MEDIANO");
$miP = new producto(101, "PRODUCTO 1", "ARCOR S.A.", "MEXICO", 99.5);

$miC->mostrar();
//$miP->mostrar();
$miC->agregarProducto($miP);
$miC->mostrar();

?>