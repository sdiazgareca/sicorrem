<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=VENTAS".$_POST['periodo'].".xls");


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
 MONTH(fecha) AS mes,YEAR(fecha)AS anio, 8 AS tipo, titular AS nro_doc, CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nombre,
 ventas_reg.n_documento AS comprovante, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_mov, ventas_reg.monto AS importe
 FROM ventas_reg
  INNER JOIN titulares ON titulares.nro_doc = ventas_reg.titular
  WHERE n_documento > 0 AND monto > 0 AND fecha BETWEEN '".$periodo1."' AND '".$periodo2."'
      AND ff_factu='B'";

//echo $sql.'<br />';

$query = mysql_query($sql);
echo '<table>';
while($cot = mysql_fetch_array($query)){



    $rut->validar_rut($cot['nro_doc']);
//1   ,2,3,4       ,5,6                        ,7    ,8,9         ,10        ,11,12,13,14,15,16,17     ,18,19,20,21   ,22,23,24,25,26,27,28,29
//2011,1,8,10198962,8,ARAYA ROJAS MANUEL JAVIER,285972,,01/01/2011,01/01/2011,  ,1 ,13,14,15,16,Boletas,18,19,20,18500,22,23,24,25,26,27,28,18500
    echo '<tr>
        <td>'.$cot['anio'].'</td>
        <td>'.$cot['mes'].'</td>
        <td>8</td>
        <td>'.$cot['nro_doc'].'</td>
        <td>'.$rut->dv.'</td>
        <td>'.$cot['nombre'].'</td>
        <td>'.$cot['comprovante'].'</td>
        <td></td>
        <td>'.$cot['fecha_mov'].'</td>
        <td>'.$cot['fecha_mov'].'</td>
        <td></td>
        <td>1</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Boletas</td>
        <td></td>
        <td></td>
        <td></td>
        <td>'.$cot['importe'].'</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>'.$cot['importe'].'</td>
            </tr>';

}
echo '</table>';

?>
