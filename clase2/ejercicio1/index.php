<?php

require_once "producto.php";
require_once "container.php";

$miC = new container();
$miP = new producto();

$miC->mostrar();
//$miP->mostrar();
$miC->agregarProducto($miP);
$miC->mostrar();

?>