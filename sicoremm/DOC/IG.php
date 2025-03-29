<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos_Final.php');


$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador WHERE codigo != 10 AND codigo != 33";
$query=mysql_query($sql);

//ENERO
/*
$periodo = '2011-01-01';
$periodo1 ='2011-01-04';
$periodo2='2011-02-01';
*/

//FEBRERO
/*
$periodo = '2011-02-01';
$periodo1 ='2011-02-02';
$periodo2='2011-03-01';
*/

//MARZO
/*
$periodo = '2011-03-01';
$periodo1 ='2011-03-02';
$periodo2='2011-04-01';
*/
//ABRIL
/*
$periodo = '2011-04-01';
$periodo1 ='2011-04-04';
$periodo2='2011-05-02';
*/

//JUNIO
/*
$periodo = '2011-06-01';
$periodo1 ='2011-06-02';
$periodo2='2011-07-01';
*/

// MAYO

$periodo = '2011-05-01';
$periodo1 ='2011-05-03';
$periodo2='2011-06-01';


echo '<h1>Periodo '.$periodo.' <br />del '.$periodo1.' <br />al '.$periodo2.'</h1>';
   

while($cob = mysql_fetch_array($query)){

$periodos = new Periodos_Final();

$sumaPeriodoActual = $periodos->entregaActual($periodo, $periodo1, $periodo2,$cob['codigo'],0);
$sumaPeriodoAnterior1 = $periodos->entregaAnterior($periodo, $periodo1, $periodo2,$cob['codigo'],0);
$sumaPeriodoAnterior2 = $periodos->TotalCobrado($periodo, $periodo1, $periodo2,$cob['codigo'],0,'<');
$sumaPeriodoAnticipado = $periodos->TotalCobrado($periodo, $periodo1, $periodo2,$cob['codigo'],0,'>');
$entregaAnterior = $sumaPeriodoAnterior1 + $sumaPeriodoAnterior2;
$sumaEntrega = $entregaAnterior + $sumaPeriodoActual + $sumaPeriodoAnticipado;

$totalCobradoActual = $periodos->TotalCobrado($periodo, $periodo1, $periodo2,$cob['codigo'],0,'=');
$totalCobrado = $totalCobradoActual + $sumaPeriodoAnterior2 + $sumaPeriodoAnticipado;

    echo '<h3>'.$cob['nombre1'].' '.$cob['apellidos'].'</h3>';
    echo $periodos->table;
    echo $periodos->cabecera;
    
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.$entregaAnterior.'</td><td>'.$sumaPeriodoAnterior2.'</td><td>&zwj;</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.($sumaPeriodoActual + $sumaPeriodoAnticipado).'</td><td>'.($totalCobradoActual + $sumaPeriodoAnticipado).'</td><td>&zwj;</td></tr>';
    //echo '<tr><td><strong>ANTICIPADO</strong></td><td>0</td><td>'.$sumaPeriodoAnticipado.'</td><td>&zwj;</td></tr>';
    echo '<tr><td></td></td><td>'.$sumaEntrega.'</td><td>'.$totalCobrado.'</td><td>&zwj;</td></tr>';
    echo $periodos->table_cierre;

    unset($periodos);
}


$sql2 ="SELECT codigo, descripcion FROM f_pago WHERE codigo != 600";
$query2 = mysql_query($sql2);

while($oficina = mysql_fetch_array($query2)){

    $periodos = new Periodos_Final();

    $sumaPeriodoActualCobrado = $periodos->TotalCobradoOficina($periodo, $periodo1, $periodo2,10,0,'=',$oficina['codigo']);
    $oficinaCobrad_Actual = $periodos->entregaActualOficina($periodo, $periodo1, $periodo2,10,0,$oficina['codigo']);
    $sumaPeriodoAnterior1 = $periodos->entregaAnteriorOficina($periodo, $periodo1, $periodo2,10,0,$oficina['codigo']);
    $sumaPeriodoAnterior2 = $periodos->TotalCobradoOficina($periodo, $periodo1, $periodo2,10,0,'<',$oficina['codigo']);
    $entregaAnterior = $sumaPeriodoAnterior1 + $sumaPeriodoAnterior2;

    echo '<h3>'.$oficina['descripcion'].'</h3>';
    echo $periodos->table;
    echo $periodos->cabecera;

    echo '<tr><td><strong>ACTUAL</strong></td><td>'.$oficinaCobrad_Actual.'</td><td>'.$sumaPeriodoActualCobrado.'</td><td>&zwj;</td></tr>';
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.$entregaAnterior.'</td><td>'.$sumaPeriodoAnterior2.'</td><td>&zwj;</td></tr>';
    echo '<tr><td></td></td><td>'.($oficinaCobrad_Actual + $entregaAnterior).'</td><td>'.($sumaPeriodoAnterior2 + $sumaPeriodoActualCobrado).'</td><td>&zwj;</td></tr>';
    echo $periodos->table_cierre;

    unset($periodos);
}


 ?>

