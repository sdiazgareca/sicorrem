<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

$fechainicio = explode('-',$_POST['fechainicio']);

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=SEMANA_".$fechainicio[2]."-".$fechainicio[1]."-".$fechainicio[0]." al ".$fechatermino[2]."-".$fechatermino[1]."-".$fechatermino[0].".xls");

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$fecha = new Datos;
$_ini = $fecha->cambiaf_a_mysql($_POST['fechainicio']);
$_ter = $fecha->cambiaf_a_mysql($_POST['fechatermino']);


?>
<?php
echo '<strong>COPAGOS PARTICULARES '.$fechainicio[0].'-'.$fechainicio[1].'-'.$fechainicio[2].' al '.$fechatermino[0].'-'.$fechatermino[1].'-'.$fechatermino[2].'</strong>';


$listPlan_sql ="
SELECT fichas.cod_plan, fichas.tipo_plan,fichas.correlativo, copago.boleta,tipo_pago.tipo_pago,DATE_FORMAT(copago.fecha,'%d-%m-%Y') AS fecha,
copago.importe, fichas.paciente,copago.folio_med, fichas.paciente,fichas.nro_doc,fichas.num_solici,
titulares.nombre1 AS nom_t, titulares.apellido AS ape_t, contratos.titular,
titulares.telefono_laboral, titulares.telefono_particular, fichas.direccion,fichas.telefono,
contratos.ZO, contratos.SE, contratos.MA
FROM copago
LEFT JOIN fichas ON fichas.correlativo = copago.protocolo
INNER JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod
LEFT JOIN contratos ON contratos.num_solici = fichas.num_solici AND copago.numero_socio = contratos.num_solici
LEFT JOIN titulares ON titulares.nro_doc = contratos.titular
WHERE (contratos.empresa='' || contratos.empresa IS NULL) AND copago.fecha BETWEEN '".$_ini."' AND '".$_ter."'
AND (fichas.cod_plan='CA' || fichas.cod_plan='PA')
ORDER BY
    copago.folio_med,copago.boleta";

//echo $listPlan_sql.'<br />';

$listPlan_query = mysql_query($listPlan_sql);

?>



<table border="1px">
<tr>
<td><strong>FECHA</strong></td>

<td><strong>N&deg; BOLETA</strong></td>   
<td><strong>NOMBRE</strong></td>
<td><strong>RUT</strong></td>
<td>&nbsp;</td>
<td><strong>MONTO</strong></td>
<td><strong>TITULAR</strong></td>
<td><strong>RUT</strong></td>
<td>&nbsp;</td>
<td><strong>DOMICILIO</strong></td>
<td><strong>TELEFONO</strong></td>
<td><strong>ZONA</strong></td>
<td><strong>PAGO</strong></td>
<td><strong>COD_PLAN</strong></td>
<td><strong>TIPO_PLAN</strong></td>
</tr>
<?php
while ($bus = mysql_fetch_array($listPlan_query)){
?>

<tr>
<td><?php echo $bus['fecha']; ?></td>
<td><?php echo $bus['boleta']; ?></td>
<td><?php echo htmlentities($bus['paciente']); ?></td>
<td><?php echo number_format($bus['nro_doc'],0,",","."); ?></td>
<td><?php $fecha->validar_rut($bus['nro_doc']); echo $fecha->dv; ?></td>
<td><?php $numero = $bus['importe'];echo number_format($numero,0,",","."); ?></td>

<td><?php echo htmlentities($bus['nom_t']).' '.htmlentities($bus['ape_t']); ?></td>
<td><?php echo number_format($bus['titular'],0,",","."); ?></td>
<td><?php $fecha->validar_rut($bus['titular']); echo $fecha->dv; ?></td>
<td><?php echo $bus['direccion']?></td>
<td><?php echo $bus['telefono']?></td>
<td><?php echo $bus['ZO'].'-'.$bus['SE'].'-'.$bus['MA']; ?></td>
<td><?php echo $bus['tipo_pago']; ?></td>
<td><?php echo $bus['cod_plan']; ?></td>
<td><?php echo $bus['tipo_plan']; ?></td>
</tr>
<?php
}
?>
</table>