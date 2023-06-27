<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=IVA".$_POST['periodo'].".xls");

include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/Datos.php');

$rut = new Datos();

$per = explode('-',$_POST['periodo']);

$periodo = $per[2].'-'.$per[1].'-'.$per[0];

if (checkdate($per[1],'01', $per[2]) == false){
    echo 'Error revise las fecha de periodo...';
    exit;
}

$sql="SELECT e_nromes AS mes, e_ano AS anio, 8 AS tipo, e_nro AS nro_doc, e_nombre AS nombre, e_comp AS comprovante,
      CONCAT('01-',e_nromes,'-',e_ano) AS fecha_mov, e_total AS importe FROM IVA
      LEFT JOIN contratos ON contratos.num_solici = IVA.grupo_vie
      LEFT JOIN f_pago ON contratos.f_pago = f_pago.codigo
      WHERE e_nromes ='".$per[1]."' AND e_ano='".$per[2]."'";

//echo '<br />'.$sql.'<br />';

/*
$sql = "SELECT MONTH(cta.fecha_mov) AS mes,YEAR(cta.fecha_mov) AS anio,8 AS tipo, cta.nro_doc, CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nombre, cta.comprovante,
DATE_FORMAT(cta.fecha_mov,'%d/%m/%Y') AS fecha_mov, cta.importe
FROM cta
INNER JOIN contratos ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
INNER JOIN titulares ON titulares.nro_doc = cta.nro_doc
WHERE cta.cod_mov='1' AND cta.fecha_mov='".$periodo."' AND cta.tipo_comp='B' AND
contratos.f_ingreso < '".$periodo."'";
*/

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
