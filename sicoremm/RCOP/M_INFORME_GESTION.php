<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');

/*
foreach($_POST AS $campo=>$valor){

    echo $campo.' '.$valor.'<br />';

}
*/

$periodo  = explode("-",$_POST['periodo222']);
$periodo_mysql = $periodo[1].'-'.$periodo[0].'-01';

$fecha  = explode("-",$_POST['fecha']);
$fecha_mysql = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

$periodo1 = explode("-",$_POST['periodo11']);
$periodo1_11 = $periodo1[2].'-'.$periodo1[1].'-'.$periodo1[0];

$periodo2 = explode("-",$_POST['periodo22']);
$periodo2_22 = $periodo2[2].'-'.$periodo2[1].'-'.$periodo2[0];


echo '<table class="table2">';
echo '<tr>';
echo '<th>COBRADOR</th>';
echo '<th>PANT</th>';
echo '<th>PACT</th>';
echo '<th>ANTI</th>';
echo '<th>MANDA</th>';
echo '<th>TC</th>';
echo '<th>CONVE</th>';
echo '<th>AREA</th>';
echo '<th>TOTAL</th>';

$recaudacion_sql="SELECT CONCAT(cobrador.nombre1,' ',cobrador.apellidos) AS cob, cobrador.codigo
FROM cobrador";

//echo '<br />'.$recaudacion_sql.'<br />';

$query = mysql_query($recaudacion_sql);

while($rendi1 = mysql_fetch_array($query)){

$cobrador="";
$rendicion ="";
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
$pago_tc =0;

$sub_sql = "SELECT cta.cod_mov,contratos.tipo_plan,contratos.f_pago,cta.rendicion AS rend, fecha_mov, fecha, cta.importe AS importe, t_mov.larga,t_mov.codigo
FROM cta
INNER JOIN cobrador ON cobrador.codigo = cta.cobrador
INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
INNER JOIN contratos ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
WHERE cta.fecha BETWEEN '".$periodo1_11."' AND '".$periodo2_22."' AND t_mov.operador='H' AND cta.cobrador='".$rendi1['codigo']."' AND afectacion >0";

//echo $sub_sql.'<br />';

$query_sub = mysql_query($sub_sql);

    while ($sub = mysql_fetch_array($query_sub)){

$cobrador = $rendi1['cob'];
$rendicion = $sub['rend'];

$total = $total + $sub['importe'];

$suma = $suma + $sub['importe'];

$tranferencia = 0;

//pago anticipado
if($sub['fecha_mov'] < $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300 ){
$pago_anterior = $pago_anterior + $sub['importe'];
$suma_pago_anterior = $suma_pago_anterior + $sub['importe'];
}

//pago actual
if($sub['fecha_mov'] == $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300){
$pago_actual = $pago_actual + $sub['importe'];
$suma_pago_actual = $suma_pago_actual + $sub['importe'];

}

//pago anticipado
if($sub['fecha_mov'] > $periodo_mysql && $sub['tipo_plan'] != 3 && $sub['f_pago'] == 300){
$pago_anticipado = $pago_anticipado + $sub['importe'];
$suma_pago_anticipado = $suma_pago_anticipado + $sub['importe'];
}

//mandato tc
if($sub['tipo_plan'] != 3 && ($sub['f_pago'] == 100 )){
$pago_mand = $pago_mand + $sub['importe'];
$suma_pago_mand = $suma_pago_mand + $sub['importe'];
}

// tc
if($sub['tipo_plan'] != 3 && ($sub['f_pago'] == 200)){
$pago_tc = $pago_tc + $sub['importe'];
$suma_pago_tc = $suma_pago_tc + $sub['importe'];
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


    }

    if($cobrador != ""){
    echo '<tr>
    <td><strong>'.strtoupper($cobrador).'</strong></td>
    <td>'.$pago_anterior.'</td>
    <td>'.$pago_actual.'</td>
    <td>'.$pago_anticipado.'</td>
    <td>'.$pago_mand.'</td>
    <td>'.$pago_tc.'</td>
    <td>'.$suma_pago_conv.'<td>
    <td></td>
    <td>'.$pago_ap.'</td>
    <td>'.$total.'</td>
    </tr>';
}

}

    echo '<tr>
    <th></th>
    <th></th>
    <td><strong>'.$suma_pago_anterior.'</strong></td>
    <td><strong>'.$suma_pago_actual.'</strong></td>
    <td><strong>'.$suma_pago_anticipado.'</strong></td>
    <td><strong>'.$suma_pago_mand.'</strong></td>
    <td><strong>'.$suma_pago_tc.'</strong></td>
    <td><strong>'.$suma_pago_areas_proteguidas.'</strong></td>
    <td><strong>'.$pago_conv.'</strong></td>
    <td><strong>'.$suma.'</strong></td>
    </tr>';

echo '</table>';

?>
