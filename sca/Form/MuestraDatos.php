<table style="width:480px; background:#FFFEE0" class="celda3">
<tr style="background-color:#FFFEE0">

<td  class="celda3" style="background-color:#FFFEE0">Plan</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="plann"><?php echo htmlentities($matriz_resultados['desc_plan']);?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Isapre</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['reducido']); ?></td>
<td class="celda3" style="background-color:#FFFEE0">Categoria</td>
<td class="celda2"style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['descripcion2']);?></td>
</tr>
<tr style="background-color:#FFFEE0">
<td class="celda3" style="background-color:#FFFEE0">Tipo</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['tipo_plan_desc']);?></td>
<td class="celda3" style="background-color:#FFFEE0">Fono Referencia</td>
<?php

include('../conf.php');
include('../bd.php');

$consulta3 = "select telefono from afiliados 
inner join domicilios on afiliados.nro_doc = domicilios.nro_doc
where afiliados.nro_doc ='".$matriz_resultados['nro_doc']."'";
		
$resultados3 = mysql_query($consulta3);
$nbd = mysql_num_rows($resultados3);


$matriz_resultados3 = mysql_fetch_array($resultados3);
?>
<td class="celda2" style="background-color:#FFFEE0"><?php if(!$matriz_resultados3['telefono']){echo 'No registra';} else{ echo htmlentities($matriz_resultados3['telefono']);}?></td>
<td class="celda3" style="background-color:#FFFEE0">Edad</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="edad"><?php echo htmlentities($matriz_resultados['edad']); ?></div></td>
</tr>

<tr>
    <td class="celda2" style="background-color:#FFFEE0">Empresa</td>
    <td><?php echo htmlentities($matriz_resultados['empresa']); ?></td>
</tr>
</table>

<div id="cod_plann" style="display:none"><?php echo $matriz_resultados['cod_plan']; ?></div>
<div id="tipo_plann" style="display:none"><?php echo $matriz_resultados['tipo_plan']; ?></div>
<div id="isapren" style="display:none"><?php echo $matriz_resultados['isapre']; ?></div>







<?php
//atenciones anuales
$atencion_anual = "SELECT COUNT(fichas.hora_llamado) AS cantidad FROM fichas WHERE YEAR(fichas.hora_llamado)='".date('Y')."' AND (fichas.obser_man='24' ||  fichas.obser_man='42' || fichas.obser_man='45') AND fichas.num_solici= '".$matriz_resultados['num_solici']."'";
$atencion_anual_query = mysql_query($atencion_anual);
$atencion_mat = mysql_fetch_array($atencion_anual_query);
//atenciones mensuales
$atencion_mensual = "SELECT COUNT(fichas.hora_llamado) AS cantidad FROM fichas  WHERE YEAR(fichas.hora_llamado)='".date('Y')."' AND MONTH(fichas.hora_llamado) = '".date('m')."' AND (fichas.obser_man='24' ||  fichas.obser_man='42' || fichas.obser_man='45') AND fichas.num_solici= '".$matriz_resultados['num_solici']."'";
$atencion_mensual_query = mysql_query($atencion_mensual);
$atencion_mat_m = mysql_fetch_array($atencion_mensual_query);
//copagos pendientes
$deuda = "SELECT COUNT(copago.numero_socio) as cantidad FROM copago WHERE copago.numero_socio ='".$matriz_resultados['num_solici']."' AND ( (tipo_pago = '3')  || (tipo_pago = '4')) AND importe > 0 AND YEAR(fecha) >= 2011";
$deuda_query = mysql_query($deuda);
$deuda_query_m = mysql_fetch_array($deuda_query);
?>
<table style=" width:480px; background-color:#FFCC00; border-bottom:none;">
<tr>
<td class="celda3" style="background-color:#FFCC00;">
<?php

echo 'Atenciones Anuales: '.$atencion_mat['cantidad'];
?>
</td>
<td class="celda3" style="background-color:#FFCC00;">
<?php
echo 'Atenciones en este mes: '.$atencion_mat_m['cantidad'];
?>
</td>
<td class="celda3" style="background-color:#FFCC00;">
<?php

echo 'Copagos pendientes: '.$deuda_query_m['cantidad'];

?>
</td>
</tr>
</table>
<br />

<?php

if( $matriz_resultados['cod_plan'] != 'PA' && $matriz_resultados['cod_plan'] != 'TRA_PAR' && $matriz_resultados['cod_plan'] != 'TRA_CONV' && $matriz_resultados['cod_plan'] != 'TRA_ME' ){
echo '<br />';
echo'<table style=" width: 450px;">';
echo '<tr>';
echo '<td>CASA PROTEGIDA</td><td>'.$matriz_resultados['casa_p'].'</td>';

if($matriz_resultados['tiempo'] != 'NO'){
    $tiempo = $matriz_resultados['tiempo'];
}
else{
    $tiempo ="";
}


echo '<td>ATENCIONES SIN COPAGO</td><td>'.$matriz_resultados['cm_gratis'].' '.$tiempo.'</td>';
echo '<td>VALOR</td><td>'.number_format($matriz_resultados['copago'],0,',','.').'</td>';
echo '</tr>';
echo '</table>';
echo '<br />';
}
?>