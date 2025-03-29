<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos.php');

$periodos = new Periodos();

//FEBRERO
/*
$periodo = '2011-02-01';
$periodo1 ='2011-02-02';
$periodo2='2011-03-01';
*/


//ENERO
/*
$periodo = '2011-01-01';
$periodo1 ='2011-01-04';
$periodo2='2011-02-01';
*/

//JUNIO
/*
$periodo = '2011-06-01';
$periodo1 ='2011-06-02';
$periodo2='2011-07-01';
*/



// MAYO
$periodo = '2011-06-01';
$periodo1 ='2011-06-02';
$periodo2='2011-07-01';


$cob=16;

echo '<h1>Periodo '.$periodo.' <br />del '.$periodo1.' <br />al '.$periodo2.'</h1>';

$sumaPeriodoActual = $periodos->entregaActual($periodo, $periodo1, $periodo2,$cob,1);
echo '<h3>'.$sumaPeriodoActual.'</h3>';


echo '<h3>Entrega Periodo Anterior</h3>';
$sumaPeriodoAnterior = $periodos->entregaAnterior($periodo, $periodo1, $periodo2,$cob,1);
echo '<h3>'.$sumaPeriodoAnterior.'</h3>';

/*
echo '<h3>Total Cobrado periodo Actual</h3>';
$sumaTotalCobrado = $periodos->TotalCobrado($periodo, $periodo1, $periodo2, 16,1,'=');
echo '<h3>'.$sumaTotalCobrado.'</h3>';
*/


echo '<h3>Total Cobrado periodo ANTERIOR</h3>';
$sumaTotalCobrado = $periodos->TotalCobrado($periodo, $periodo1, $periodo2,$cob,1,'<');
echo $sumaTotalCobrado;

echo '<h3>Total Cobrado periodo ANTICIPADO</h3>';
$sumaTotalCobrado = $periodos->TotalCobrado($periodo, $periodo1, $periodo2,$cob,1,'>');
echo $sumaTotalCobrado;


/*
echo '<h3>Resumen</h3>';
echo $periodos->table;
echo '<tr><td><strong>TOTAL PERIODO ACTUAL</strong></td><td>'.number_format($sumaPeriodoActual,0,',','.').'</td></tr>';
echo '<tr><td><strong>TOTAL PERIODO ANETRIOR</strong></td><td>'.number_format($sumaPeriodoAnterior,0,',','.').'</td></tr>';
echo '<tr><td><strong>TOTAL ENTREGADO</strong></td><td>'.number_format($sumaPeriodoActual+$sumaPeriodoAnterior,0,',','.').'</td></tr>';
echo $periodos->table_cierre;

 */
?>

