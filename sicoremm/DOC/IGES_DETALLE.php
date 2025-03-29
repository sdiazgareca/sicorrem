<?php


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/IGES_FAC_DETALLE.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Fecha_1.php');


$feh = new Fecha_1('01-'.$_POST['periodo90']);
echo '<h3>INFORME DE GESTION PERIODO '.strtoupper($feh->mes_palabras).' '.$feh->anio.'</h3>';



// FEHCAS
$fecha = new Datos();
$pero = explode('-',$_POST['periodo90']);
$periodo = $pero[1].'-'.$pero[0].'-01';
$ani_periodo=$pero[1];
$mes_periodo=$pero[0];
$desde = $fecha->cambiaf_a_mysql($_POST['del90']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al90']);




//CONVENIOS
echo '<h3>CONVENIOS</h3>';

    $informe = new Periodos3();

    echo '<table>';
    echo '<caption>ENTREGA ANTERIOR</caption>';
    echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>";
    $entregaAnt = $informe->convenios_ofi_pendiente($periodo,$desde,$hasta,10,'400');
    $reco_anteri = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'<','=','400');
     echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($entregaAnt + $reco_anteri)."</td></tr>";
    echo '</table>';

    echo '<br /><br />';
    echo '<table>';
    echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>";
    echo '<caption>COBRADO ANTERIOR</caption>';
    $reco_anteri = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'<','=','400');
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($reco_anteri)."</td></tr>";
    echo '</table>';

    echo '<br /><br />';
    echo '<table>';
    echo '<caption>ENTREGA ACTUAL</caption>';
    echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>";
    $ent_actual1 = $informe->convenios_entrega_pen($periodo, $desde, $hasta,10, $dev,'=','=','400');
    $ent_actual2 = $informe->convenio_entrega_cob($periodo, $desde, $hasta,10, $dev,'=','=','400');
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($ent_actual1 +$ent_actual2)."</td></tr>";
    echo '</table>';
  
    
    echo '<br /><br />';
    echo '<table>';
    echo '<caption>COBRADO ACTUAL</caption>';
    echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>";
    $reco_actual = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'=','=','400');
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($reco_actual)."</td></tr>";
    echo '</table>';
    
    echo '<br /><br />';
    echo '<table>';
        echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>";
    echo '<caption>ENTREGA ENTICIPADO ACTUAL</caption>';
    $anticipado = $informe->ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','=',$oficina['codigo']);
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($anticipado)."</td></tr>";
    echo '</table>';
/*
        echo '<br /><br />';
    echo '<table>';
    echo '<caption>MOROSO</caption>';
        echo "<tr><td>CONVENIO</td><td>TITULAR</td><td>CONT</td><td>N DOCUMENTO</td><td>PERIODO</td><td>IMPORTE</td><td>FECHA DE PAGO</td></tr>"; 
     $anti_moros1 = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','!=','400');
     echo "<tr><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".($anti_moros1)."</td></tr>";
     echo '</table>';
*/





?>

