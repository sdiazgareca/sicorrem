<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos_Final.php');
include_once('../CLA/Periodos3.php');
include_once('../CLA/Datos.php');

$dat = new Datos();
$periodos = new Periodos_Final();

$per = explode("-", $_POST['periodo']);

$periodo = $per[2].'-'.$per[1].'-01';
$inicio = $per[2].'-'.$per[1].'-'.$per[0];
$cierre1 = $dat->cambiaf_a_mysql($_POST['cierre1']);
$cierre2 = $dat->cambiaf_a_mysql($_POST['cierre2']);
$cierre3 = $dat->cambiaf_a_mysql($_POST['cierre3']);
/*
echo $periodo.'<br />';
echo $inicio.'<br />';
echo $cierre1.'<br />';
echo $cierre2.'<br />';
echo $cierre3.'<br />';
*/
echo '<a href="FormularioEntregaDocumentos.php?periodo='.$periodo.'&cobrador='.$_POST['cobrador'].'&cierre1='.$cierre1.'&cierre2='.$cierre2.'&cierre3='.$cierre3.'">FORMULARIO DE ENTREGA DE DOCUMENTOS</a>';

echo '<h1>Periodo '.$_POST['periodo'].'</h1>';
echo '<h3>del '.$_POST['cierre1'].' al '.$_POST['cierre3'].'</h3>';



$cobrador_sql = "SELECT cobrador.nombre1, cobrador.apellidos, cobrador.codigo 
                 FROM cobrador 
                 WHERE cobrador.codigo='".$_POST['cobrador']."'";

$query_cobrador = mysql_query($cobrador_sql);

$cobrador = mysql_fetch_array($query_cobrador);


echo '<table class="table2">';
echo '<tr>';
echo '<td><strong>CODIGO</strong></td><td>'.$cobrador['codigo'].'</td>';
echo '<td><strong>APELLIDOS</strong></td><td>'.$cobrador['apellidos'].'</td>';
echo '<td><strong>NOMBRE</strong></td><td>'.$cobrador['nombre1'].'</td>';
echo '</tr>';
echo '</table>';

echo "<br />";

$periodos = new Periodos_Final();
echo '<h1>DETALLE ZONA PERIODO ACTUAL</h1>';
$sumaPeriodoActual = $periodos->entregaActual($periodo, $inicio, $cierre3,$_POST['cobrador'],1);
echo '<table class="table2"><tr><td><strong>TOTAL</strong></td><td>'.$sumaPeriodoActual.'</td></tr></table>';
echo '<br />';
unset($periodos);

$periodos = new Periodos_Final();
echo '<h1>DETALLE COBRADO PERIODO ANTERIOR ZONA</h1>';
$sumaTotalCobrado = $periodos->TotalCobrado($periodo, $inicio, $cierre3,$_POST['cobrador'],1,'<');
echo '<table class="table2"><tr><td><strong>TOTAL</strong></td><td>'.$sumaTotalCobrado.'</td></tr></table>';
unset($periodos);

$periodos = new Periodos_Final();
echo '<h1>DETALLE PENDIENTES PERIODO ANTERIOR ZONA</h1>';
$sumaPeriodoAnterior = $periodos->entregaAnterior($periodo, $inicio, $cierre3,$_POST['cobrador'],1);
echo '<table class="table2"><tr><td><strong>TOTAL</strong></td><td>'.$sumaPeriodoAnterior.'</td></tr></table>';
unset($periodos);

$periodos = new Periodos_Final();
echo '<h1>DETALLE COBRADO PERIODO ANTICIPADO ZONA</h1>';
$sumaAnti = $periodos->TotalCobrado($periodo, $inicio, $cierre3,$_POST['cobrador'],1,'>');
echo '<table class="table2"><tr><td><strong>TOTAL</strong></td><td>'.$sumaAnti.'</td></tr></table>';
unset($periodos);

$totalEntrega = ($sumaPeriodoActual + $sumaTotalCobrado  + $sumaPeriodoAnterior + $sumaAnti);


//PRIMER CIEERE
$periodos = new Periodos_Final();
$primerCierre1 = $periodos->TotalCobrado($periodo, $inicio, $cierre1,$_POST['cobrador'],0,'>');
$primerCierre2 = $periodos->TotalCobrado($periodo, $inicio, $cierre1,$_POST['cobrador'],0,'<');
$primerCierre3 = $periodos->TotalCobrado($periodo, $inicio, $cierre1,$_POST['cobrador'],0,'=');
$primerCierre = $primerCierre1 + $primerCierre2 + $primerCierre3;
unset($periodos);

//SEGUNDO CIEERE
$periodos = new Periodos_Final();
$segundoCierre1 = $periodos->TotalCobrado($periodo, $inicio, $cierre2,$_POST['cobrador'],0,'>');
$segundoCierre2 = $periodos->TotalCobrado($periodo, $inicio, $cierre2,$_POST['cobrador'],0,'<');
$segundoCierre3 = $periodos->TotalCobrado($periodo, $inicio, $cierre2,$_POST['cobrador'],0,'=');
unset($periodos);
$segundoCierre = $segundoCierre1 + $segundoCierre2 + $segundoCierre3;

//TERCERO CIEERE
$periodos = new Periodos_Final();
$tercerCierre1 = $periodos->TotalCobrado($periodo, $inicio, $cierre3,$_POST['cobrador'],0,'>');
$tercerCierre2 = $periodos->TotalCobrado($periodo, $inicio, $cierre3,$_POST['cobrador'],0,'<');
$tercerCierre3 = $periodos->TotalCobrado($periodo, $inicio, $cierre3,$_POST['cobrador'],0,'=');

$tercerCierre = $tercerCierre1 + $tercerCierre2 + $tercerCierre3;
unset($periodos);

echo '<h1>RESUMEN</h1>';
echo '<table class="table2">';

echo '<tr>';
echo '<th></th>';
echo '<th>TOTAL</th>';
echo '<th>PORCENTAJE</th>';
echo '</tr>';

echo '<tr>';
echo '<td><strong>ENTREGA</strong></td>';
echo '<td>'.$totalEntrega.'</td>';
echo '<td>100%</td>';
echo '</tr>';

echo '<tr>';
echo '<td><strong>CIERRE 1</strong></td>';
echo '<td>'.$primerCierre.'</td>';
echo '<td>'.round($primerCierre * 100 /$totalEntrega).'%</td>';
echo '</tr>';

echo '<tr>';
echo '<td><strong>CIERRE 2</strong></td>';
echo '<td>'.$segundoCierre.'</td>';
echo '<td>'.round($segundoCierre * 100 /$totalEntrega).'%</td>';
echo '</tr>';

echo '<tr>';
echo '<td><strong>CIERRE 3</strong></td>';
echo '<td>'.$tercerCierre.'</td>';
echo '<td>'.round($tercerCierre * 100 /$totalEntrega).'%</td>';
echo '</tr>';

echo '</table>';


?>
