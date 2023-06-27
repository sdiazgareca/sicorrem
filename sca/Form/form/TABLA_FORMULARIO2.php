<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="344" class="celda3" style="background-color:#FFFEE0">

<table width="324" style="width:300px;background-color:#FFFEE0;">


<tr>
<td>Clave</td><td class="celda2"><?php echo $matriz_resultados['color']; ?></td>
</tr>

<tr>
<td>Direcci&oacute;n</td><td  class="celda2"><?php echo htmlentities($matriz_resultados['direccion']); ?></td>
</tr>

<tr>
<td>Sector</td><td class="celda2"><?php echo $matriz_resultados['sector']; ?></td>
</tr>

<tr>
<td>Entre</td><td  class="celda2"><?php echo htmlentities($matriz_resultados['entre']); ?></td>
</tr>


<tr>
<td width="95">Paciente</td>
<td width="217" class="celda2"><?php echo htmlentities($matriz_resultados['paciente']); ?></td>
</tr>


<tr>
<td>Edad</td><td class="celda2"><?php echo $matriz_resultados['edad']; ?></td>
</tr>


<tr>
<td>Telefono</td><td class="celda2"><?php echo $matriz_resultados['telefono']; ?></td>
</tr>
<tr>
<td>Celular</td><td class="celda2"><?php echo $matriz_resultados['celular']; ?></td>
</tr>
<tr>
<td>Observaciones</td><td class="celda2"><?php echo htmlentities($matriz_resultados['observacion']); ?></td>
</tr>


<?php

$estado = "SELECT destino FROM destino WHERE cod = '".$matriz_resultados['obser_man']."'";
$con_estado = mysql_query($estado);
$estado_num = mysql_num_rows($con_estado);

if($estado_num > 0){

$mat_estado = mysql_fetch_array($con_estado);
echo '<tr><td>Estado</td><td class="celda2">'.$mat_estado['destino'].'</td></tr>';
}
else{
echo '<tr><td>Estado</td><td class="celda2"><blink style="color:#FF0000">Debe Registrar accion</blink></td></tr>';
}

if ($matriz_resultados['color'] !='Azul'){
$diagnostico_n = "SELECT diagnostico.diagnostico 

FROM fichas 

INNER JOIN diagnostico ON CONVERT(diagnostico.cod USING utf8) = CONVERT(fichas.diagnostico USING utf8) WHERE fichas.correlativo = ".$matriz_resultados['correlativo']."";
$diagnostico_n_q = mysql_query($diagnostico_n);
$diag_num = mysql_num_rows($diagnostico_n_q);

if($diag_num > 0){
$mat_diag_q = mysql_fetch_array($diagnostico_n_q);
echo '<tr><td>Diagnostico</td><td class="celda2">'.$mat_diag_q['diagnostico'].'</td></tr>';
}
else{
echo '<tr><td>Diagnostico</td><td class="celda2"><blink style="color:#FF0000">Debe Registrar el diagnostico</blink></td></tr>';

}
}
if ($matriz_resultados['obser_man'] == '45')
{ 
	$estado = "SELECT Lugar FROM centrohospita WHERE cod = '".$matriz_resultados['CentroHospitalario']."'";
	$con_estado = mysql_query($estado);
	$estado_num = mysql_num_rows($con_estado);

	if($estado_num > 0){

	$mat_estado = mysql_fetch_array($con_estado);
	echo '<tr><td>Centro Hospitalario</td><td class="celda2">'.$mat_estado['Lugar'].'</td></tr>';
	}
	else{
	echo '<tr><td>Centro Hospitalario</td><td class="celda2"><blink style="color:#FF0000">Debe Registrar el Centro Hospitalario</blink></td></tr>';
	}
}
?>
</table></td>

<td width="124">
<div id="movil_asignados_<?php echo $matriz_resultados['correlativo']; ?>" style="background-color:#FFFEE0; padding:1px;width:100px;" align="left">

<a style="color:#000000" href="#" onclick="$ajaxload('movil_asignados_<?php echo $matriz_resultados['correlativo']; ?>', 'Form/Muestra_moviol_compartir5.php?id=movil_<?php echo $matriz_resultados['correlativo']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>&movil=<?php echo $matriz_resultados['movil']; ?>',false,false,false);">Movil Libre</a>
<select name="movil_<?php echo $matriz_resultados['correlativo']; ?>" size="5" id="movil_<?php echo $matriz_resultados['correlativo']; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
  <?php
$consultare = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
  <option class="text" ondblclick="
if(confirm('Esta seguro de cambiar al paciente de movil?')){
cambiar_amb2(this.value,'<?php echo $matriz_resultados['correlativo']; ?>','<?php echo $num;?>');
}
" value="<?php echo $matriz_resultadosre['numero']; ?>"><?php echo 'Movil '.$matriz_resultadosre['numero']; ?></option>
  <?php
}
?>
  <?php
$consultare = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
  <option class="text" ondblclick="
if(confirm('Esta seguro de establecer en espera al paciente?')){
cambiar_amb3(this.value,'<?php echo $matriz_resultados['correlativo']; ?>','<?php echo $num;?>');}" value="<?php echo $matriz_resultadosre['cod']; ?>"><?php echo 'Espera '.$matriz_resultadosre['espera']; ?></option>
  <?php
}
?>
</select>
</div>
<br />
<a href="#" style="background-color:none; text-decoration:none; color:#FFCC00" onClick="Muestra('editar','<?php echo $matriz_resultados['correlativo']; ?>')">
<div style="padding:2px; text-align:center; width:30px; background-color:#FFCC00;"><img src="IMG/user_edit.png" style="text-decoration:none;" width="16" height="16" /><br />
</div>
</a></td>
</tr>
</table>
