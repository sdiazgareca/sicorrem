<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Periodos3.php');
//include_once('../CLA/Periodos.php');
include_once('../CLA/Datos.php');

$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador WHERE codigo != 10";
$query=mysql_query($sql);

$fecha = new Datos();

$pero = explode('-',$_POST['periodo22']);

$periodo = $pero[1].'-'.$pero[0].'-01';

$ani_periodo=$pero[1];
$mes_periodo=$pero[0];

$desde = $fecha->cambiaf_a_mysql($_POST['del']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al']);

while($cob = mysql_fetch_array($query)){

$informe = new Periodos3();

    echo '<h3>'.strtoupper($cob['nombre1'].' '.$cob['apellidos']).'</h3>';

//MOROSO
$moroso =  $informe->cobrado('<',$periodo, $desde,$hasta,$cob['codigo'], '!=',0);;
$moroso2 = $informe->cobrado('=',$periodo, $desde,$hasta,$cob['codigo'], '!=',0);
$moroso3 = $informe->cobrado('>',$periodo, $desde,$hasta,$cob['codigo'], '!=',0);

$mor = number_format($moroso2 + $moroso3,0,',','.');
$totalMor = number_format($moroso2 + $moroso3 + $moroso,0,',','.');

//Cobrado
$anterior = $informe->cobrado('<',$periodo, $desde,$hasta,$cob['codigo'], '=',0);
$actual = $informe->cobrado('=',$periodo, $desde,$hasta,$cob['codigo'], '=',0);
$anticipado = $informe->cobrado('>',$periodo, $desde,$hasta,$cob['codigo'], '=',0);

$periodoActual = $actual + $anticipado;
$totalCobrado = $periodoActual + $anterior;
//************************************************************************************

//Entregado
$pendiente1 = $informe->pendiente($periodo,$desde,$hasta,$cob['codigo'],'=',0,'<');
$pendiente2 = $informe->pendiente($periodo,$desde,$hasta,$cob['codigo'],'=',0,'=');

$entregado_anterior = $pendiente1 + $anterior;
$entregado_actual = $pendiente2 + $periodoActual;
$totalEntregado = $entregado_anterior + $entregado_actual;
//************************************************************************************

@$porcentaje = number_format(($totalCobrado * 100/$totalEntregado),0,',','.');

    echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>AJUSTE</th><th>MOROSO</th><th>SALDO</th><th>%</th></tr>";

    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.number_format($entregado_anterior,0,',','.').'</td><td>'.number_format($anterior,0,',','.').'</td><td>&zwj;</td><td>'.number_format($moroso,0,',','.').'</td><td>'.number_format(($entregado_anterior - $anterior),0,',','.').'</td><td>'.$porcentaje.'</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($entregado_actual,0,',','.').'</td><td>'.number_format($periodoActual,0,',','.').'</td><td>&zwj;</td><td>'.$mor.'</td><td>'.number_format($entregado_actual - $periodoActual,0,',','.').'</td><th>&zwj;</th></tr>';
    //echo '<tr><td><strong>ANTICIPADO</strong></td><td>0</td><td>'.$sumaPeriodoAnticipado.'</td><td>&zwj;</td></tr>';
    echo '<tr><th></th></td><td><strong>'.number_format($totalEntregado,0,',','.').'</strong></td><td><strong>'.number_format($totalCobrado,0,',','.').'</strong></td><td>&zwj;</td><td><strong>'.$totalMor.'</strong></td><td><strong>'.number_format(($entregado_actual - $periodoActual)+($entregado_anterior - $anterior),0,',','.').'</strong></td><th>&zwj;</th></tr>';
    echo $periodos->table_cierre;
    echo "</table>";
    unset($periodos);
}



$sql2 ="SELECT codigo, descripcion FROM f_pago WHERE codigo != 600";
$query2 = mysql_query($sql2);

while($oficina = mysql_fetch_array($query2)){

$informe = new Periodos3();

//Cobrado
$anterior = $informe->cobrado_fp($periodo, $desde, $hasta,10,0, $oficina['codigo'],'<');
$actual = $informe->cobrado_fp($periodo, $desde, $hasta,10,0, $oficina['codigo'],'=');
$anticipado = $informe->cobrado_fp($periodo, $desde, $hasta,10,0, $oficina['codigo'],'>');

$monto1 = $informe->emitido_pen_fp(10,$ani_periodo,$mes_periodo,$oficina['codigo']);
$monto2 = $informe->pendiente3($periodo, $desde, $hasta,10,0,0,'<',$oficina['codigo']);

    echo '<h3>'.strtoupper($oficina['descripcion']).'</h3>';

    echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>AJUSTE</th><th>MOROSO</th><th>SALDO</th><th>%</th></tr>";
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.number_format($monto2,0,",",".").'</td><td>'.number_format($anterior,0,',','.').'</td><td>&zwj;</td><td>&zwj;</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($monto1,0,",",".").'</td><td>'.number_format(($actual + $anticipado),0,',','.').'</td><td>&zwj;</td><td>&zwj;</td></tr>';
    echo '<tr><th></th></td><td>'.number_format(($monto1 + $monto2),0,",",".").'</td><td>'.  number_format(($anterior + $actual + $anticipado),0,',','.').'</td><td>&zwj;</td><td>&zwj;</td><td>'.  number_format( ($monto1 + $monto2) - ($anterior + $actual + $anticipado),0,',','.').'</td></tr>';
    echo "</table>";

    unset($informe);
}


























$sql_traslado="SELECT
	SUM(monto)AS monto
	FROM
	eventos
        WHERE eventos.fecha BETWEEN '".$desde."' AND '".$hasta."' AND eventos.categoria='Traslado'";

$query_traslado = mysql_query($sql_traslado);

while($traslado = mysql_fetch_array($query_traslado)){

echo '<h3>TRASLADOS</h3>';
 echo '<table>';
    echo '<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>AJUSTE</th><th>MOROSO</th><th>SALDO</th><th>%</th></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td></td><td>'.$traslado['monto'].'</td><td>&zwj;</td></tr>';
    echo '<tr><td></td></td><td></td><td>'.$traslado['monto'].'</td><td>&zwj;</td></tr>';
    echo '</table>';
}

$sql_evento="SELECT
	SUM(monto)AS monto
	FROM 
	eventos
        WHERE eventos.fecha BETWEEN '".$desde."' AND '".$hasta."' AND eventos.categoria='Evento'";

$query_evento = mysql_query($sql_evento);
while($even = mysql_fetch_array($query_evento)){

 echo '<h3>EVENTOS</h3>';
 echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>AJUSTE</th><th>MOROSO</th><th>SALDO</th><th>%</th></tr>";
    echo '<tr><td><strong>ACTUAL</strong></td><td></td><td>'.$even['monto'].'</td><td>&zwj;</td></tr>';
    echo '<tr><td></td></td><td></td><td>'.$even['monto'].'</td><td>&zwj;</td></tr>';
    echo "</table>";
}
?>