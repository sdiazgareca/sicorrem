<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Emision.php');
include_once('../CLA/Datos.php');


/* Fechas */

$fecha = new Datos();
$pero = explode('-',$_POST['periodo3']);
$periodo = $pero[1].'-'.$pero[0].'-01';

$ani_periodo=$pero[1];
$mes_periodo=$pero[0];

$desde = $fecha->cambiaf_a_mysql($_POST['del3']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al3']);


echo '<h1>Informe de Emision Periodo '.$_POST['periodo3'].'</h1>';

/* Informacion de Cobradores */

$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador WHERE codigo != 10";
$query=mysql_query($sql);

echo '<table class="table2">';
echo '<tr>
      <th></th>
      <th><strong>ACTUAL</strong></th>
      <th><strong>ANTERIOR</strong></th>
      <th><strong>TOTAL</strong></th>
      </tr>';


while($cob = mysql_fetch_array($query)){

$informe = new Emision();

$anterior = $informe->pendiente($periodo, $desde, $hasta, $cob['codigo'],0,0);
$anterior_1 = $informe->pendiente_pag($periodo, $desde, $hasta, $cob['codigo']);

$actual = $informe->actual($periodo, $desde, $hasta, $cob['codigo']);

    echo '<tr>';
    echo '<td><h2>'.strtoupper($cob['nombre1'].' '.$cob['apellidos']).'</h2></td>';
    echo '<td>'.number_format($actual,0,',','.').'</td>';
    echo '<td>'.number_format( ($anterior_1 + $anterior),0,',','.').'</td>';
    echo '<td>'.number_format( ($actual + $anterior_1 + $anterior),0,',','.').'</td>';
    echo '</tr>';
    
unset($informe);    
}

$oficina = "SELECT codigo, descripcion FROM f_pago WHERE codigo != 600";
$query_ofi = mysql_query($oficina);

while($ofi = mysql_fetch_array($query_ofi)){

    if($ofi['descripcion'] == 'DESCUENTO_POR_PLANILLA'){
        $off = 'CONVENIOS';
    }
    else if($ofi['descripcion'] == 'COBRO DOMICILIARIO'){
        $off = 'OFICINA';
    }
    else{
        $off = strtoupper($ofi['descripcion']);
    }

$informe = new Emision();

$actual_offi = $informe->actual_fp($periodo, $desde, $hasta,10,$ofi['codigo']);
$anterior_offi = $informe->pendiente_fp($periodo, $desde, $hasta, 10, 0, 0, $ofi['codigo']);
$anterior_offi_1 = $informe->pendiente_pag_fpago($periodo, $desde, $hasta,10,$ofi['codigo']);

    echo '<tr>';
    echo '<td><h2>'.$off.'</h2></td>';
    echo '<td>'.number_format($actual_offi,0,',','.').'</td>';
    echo '<td>'.number_format( ($anterior_offi_1 + $anterior_offi),0,',','.').'</td>';
    echo '<td>'.number_format( ($actual_offi + $anterior_offi_1 + $anterior_offi),0,',','.').'</td>';
    echo '</tr>';

    unset ($informe);

}
echo '<table>';
?>
