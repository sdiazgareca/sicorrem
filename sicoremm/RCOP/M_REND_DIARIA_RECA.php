<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');


$periodo  = explode("-",$_POST['periodo2']);
$periodo_mysql = $periodo[1].'-'.$periodo[0].'-01';

$fecha  = explode("-",$_POST['fecha']);
$fecha_mysql = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

echo '<h1>RECADACION DIARIA</h1>';
echo '<table class="table2">';
echo '<tr>';
echo '<th>COBRADOR</th>';
echo '<th>PANT</th>';
echo '<th>PACT</th>';
echo '<th>ANTI</th>';
echo '<th>MANDA</th>';
echo '<th>CONVE</th>';
echo '<th>AREA</th>';
echo '<th>COPAGO</th>';
echo '<th>TOTAL</th>';
echo '<th></th>';
echo '<th>EFEC</th>';
echo '<th>CH/DIA</th>';
echo '<th>CH/FECHA</th>';
echo '<th>A BANC</th>';
echo '<th>TOTAL</th>';
echo '</tr>';

$recaudacion_sql="SELECT CONCAT(cobrador.nombre1,' ',cobrador.apellidos) AS cob, cobrador.codigo, cobrador.nro_doc
FROM cobrador";


$query = mysql_query($recaudacion_sql);

while($rendi1 = mysql_fetch_array($query)){

$total = 0;
$pago_anterior = 0;
$pago_actual =0;
$pago_anticipado=0;
$pago_mand =0;
$pago_ap =0;
$pago_conv=0;
$efectivo =0;
$cheque_dia =0;
$cheque_fecha=0;
$efectivo_copago_b['importe']=0;
$efectivo_copago_d['importe']=0;
$efectivo_copago_chd['importe']=0;
$efectivo_copago['importe']=0;
$copago =0;
$tranferencia = 0;
$cobrador = $rendi1['cob'];
/* COPAGO */
//EFECTIVO
$copago_e ="SELECT SUM(importe) AS importe,  copago.tipo_pago FROM copago WHERE copago.cobrador='".$rendi1['nro_doc']."' AND tipo_pago='1' AND f_pago='".$fecha_mysql."'";
$copago_query = mysql_query($copago_e);
$efectivo_copago = mysql_fetch_array($copago_query);
//echo '<br />'.$copago_e.'<br />';

//CHEQUE AL DIA
$copago_chd ="SELECT SUM(importe) AS importe,  copago.tipo_pago FROM copago WHERE copago.cobrador='".$rendi1['nro_doc']."' AND tipo_pago='2'  AND f_pago='".$fecha_mysql."'";
$copago_query_chd = mysql_query($copago_chd);
$efectivo_copago_chd = mysql_fetch_array($copago_query_chd);
//echo '<br />'.$copago_chd.'<br />';

//CHEQUE A FECHA
$copago_d ="SELECT SUM(importe) AS importe,  copago.tipo_pago FROM copago WHERE copago.cobrador='".$rendi1['nro_doc']."' AND tipo_pago='10'  AND f_pago='".$fecha_mysql."'";
$copago_query_d = mysql_query($copago_d);
$efectivo_copago_d = mysql_fetch_array($copago_query_d);
//echo '<br />'.$copago_d.'<br />';

//BANCO
$copago_b ="SELECT SUM(importe) AS importe,  copago.tipo_pago FROM copago WHERE copago.cobrador='".$rendi1['nro_doc']."' AND tipo_pago BETWEEN '11' AND '14'  AND f_pago='".$fecha_mysql."'";
$copago_query_b = mysql_query($copago_b);
$efectivo_copago_b = mysql_fetch_array($copago_query_b);
//echo '<br />'.$copago_b.'<br />';


$copago = $efectivo_copago_b['importe'] + $efectivo_copago_d['importe'] + $efectivo_copago_chd['importe'] +$efectivo_copago['importe'];
$total_copago = $total_copago + $copago;
//echo '<br />'.$copago.'<br />';





$sub_sql = "SELECT haber AS haber,cta.num_solici,cta.cod_mov,contratos.tipo_plan,contratos.f_pago,cta.rendicion AS rend, fecha_mov, fecha, cta.importe AS importe, t_mov.larga,t_mov.codigo
FROM cta
INNER JOIN cobrador ON cobrador.codigo = cta.cobrador
INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
INNER JOIN contratos ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
WHERE cta.fecha='".$fecha_mysql."' AND t_mov.operador='H' AND cta.cobrador='".$rendi1['codigo']."' AND afectacion >0";

//echo $sub_sql.'<br />';

$query_sub = mysql_query($sub_sql);

    while ($sub = mysql_fetch_array($query_sub)){


$rendicion = $sub['rend'];

$total = $total + $sub['importe'];

$suma = $suma + $sub['importe'];

$sumatoria = $sumatoria+$sub['importe'];





//pago anticipado
if($sub['fecha_mov'] < $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300 ){
$pago_anterior = $pago_anterior + $sub['importe'];
$suma_pago_anterior = $suma_pago_anterior + $sub['importe'];
}

//pago actual
if($sub['fecha_mov'] == $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300){
$pago_actual = $pago_actual + $sub['importe'];
$suma_pago_actual = $suma_pago_actual + $sub['importe'];
//echo '<br />'.$sub['cod_mov'].' '.$rendi1['codigo'].'<br />';

}

//pago anticipado
if($sub['fecha_mov'] > $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300){
$pago_anticipado = $pago_anticipado + $sub['importe'];
$suma_pago_anticipado = $suma_pago_anticipado + $sub['importe'];
}

//mandato tc
if($sub['tipo_plan'] != 3 && ($sub['f_pago'] == 200 || $sub['f_pago'] == 500 || $sub['f_pago'] == 100 )){
$pago_mand = $pago_mand + $sub['importe'];
$suma_pago_mand = $suma_pago_mand + $sub['importe'];
}

//areas proteguidas
if($sub['tipo_plan'] == 3){
$pago_ap = $pago_ap + $sub['importe'];
$suma_pago_areas_proteguidas = $suma_pago_areas_proteguidas + $sub['importe'];
}

//convenios
if($sub['tipo_plan'] != 3 && $sub['f_pago'] == 400){
$pago_conv = $pago_conv + $sub['importe'];
$suma_pago_conv = $suma_pago_conv + $sub['importe'];
}

//efectivo
if($sub['cod_mov'] == 51 || $sub['cod_mov'] == 53){
$efectivo = $efectivo + $sub['importe'] +$efectivo_copago['importe'];
$suma_efectivo = $suma_efectivo + $sub['importe'] +$efectivo_copago['importe'];
}

//cheque al dia
if($sub['cod_mov'] == 93){
$cheque_dia = $cheque_dia + $sub['importe'] +$efectivo_copago_chd['importe'];
$suma_cheque_dia = $suma_cheque_dia + $sub['importe'] +$efectivo_copago_chd['importe'];
}

//cheque a fecha
if($sub['cod_mov'] == 95){
$cheque_fecha = $cheque_fecha + $sub['importe'] +$efectivo_copago_d['importe'];
$suma_cheque_fecha = $suma_cheque_fecha + $sub['importe']+$efectivo_copago_d['importe'];
}




//cheque tranferencia
if($sub['cod_mov'] == 54 || $sub['cod_mov'] == 92 || $sub['cod_mov'] == 52 || $sub['cod_mov'] == 96){

$tranferencia = $tranferencia + $sub['importe']+$efectivo_copago_b['importe'];
$suma_tranferencia = $suma_tranferencia + $sub['importe'] +$efectivo_copago_b['importe'];


}





    }


    echo '<tr>
    <td><strong>'.strtoupper($cobrador).'</strong></td>
    <td>'.number_format($pago_anterior,0,',','.').'</td>
    <td>'.number_format($pago_actual,0,',','.').'</td>
    <td>'.number_format($pago_anticipado,0,',','.').'</td>
    <td>'.number_format($pago_mand,0,',','.').'</td>
    <td>'.number_format($pago_conv,0,',','.').'</td>
    <td>'.number_format($pago_ap,0,',','.').'</td>
    <td>'.number_format($copago,0,',','.').'</td>
    <td>'.number_format($total + $copago,0,',','.').'</td>
    <th></th>

    <td>'.number_format($efectivo,0,',','.').'</td>
    <td>'.number_format($cheque_dia,0,',','.').'</td>
    <td>'.number_format($cheque_fecha,0,',','.').'</td>
    <td>'.number_format($tranferencia,0,',','.').'</td>
    <td>'.number_format($total + $copago,0,',','.').'</td>



    </tr>';






}


    echo '<tr>
    <th></th>
    <td><strong>'.number_format($suma_pago_anterior,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_pago_actual,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_pago_anticipado,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_pago_mand,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_pago_conv,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_pago_areas_proteguidas,0,',','.').'</strong></td>
    <td><strong>'.number_format($total_copago,0,',','.').'</strong></td>
    <td><strong>'.number_format($sumatoria +$total_copago,0,',','.').'</strong></td>
    <th></th>
    <td><strong>'.number_format($suma_efectivo,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_cheque_dia,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_cheque_fecha,0,',','.').'</strong></td>
    <td><strong>'.number_format($suma_tranferencia,0,',','.').'</strong></td>
    <td><strong>'.number_format($sumatoria +$total_copago,0,',','.').'</strong></td>

    </tr>';


echo '</table>';

$traslado ="SELECT SUM(monto + iva) AS monto FROM eventos WHERE eventos.categoria='Traslado' AND fecha='".$fecha_mysql."'";

$traslados_query = mysql_query($traslado);
$num_tras = mysql_num_rows($traslados_query);
$tras = mysql_fetch_array($traslados_query);

if($tras['monto'] > 0){

    echo '<h1>TRASLADOS</h1>';
    echo '<table class="table2">';
    echo '<tr><td>'.number_format($tras['monto'],0,',','.').'</td>';
    echo '</table>';
    echo '<br />';

}



$eventos ="SELECT SUM(monto + iva) AS monto FROM eventos WHERE eventos.categoria='Evento' AND fecha='".$fecha_mysql."'";
$eventos_query = mysql_query($eventos);
$num_eve = mysql_num_rows($eventos_query);
$eve = mysql_fetch_array($eventos_query);

if($eve['monto'] > 0){

    echo '<h1>EVENTOS</h1>';
    echo '<table class="table2">';
    echo '<tr><td>'.number_format($eve['monto'],0,',','.').'</td>';
    echo '</table>';

}

if($eve['monto'] < 1 && $tras['monto'] < 1){

    echo '<h1></h1>';

}

?>
