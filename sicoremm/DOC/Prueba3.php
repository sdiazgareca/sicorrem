<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos3.php');

$informe = new Periodos3();
$cobrador = 10;

echo $informe->css;

echo $informe->inicio;
echo $informe->cabecera;

$total1 = $informe->cobrado('<','2011-05-01', '2011-05-03', '2011-06-01',$cobrador, '=', 1);
$total2 = $informe->cobrado('=','2011-05-01', '2011-05-03', '2011-06-01',$cobrador, '=', 1);
$total3 = $informe->cobrado('>','2011-05-01', '2011-05-03', '2011-06-01',$cobrador, '=', 1);

echo $informe->cierre;

echo 'COBRADO '.($total1 + $total2 + $total3);

?>
