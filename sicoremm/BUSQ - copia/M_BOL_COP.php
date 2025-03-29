<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=COPAGOS".$_POST['periodo'].".xls");


include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/Datos.php');

$rut = new Datos();

$per1 = explode('-',$_POST['periodo1']);
$per2 = explode('-',$_POST['periodo2']);


$periodo1 = $per1[2].'-'.$per1[1].'-'.$per1[0];
$periodo2 = $per2[2].'-'.$per2[1].'-'.$per2[0];


$sql = "SELECT MONTH(copago.fecha) AS mes, YEAR(copago.fecha) AS anio,8 AS tipo, 99502 AS nro_doc,
'CONSULTAS MEDICAS' AS nombre,
DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_mov, SUM(copago.importe) AS importe, MIN(copago.boleta) AS comprovante1,
MAX(copago.boleta) AS comprovante2
FROM copago
INNER JOIN fichas ON copago.protocolo = fichas.correlativo
INNER JOIN contratos ON fichas.num_solici = contratos.num_solici
INNER JOIN titulares ON contratos.titular = titulares.nro_doc
WHERE fecha BETWEEN '".$periodo1."' AND '".$periodo2."'  AND boleta > 0 AND importe > 0
GROUP BY copago.fecha";

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
        <td>'.$cot['comprovante1'].'</td>
        <td>'.$cot['comprovante2'].'</td>
        <td>'.$cot['fecha_mov'].'</td>
        <td>'.$cot['fecha_mov'].'</td>
        <td></td>
        <td>1</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>BOLETAS CONSULTAS MEDICAS</td>
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