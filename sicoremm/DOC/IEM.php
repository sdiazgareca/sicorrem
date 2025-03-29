<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos3.php');
include_once('../CLA/Datos.php');

$totalMonto1 =0;
$totalMonto2 =0;
$totalMonto3 =0;

$fecha = new Datos();
$periodo = explode("-",$_POST['periodo3']);
$mes_periodo = $periodo[0];
$ani_periodo = $periodo[1];

$mysql_periodo = $ani_periodo.'-'.$mes_periodo.'-01';

$desde = $fecha->cambiaf_a_mysql($_POST['del3']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al3']);


$sql = "SELECT cobrador.codigo, CONCAT(cobrador.apellidos,' ',cobrador.nombre1) AS cobrador
        FROM cobrador where codigo !=10";

$query = mysql_query($sql);

echo '<table  class="table2">';

    echo '<tr>
            <th></th>
            <th><strong>ACTUAL</strong></th>
            <th><strong>ANTERIOR</strong></th>
            <th><strong>TOTAL</strong></th>';


    echo '</tr>';


while($infor = mysql_fetch_array($query)){

    $pen = new Periodos3();
    $monto1 = $pen->cobrado('=', $mysql_periodo, $desde, $hasta,$infor['codigo'],'=',0);
    $monto2 = $pen->pendiente2($mysql_periodo, $desde, $hasta, $infor['codigo'],0,0,'=');
    $monto3 = $pen->pendiente2($mysql_periodo, $desde, $hasta, $infor['codigo'],0,0,'<');
    //$monto2 = $pen->pagos_anticipados($infor['codigo'], $ani_periodo, $mes_periodo, $desde);
    //$monto2 = $pen->cobrado('=',$ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta,$infor['codigo'],'=',0);
    echo '<tr>
            <td><strong>'.strtoupper($infor['cobrador']).'</strong></td>
            <td>'.number_format( ($monto1 + $monto2),0,',','.').'</td>
            <td>'.number_format($monto3,0,',','.').'</td>
            <td>'.number_format(($monto1 + $monto2 + $monto3),0,',','.').'</td>';
    echo '</tr>';

    $totalMonto1 = $totalMonto1 + ($monto1 + $monto2);
    $totalMonto2 = $totalMonto2 + $monto3;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2 + $monto3);
    unset($pen);
}


//PAC
$pen = new Periodos3();
$monto1 = $pen->emitido_pen_fp(10,$ani_periodo,$mes_periodo,100);
$monto2 = $pen->pendiente3($mysql_periodo, $desde, $hasta,10,0,0,'<',100);
//$monto2 = $pen->cobrado_fp($ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta, 10,0,92,'=');

echo '<tr>';
echo '<td><strong>PAC</strong></td>';
echo '<td>'.number_format($monto1,0,',','.').'</td>';
echo '<td>'.number_format($monto2,0,',','.').'</td>';
echo '<td>'.number_format( ($monto1 + $monto2) ,0,',','.').'</td>';
echo '</tr>';

    $totalMonto1 = $totalMonto1 + $monto1;
    $totalMonto2 = $totalMonto2 + $monto2;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2);

unset($pen);

//TC
$pen = new Periodos3();
$monto1 = $pen->emitido_pen_fp(10,$ani_periodo,$mes_periodo,200);
$monto2 = $pen->pendiente3($mysql_periodo, $desde, $hasta,10,0,0,'<',200);
//$monto2 = $pen->cobrado_fp($ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta, 10,0,92,'=');

echo '<tr>';
echo '<td><strong>TC</strong></td>';
echo '<td>'.number_format($monto1,0,',','.').'</td>';
echo '<td>'.number_format($monto2,0,',','.').'</td>';
echo '<td>'.number_format( ($monto1 + $monto2) ,0,',','.').'</td>';
echo '</tr>';

    $totalMonto1 = $totalMonto1 + $monto1;
    $totalMonto2 = $totalMonto2 + $monto2;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2);

unset($pen);

//CONVENIO
$pen = new Periodos3();
$monto1 = $pen->emitido_pen_fp(10,$ani_periodo,$mes_periodo,400);
$monto2 = $pen->pendiente3($mysql_periodo, $desde, $hasta,10,0,0,'<',400);
//$monto2 = $pen->cobrado_fp($ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta, 10,0,92,'=');

echo '<tr>';
echo '<td><strong>CONVENIO</strong></td>';
echo '<td>'.number_format($monto1,0,',','.').'</td>';
echo '<td>'.number_format($monto2,0,',','.').'</td>';
echo '<td>'.number_format( ($monto1 + $monto2) ,0,',','.').'</td>';
echo '</tr>';

    $totalMonto1 = $totalMonto1 + $monto1;
    $totalMonto2 = $totalMonto2 + $monto2;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2);

unset($pen);

//TRANSFERENCIA
$pen = new Periodos3();
$monto1 = $pen->emitido_pen_fp(10,$ani_periodo,$mes_periodo,500);
$monto2 = $pen->pendiente3($mysql_periodo, $desde, $hasta,10,0,0,'<',500);
//$monto2 = $pen->cobrado_fp($ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta, 10,0,92,'=');

echo '<tr>';
echo '<td><strong>TRANSFERENCIA</strong></td>';
echo '<td>'.number_format($monto1,0,',','.').'</td>';
echo '<td>'.number_format($monto2,0,',','.').'</td>';
echo '<td>'.number_format( ($monto1 + $monto2) ,0,',','.').'</td>';
echo '</tr>';

    $totalMonto1 = $totalMonto1 + $monto1;
    $totalMonto2 = $totalMonto2 + $monto2;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2);

unset($pen);

//OFICINA
$pen = new Periodos3();
$monto1 = $pen->emitido_pen_fp(10,$ani_periodo,$mes_periodo,300);
$monto2 = $pen->pendiente3($mysql_periodo, $desde, $hasta,10,0,0,'<',300);
//$monto2 = $pen->cobrado_fp($ani_periodo.'-'.$mes_periodo.'-01', $desde, $hasta, 10,0,92,'=');

echo '<tr>';
echo '<td><strong>OFICINA</strong></td>';
echo '<td>'.number_format($monto1,0,',','.').'</td>';
echo '<td>'.number_format($monto2,0,',','.').'</td>';
echo '<td>'.number_format( ($monto1 + $monto2) ,0,',','.').'</td>';
echo '</tr>';

    $totalMonto1 = $totalMonto1 + $monto1;
    $totalMonto2 = $totalMonto2 + $monto2;
    $totalMonto3 = $totalMonto3 + ($monto1 + $monto2);


unset($pen);

echo '<tr>';
echo '<th><strong>TOTAL</strong></th>';
echo '<th><strong>'.number_format($totalMonto1,0,',','.').'</strong></th>';
echo '<th><strong>'.number_format($totalMonto2,0,',','.').'</strong></th>';
echo '<th><strong>'.number_format($totalMonto3 ,0,',','.').'</strong></th>';
echo '</tr>';


echo '</table>';
unset($pen);