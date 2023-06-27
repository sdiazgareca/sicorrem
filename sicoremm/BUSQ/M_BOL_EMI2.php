<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=IVA".$_POST['periodo'].".xls");


include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/Datos.php');

$rut = new Datos();

$del = explode('-',$_POST['del']);
$al = explode('-',$_POST['al']);


$periodo1 = $del[2].'-'.$del[1].'-'.$del[0];
$periodo2 = $al[2].'-'.$al[1].'-'.$al[0];

$sql = "SELECT MONTH(emi_par_cobranza.fecha_sistema) AS mes,YEAR(emi_par_cobranza.fecha_sistema) AS anio,8 AS tipo, cta.nro_doc, CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nombre, cta.comprovante,
DATE_FORMAT(emi_par_cobranza.fecha_sistema,'%d/%m/%Y') AS fecha_mov, SUM(cta.debe) AS importe

FROM emi_par_cobranza
INNER JOIN cta ON cta.num_solici = emi_par_cobranza.contrato AND cta.comprovante = emi_par_cobranza.comprovante AND cta.nro_doc = emi_par_cobranza.titular AND debe > 0
INNER JOIN contratos ON contratos.num_solici = emi_par_cobranza.contrato AND contratos.titular = emi_par_cobranza.titular
INNER JOIN titulares ON titulares.nro_doc = emi_par_cobranza.titular
WHERE cta.cod_mov='1' AND emi_par_cobranza.fecha_sistema BETWEEN '".$periodo1."' AND '".$periodo2."'  AND cta.tipo_comp='B'
GROUP BY comprovante,contratos.num_solici, contratos.titular";

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
