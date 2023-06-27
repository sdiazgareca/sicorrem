<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; EMISION.xls");
header("Pragma: no-cache");
header("Expires: 0");

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/IGES_FAC.php');

include_once('../CLA/Fecha_1.php');

$fecha = new Fecha_1($_POST['periodo20']);

$convenios ="SELECT empresa.empresa, empresa.nro_doc
FROM
empresa
WHERE (empresa.f_factu=2 || empresa.f_factu=5 || empresa.f_factu=3 || empresa.f_factu=4) AND empresa.nro_doc != '15004439'
";

//echo '<br /><strong>'.$convenios.'</strong><br />';

$query_convenios = mysql_query($convenios);

echo '<h1>EMISION RECAUDACION FACTURAS ELECTRONICAS CONVENIOS PERIODO '.strtoupper($fecha->mes_palabras).'  '.$fecha->anio.'</h1>';

echo '<table>';
echo '<tr>
          
          <th>CONVENIO</th>
          <th>N FACTURA</th>
          <th>PERIODO</th>
          <th>EMITIDO</th>
          <th>COBRADO</th>
          <th>PENDIENTE</th>
          <th>FECHA DE PAGO</th>
          <th>RENDICION</th>

          </tr>';

while($conv = mysql_fetch_array($query_convenios)){

    echo '<tr>';
    echo '<td><strong>'.$conv['empresa'].'</strong></td>';

    $debe="SELECT comprovante, SUM(debe) AS debe, fecha_mov from cta
        LEFT JOIN contratos ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici
        LEFT JOIN t_mov ON t_mov.codigo = cta.cod_mov 
        WHERE contratos.empresa='".$conv['nro_doc']."' AND t_mov.operador='D' AND cta.fecha_mov ='".$fecha->anio."-".$fecha->mes."-01'";


    $debe_query = mysql_query($debe);

    $num1= mysql_num_rows($debe_query);

    if ($num1 > 0){

    while($d = mysql_fetch_array($debe_query)){

        $periodo = new Fecha_1($d['fecha_mov']);

        echo '<td>'.$d['comprovante'].'</td>';
        echo '<td>'.$periodo->normal.'</td>';
        echo '<td>'.number_format($d['debe'],0,',','.').'</td>';
        $debe = $d['debe'];
        $total_emitido_con = $total_emitido_con + $d['debe'];
    }
    }
    else{
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }

    $haber="SELECT SUM(haber) AS haber, fecha, rendicion from cta
    LEFT JOIN contratos ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici
    LEFT JOIN t_mov ON t_mov.codigo = cta.cod_mov
    WHERE contratos.empresa='".$conv['nro_doc']."' AND t_mov.operador='H' AND cta.fecha_mov ='".$fecha->anio."-".$fecha->mes."-01'";


    $haber_query = mysql_query($haber);

    $num2= mysql_num_rows($haber_query);

    if ($num2 > 0){

    while($h = mysql_fetch_array($haber_query)){

    $fecha_pago = new Fecha_1($h['fecha']);

    echo '<td>'.number_format($h['haber'],0,',','.').'</td>';
    echo '<td>'.number_format(($debe - $h['haber']),0,',','.').'</td>';
    echo '<td>'.$fecha_pago->normal.'</td>';
    echo '<td>'.$h['rendicion'].'</td>';

    $total_cobrado_conv = $total_cobrado_conv + $h['haber'];

    }
    }
    else{
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }





    echo '</tr>';


}



echo '<tr>';
echo '<th>TOTAL</th>';
echo '<th></th>';
echo '<th></th>';
echo '<td><strong>'.number_format($total_emitido_con,0,',','.').'</strong></td>';
echo '<td><strong>'.number_format($total_cobrado_conv,0,',','.').'</strong></td>';
echo '<td><strong>'.number_format(($total_emitido_con - $total_cobrado_conv),0,',','.').'</strong></td>';
echo '</tr>';



echo '</table>';

echo '<br />';
echo '<h1>EMISION RECAUDACION AREAS PROTEGIDAS PERIODO '.strtoupper($fecha->mes_palabras).'  '.$fecha->anio.'</h1>';

echo '<table>';
echo '<tr>

          <th>AREA PROTEGIDA</th>
          <th>N FACTURA</th>
          <th>PERIODO</th>
          <th>EMITIDO</th>
          <th>COBRADO</th>
          <th>PENDIENTE</th>
          <th>FECHA DE PAGO</th>
          <th>RENDICION</th>

          </tr>';

$areas_sql ="
    SELECT
    f_baja, f_ingreso,contratos.num_solici,titular,
    CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nom
FROM contratos
INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
    WHERE contratos.tipo_plan =3 AND (contratos.f_baja >='".$fecha->anio."-".$fecha->mes."-01' || f_baja ='0000-00-00')";


$query = mysql_query($areas_sql);

while($a = mysql_fetch_array($query)){

    echo '<tr>';
    echo '<td><strong>'.$a['nom'].'</strong></td>';


    $debe="SELECT comprovante, SUM(debe) AS debe, fecha_mov from cta
        LEFT JOIN contratos ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici
        LEFT JOIN t_mov ON t_mov.codigo = cta.cod_mov
        WHERE contratos.num_solici='".$a['num_solici']."' AND t_mov.operador='D' AND cta.fecha_mov ='".$fecha->anio."-".$fecha->mes."-01'";


    $debe_query = mysql_query($debe);

    $num1= mysql_num_rows($debe_query);

    if ($num1 > 0){

    while($d = mysql_fetch_array($debe_query)){

        $periodo = new Fecha_1($d['fecha_mov']);

        echo '<td>'.$d['comprovante'].'</td>';
        echo '<td>'.$periodo->normal.'</td>';
        echo '<td>'.number_format($d['debe'],0,',','.').'</td>';
        $debe = $d['debe'];
        
        $total_emitido_ap = $total_emitido_ap + $d['debe'];

    }
    }
    else{
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }



        $haber="SELECT SUM(haber) AS haber, fecha, rendicion from cta
    LEFT JOIN contratos ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici
    LEFT JOIN t_mov ON t_mov.codigo = cta.cod_mov
    WHERE contratos.num_solici='".$a['num_solici']."' AND t_mov.operador='H' AND cta.fecha_mov ='".$fecha->anio."-".$fecha->mes."-01'";


    $haber_query = mysql_query($haber);

    $num2= mysql_num_rows($haber_query);

    if ($num2 > 0){

    while($h = mysql_fetch_array($haber_query)){

    $fecha_pago = new Fecha_1($h['fecha']);

    echo '<td>'.number_format($h['haber'],0,',','.').'</td>';
    echo '<td>'.number_format(($debe - $h['haber']),0,',','.').'</td>';
    echo '<td>'.$fecha_pago->normal.'</td>';
    echo '<td>'.$h['rendicion'].'</td>';

    $total_cobrado_ap = $total_cobrado_ap + $h['haber'];

    }
    }
    else{
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }



    echo '</tr>';

}

echo '<tr>';
echo '<th>TOTAL</th>';
echo '<th></th>';
echo '<th></th>';
echo '<td><strong>'.number_format($total_emitido_ap,0,',','.').'</strong></td>';
echo '<td><strong>'.number_format($total_cobrado_ap,0,',','.').'</strong></td>';
echo '<td><strong>'.number_format(($total_emitido_ap - $total_cobrado_ap),0,',','.').'</strong></td>';
echo '</tr>';

echo '</table>';

