<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=DESCPLAN".$_POST['periodo'].".xls");


include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/Datos.php');

$rut = new Datos();

$per1 = explode('-',$_POST['periodo1']);
$per2 = explode('-',$_POST['periodo2']);


$periodo1 = $per1[2].'-'.$per1[1].'-'.$per1[0];
$periodo2 = $per2[2].'-'.$per2[1].'-'.$per2[0];

$sql = "
SELECT
 MONTH(fecha) AS mes,YEAR(fecha)AS anio, 8 AS tipo, ventas_reg.titular AS nro_doc, CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nombre,
 ventas_reg.n_documento AS comprovante, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_mov, ventas_reg.monto AS importe, empresa.empresa
 FROM ventas_reg

  INNER JOIN titulares ON titulares.nro_doc = ventas_reg.titular
  INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici AND contratos.titular = ventas_reg.titular
INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
  WHERE fecha BETWEEN '".$periodo1."' AND '".$periodo2."' ORDER BY empresa.empresa, ventas_reg.fecha,ventas_reg.titular";

//echo $sql;

$query = mysql_query($sql);
echo '<table>';

    echo '<tr>
        <th>FECHA INGRESO</th>
        <th>RUT</th>
        <th>DV</th>
        <th>TITULAR</th>
        <th>COMP</th>
        <th>EMPRESA</th>
        <th>MONTO</th>
            </tr>';

while($cot = mysql_fetch_array($query)){



    $rut->validar_rut($cot['nro_doc']);
//1   ,2,3,4       ,5,6                        ,7    ,8,9         ,10        ,11,12,13,14,15,16,17     ,18,19,20,21   ,22,23,24,25,26,27,28,29
//2011,1,8,10198962,8,ARAYA ROJAS MANUEL JAVIER,285972,,01/01/2011,01/01/2011,  ,1 ,13,14,15,16,Boletas,18,19,20,18500,22,23,24,25,26,27,28,18500
    echo '<tr>
        <td>'.$cot['fecha_mov'].'</td>
        <td>'.$cot['nro_doc'].'</td>
        <td>'.$rut->dv.'</td>
        <td>'.$cot['nombre'].'</td>
        <td>'.$cot['comprovante'].'</td>
        <td>'.$cot['empresa'].'</td>
        <td>'.$cot['importe'].'</td>
            </tr>';

}
echo '</table>';

?>
