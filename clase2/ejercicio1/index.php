<?php

require_once "producto.php";
require_once "container.php";

$miC = new container(1, "mediano");
$miP = new producto(101, "PRODUCTO 1", "ARCOR S.A.", "MEXICO", 99.5);
$miP2 = new producto(101, "PRODUCTO 1", "ARCOR S.A.", "BRASIL", 100);
$miP3 = new producto(102, "PRODUCTO 2", "COTO C.I.C.S.A.", "CHINA", 500);

$miC->mostrar();
//$miP->mostrar();
$miC->agregarProducto($miP);
$miC->agregarProducto($miP2);
$miC->agregarProducto($miP3);
$miC->mostrar();

?>