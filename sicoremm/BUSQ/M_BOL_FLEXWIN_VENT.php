<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Ventas.xls");

include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/Datos.php');

$rut = new Datos();

$per_del = explode('-',$_POST['periodo_del']);
$periodo1 = $per_del[2].'-'.$per_del[1].'-'.$per_del[0];

$per_al = explode('-',$_POST['periodo_al']);
$periodo2 = $per_al[2].'-'.$per_al[1].'-'.$per_al[0];


if (checkdate($per_del[1],$per_del[0], $per_del[2]) == false){
    echo 'Error revise las fecha de periodo...';
    exit;
}

if (checkdate($per_al[1],$per_al[0], $per_al[2]) == false){
    echo 'Error revise las fecha de periodo...';
    exit;
}


$sql = "
SELECT ff_factu AS tipo_comp,DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha_vto, n_documento AS comprovante,  
monto AS haber, titular AS nro_doc
FROM ventas_reg
WHERE 
fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND
estado_venta = 300 AND ff_factu IS NOT NULL AND ff_factu !=''";


$query = mysql_query($sql);
echo '<table>';
while($cot = mysql_fetch_array($query)){
 

    $rut->validar_rut($cot['nro_doc']);

    echo '<tr>';
    if($cot['tipo_comp'] == 'B'){
       $cot['tipo_comp'] = 8; 
    }
    
    if($cot['tipo_comp'] == 'C'){
       $cot['tipo_comp'] = 23; 
    }
    
    if($cot['tipo_comp'] == 'A'){
       $cot['tipo_comp'] = 1; 
    }     
        

   echo '<td>'.$cot['tipo_comp'].'</td>
        <td>1102001</td>
        <td>'.$cot['fecha_vto'].'</td>
        <td>'.$cot['comprovante'].'</td>
        <td>'.$cot['haber'].'</td>
        <td>'.$cot['nro_doc'].'</td>
        <td>'.$rut->dv.'</td>
        <td>1101001</td>
        </tr>';
   
}
echo '</table>';

?>



