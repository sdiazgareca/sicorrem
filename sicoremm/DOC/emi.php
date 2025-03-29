<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; EMISION.xls");
header("Pragma: no-cache");
header("Expires: 0");

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Periodos3.php');


$fecha = new Datos();

$per = explode("-",$_POST['periodo4']);

$periodo = $per[1].'-'.$per[0].'-01';

switch ($per[0]) {
    case 1:
        $mes ='ENERO';
        break;
    case 2:
        $mes ='FEBRERO';
        break;
    case  3:
        $mes ='MARZO';
        break;
    case  4:
        $mes ='ABRIL';
        break;
    case  5:
        $mes ='MAYO';
        break;

    case  6:
        $mes ='JUNIO';
        break;

    case  7:
        $mes ='JULIO';
        break;

    case  8:
        $mes ='AGOSTO';
        break;

    case  9:
        $mes ='SEPTIEMBRE';
        break;

    case  10:
        $mes ='OCTUBRE';
        break;

    case  11:
        $mes ='NOVIEMBRE';
        break;

    case  12:
        $mes ='DICIEMBRE';
        break;
}



$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador";
$query=mysql_query($sql);

echo '<strong>EMISION '.$mes.' '.$per[1].'</strong>';

echo '<br /><br />';

echo '<table class="table" border="1">';

echo '<tr><th>BOLETAS PARTICULARES</th><th></th></tr>';
while($cob = mysql_fetch_array($query)){

$cd_sql ="SELECT    SUM(cta.debe) AS debe, cobrador.codigo as cobrador
                    FROM contratos
                    INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                    INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    INNER JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador
                    WHERE operador='D' AND cobrador.codigo='".$cob['codigo']."' AND fecha_mov='".$periodo."'
                    AND contratos.f_pago='300' AND contratos.factu='B' AND contratos.tipo_plan=1 
                    GROUP BY cobrador.codigo";

$query_cd = mysql_query($cd_sql);


while($cd = mysql_fetch_array($query_cd)){

echo '<tr><td>'.$cob['apellidos'].' '.$cob['nombre1'].'</td><td>'.number_format($cd['debe'],0,',','.').'</td></tr>';

$total_cd = $total_cd + $cd['debe'];

if($cd['cobrador'] != 10){

    $terreno = $terreno + $cd['debe'];

}

if($cd['cobrador'] == 10){

    $oficina = $oficina + $cd['debe'];

}


}


}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_cd,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_cd;

?>


<tr><th>FACTURAS PARTUCULARES</th><th></th></tr>

<?php

//echo '<table class="table2">';


$cd_sql ="SELECT    contratos.f_pago,cobrador.codigo as cobrador,SUM(cta.debe) AS debe,CONCAT(titulares.apellido, ' ', titulares.nombre1, ' ',titulares.nombre2) AS titular
                    FROM contratos
                    INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                    INNER JOIN titulares ON titulares.nro_doc = contratos.titular
                    INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    INNER JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador AND f_pago != 400
                    WHERE operador='D' AND fecha_mov='".$periodo."'
                    AND (contratos.factu='C' || contratos.factu='A')  AND contratos.tipo_plan = 1
                    GROUP BY cobrador.codigo,contratos.num_solici, cta.comprovante";

//echo $cd_sql;

$query_cd = mysql_query($cd_sql);


while($cd = mysql_fetch_array($query_cd)){


if($cd['cobrador'] != 10 && $cd['f_pago'] == 300){

    $terreno = $terreno + $cd['debe'];

}

if($cd['cobrador'] == 10 && $cd['f_pago'] == 300 ){

    $oficina = $oficina + $cd['debe'];

}

if($cd['f_pago'] == 100 || $cd['f_pago'] == 200  || $cd['f_pago'] == 500 ){

    $debito = $debito + $cd['debe'];

}


echo '<tr><td>'.$cd['titular'].'</td><td>'.number_format($cd['debe'],0,',','.').'</td></tr>';

$total_fac = $total_fac + $cd['debe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_fac,0,',','.').'</td></tr>';
//echo '</table>';


$total = $total + $total_fac;

?>


<tr><th>CONVENIOS BOLETAS</th><th></th></tr>


<?php

$convenios_sql ='SELECT empresa.empresa, SUM(cta.debe) AS importe,contratos.f_pago
FROM empresa
INNER JOIN contratos ON contratos.empresa = empresa.nro_doc
INNER JOIN cta ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
WHERE cta.cod_mov=1 AND cta.fecha_mov="'.$periodo.'" AND empresa.nro_doc != "15004439" AND empresa.f_factu < 3
GROUP BY empresa.empresa';


$query = mysql_query($convenios_sql);

//echo '<table class="table2">';
while($convenios = mysql_fetch_array($query)){

    echo '<tr><td>'.$convenios['empresa'].'</td><td>'.number_format($convenios['importe'],0,',','.').'</td></tr>';

$total_convenio = $total_convenio + $convenios['importe'];



    $oficina = $oficina + $convenios['importe'];



}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_convenio,0,',','.').'</td></tr>';
//echo '</table>';


$total = $total + $total_convenio;

?>

<tr><th>CONVENIOS FACTURAS</th><th></th></tr>

<?php

$convenios_sql ='SELECT empresa.empresa, SUM(cta.debe) AS importe
FROM empresa
INNER JOIN contratos ON contratos.empresa = empresa.nro_doc
INNER JOIN cta ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
WHERE cta.cod_mov=1 AND cta.fecha_mov="'.$periodo.'" AND empresa.nro_doc != "15004439" AND empresa.f_factu > 2
GROUP BY empresa.empresa';

$query = mysql_query($convenios_sql);

//echo '<table class="table2">';
while($convenios2 = mysql_fetch_array($query)){

   $oficina = $oficina + $convenios2['importe'];

    echo '<tr><td>'.$convenios2['empresa'].'</td><td>'.number_format($convenios2['importe'],0,',','.').'</td></tr>';

$total_convenio2 = $total_convenio2 + $convenios2['importe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_convenio2,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_convenio2;

?>
<tr><th>AREAS PROTEGIDAS</th><th></th></tr>


<?php

$qp_sql ='SELECT contratos.f_pago,CONCAT(titulares.apellido," ",titulares.nombre1," ",titulares.nombre2) AS nombres , SUM(cta.debe) AS importe
FROM contratos
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
LEFT JOIN cta ON contratos.num_solici = cta.num_solici AND cta.nro_doc = titulares.nro_doc
WHERE contratos.tipo_plan=3 AND cta.cod_mov=1 AND cta.fecha_mov="'.$periodo.'"
GROUP BY cta.comprovante, contratos.num_solici';

$query_ap = mysql_query($qp_sql);

//echo '<table class="table2">';
while($ap = mysql_fetch_array($query_ap)){

echo '<tr><td>'.$ap['nombres'].'</td><td>'.number_format($ap['importe'],0,',','.').'</td></tr>';

$total_ap = $total_ap + $ap['importe'];

if($ap['f_pago'] == 100 || $ap['f_pago'] == 200 || $ap['f_pago'] == 500){

    $debito = $debito + $ap['importe'];

}

if($ap['f_pago'] == 300){

    $terreno = $terreno + $ap['importe'];

}


}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_ap,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_ap;

?>
<tr><th>PAC BANCARIOS</th><th></th></tr>
<?php

$virtual_sql ='
SELECT SUM(cta.debe) AS importe, f_pago.descripcion, f_pago.codigo AS f_pago
FROM contratos
INNER JOIN cta ON cta.num_solici = contratos.num_solici AND contratos.titular = cta.nro_doc
INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
WHERE contratos.tipo_plan != 3 AND cta.cod_mov=1 AND cta.fecha_mov="'.$periodo.'"
AND f_pago.codigo != 600 AND f_pago.codigo != 400 AND f_pago.codigo != 300 AND contratos.factu="B"
GROUP BY f_pago.codigo';

$query_v = mysql_query($virtual_sql);

//echo '<table class="table2">';
while($virtual = mysql_fetch_array($query_v)){

echo '<tr><td>'.$virtual['descripcion'].'</td><td>'.number_format($virtual['importe'],0,',','.').'</td></tr>';

if($virtual['f_pago'] == 100 || $virtual['f_pago'] == 200 || $virtual['f_pago'] == 500){

    $debito = $debito + $virtual['importe'];

}

$total_v = $total_v + $virtual['importe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_v,0,',','.').'</td></tr>';
//echo '</table>';


$total = $total + $total_v;

?>

<tr><th>EVENTOS</th><th></th></tr>

<?
$eventos_sql ="SELECT cliente, monto AS importe FROM
eventos WHERE categoria='Evento' AND MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";

$query_eventos = mysql_query($eventos_sql);

//echo '<table class="table2">';
while($eventos = mysql_fetch_array($query_eventos)){

$oficina = $oficina + $eventos['importe'];

echo '<tr><td>'.$eventos['cliente'].'</td><td>'.number_format($eventos['importe'],0,',','.').'</td></tr>';

$total_eventos = $total_eventos + $eventos['importe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_eventos,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_eventos;

?>

<tr><th>TRASLADOS</th><th></th></tr>

<?
$traslados_sql ="SELECT cliente, monto AS importe FROM
eventos WHERE categoria='Traslado' AND MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";

$query_tras = mysql_query($traslados_sql);

//echo '<table class="table2">';
while($traslados = mysql_fetch_array($query_tras)){
$oficina = $oficina + $traslados['importe'];
echo '<tr><td>'.$traslados['cliente'].'</td><td>'.number_format($traslados['importe'],0,',','.').'</td></tr>';

$total_tras = $total_tras + $traslados['importe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_tras,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_tras;
?>


    <tr><th><strong>TOTAL</strong></th>
<td><?php echo number_format($total,0,',','.'); ?></td>
    </tr>




<tr><th>MEDIMEL</th><th></th></tr>

<?
$MEDIMEL_sql ="SELECT cliente, monto AS importe FROM
eventos WHERE categoria='MEDIMEL' AND MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";

$query_MED = mysql_query($MEDIMEL_sql);

//echo '<table class="table2">';
while($MED = mysql_fetch_array($query_MED)){
$oficina = $oficina + $MED['importe'];
echo '<tr><td>'.$MED['cliente'].'</td><td>'.number_format($MED['importe'],0,',','.').'</td></tr>';

$total_MED = $total_MED + $MED['importe'];

}
echo '<tr><td><strong>TOTAL</strong></td><td>'.number_format($total_MED,0,',','.').'</td></tr>';
//echo '</table>';

$total = $total + $total_MED;

?>



    <tr><th><strong>TOTAL</strong></th>
<td><?php echo number_format($total,0,',','.'); ?></td>
    </tr>


















</table>

<br /><br />

<strong>PROPORCIONES</strong>

<table border="1">
    <tr>
        <td>TERRENO</td>
        <td><?php echo number_format($terreno,0,',','.'); ?></td>
        <td><?php echo round($terreno * 100 / $total,2).' %'; ?></td>
    </tr>

    <tr>
        <td>DEBITO</td>
        <td><?php echo number_format($debito,0,',','.'); ?></td>
        <td><?php echo round($debito * 100 / $total,2).' %'; ?></td>
    </tr>

    <tr>
        <td>CONVENIOS Y OFICINA</td>
        <td><?php echo number_format($oficina,0,',','.'); ?></td>
        <td><?php echo round($oficina * 100 / $total,2).' %'; ?></td>
    </tr>
</table>

