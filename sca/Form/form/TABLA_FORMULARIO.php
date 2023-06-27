<?php

include('../../conf.php');
include('../../bd.php');

if (  (isset($_GET['paciente'])) && (isset($_GET['direccion'])) && (isset($_GET['edad'])) && (isset($_GET['sector'])) && (isset($_GET['clave'])) && (isset($_GET['observaciones'])) && (isset($_GET['num'])) && (isset($_GET['protocolo'])) || (isset($_GET['telefono'])) || (isset($_GET['celular']))  ){

$consulta_Y = "UPDATE fichas SET telefono='".$_GET['telefono']."', celular='".$_GET['celular']."', paciente='".$_GET['paciente']."', direccion='".$_GET['direccion']."' , sector='".$_GET['sector']."', color='".$_GET['clave']."',observacion='".nl2br($_GET['observaciones'])."',edad='".$_GET['edad']."' where correlativo='".$_GET['protocolo']."'";
$resultados_Y = mysql_query($consulta_Y);
}

$consulta="
SELECT
fichas.movil,DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_sale_domicilio,DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') AS hora_llega_destino,DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') AS hora_sale_destino, DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') AS hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') AS hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') AS hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_llegada_domicilio, sector.cod AS sector_cod,obser_man,direccion,edad,nro_doc,correlativo,telefono,direccion,entre,movil,color.color,color.cod,sector.sector AS sector,observacion,celular,edad,paciente,correlativo, hora_llegada_domicilio,diagnostico,obser_man,tipo_plan,isapre,cod_plan,tipo_plan,CentroHospitalario,num_solici
FROM fichas 
INNER JOIN sector ON sector.cod = fichas.sector 
INNER JOIN color ON fichas.color = color.cod WHERE fichas.estado=1 AND fichas.correlativo = '".$_GET['correlativo']."'";

$resultados = mysql_query($consulta);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){// INICIO DEL WHILE PRINCIPAL
?>
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="68" class="celda3" style="background-color:#FFFEE0">

Paciente
<br />
<input id="paciente_<?php echo $matriz_resultados['correlativo']; ?>" type="text" value="<?php echo strtoupper($matriz_resultados['paciente']); ?>" size="80" />

<br /><br />
Direcci&oacute;n
<br />
<input id="direccion_<?php echo $matriz_resultados['correlativo']; ?>" type="text" value="<?php echo strtoupper($matriz_resultados['direccion']); ?>" size="80" />

<br /><br />
Edad&nbsp;<input id="edad_<?php echo $matriz_resultados['correlativo']; ?>" type="text" value="<?php echo $matriz_resultados['edad']; ?>" size="1" maxlength="2" />

<!-- Sector -->
Sector&nbsp;<select id="sector_<?php echo $matriz_resultados['correlativo']; ?>">
<option value="<?php echo $matriz_resultados['sector_cod']; ?>"><?php echo $matriz_resultados['sector']; ?></option>
<?php
$consulta9 = "select cod,sector from sector order by sector";
$resultados9 = mysql_query($consulta9);
while ($matriz_resultados9 = mysql_fetch_array($resultados9)){
?>
<option class="text" value="<?php echo $matriz_resultados9['cod'];?>"><? echo htmlentities($matriz_resultados9['sector']);?></option>
<?php
}
?>
</select>
<!-- Sector -->

<!-- Clave -->
Clave&nbsp;
<select id="clave_<?php echo $matriz_resultados['correlativo']; ?>">
<option class="text" value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['color']; ?></option>
<?php
$consulta23 = "select cod,color from color where cod < 4 order by cod";
$resultados23 = mysql_query($consulta23);

while ($matriz_resultadosy = mysql_fetch_array($resultados23)){
?>
<option class="text" value="<?php echo $matriz_resultadosy['cod'];?>"><? echo htmlentities($matriz_resultadosy['color']);?></option>
<?php
}
?>
</select>
<!-- Clave -->

<br /><br />
Telefono <input size="6" maxlength="6" type="text" value="<?php echo $matriz_resultados['telefono']; ?>" id="telefono_<?php echo $matriz_resultados['correlativo']; ?>" />&nbsp;Celular <input size="9" maxlength="10" type="text" value="<?php echo $matriz_resultados['celular']; ?>" id="celular_<?php echo $matriz_resultados['correlativo']; ?>" />
<table style="width:450px; background-color:#FFFEE0;" class="celda2">
<tr>
<td style="background-color:FFFEE0;">
Observaciones<br />
<textarea id="observaciones_<?php echo $matriz_resultados['correlativo']; ?>" style="width:300px; height:120px"><?php echo $matriz_resultados['observacion']; ?></textarea></td>
</tr>
</table>

<div style="width:400px; float:left;">&nbsp;</div><div align="right" style="width:auto; float:left;">
<input type="button" class="boton" value="Grabar" onclick="
var paciente = document.getElementById('paciente_<?php echo $matriz_resultados['correlativo']; ?>').value;
var direccion = document.getElementById('direccion_<?php echo $matriz_resultados['correlativo']; ?>').value;

var edad = document.getElementById('edad_<?php echo $matriz_resultados['correlativo']; ?>').value;
var sector = document.getElementById('sector_<?php echo $matriz_resultados['correlativo']; ?>').value;
var clave = document.getElementById('clave_<?php echo $matriz_resultados['correlativo']; ?>').value;
var observaciones = document.getElementById('observaciones_<?php echo $matriz_resultados['correlativo']; ?>').value;
var num = <?php echo $matriz_resultados['movil']; ?>;
var protocolo = <?php echo $matriz_resultados['correlativo']; ?>;
var telefono = document.getElementById('telefono_<?php echo $matriz_resultados['correlativo']; ?>').value;
var celular = document.getElementById('celular_<?php echo $matriz_resultados['correlativo']; ?>').value;

if(confirm('Esta seguro de guardar los cambios?')) {	
$ajaxload('editar', 'Form/form/TABLA_FORMULARIO.php?paciente='+paciente+'&direccion='+direccion+'&edad='+edad+'&sector='+sector+'&clave='+clave+'&observaciones='+observaciones+'&num='+num+'&protocolo='+protocolo+'&telefono='+telefono+'&celular='+celular,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false)
if($ajaxload){

$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nro_doc=<?php echo $matriz_resultados['nro_doc']; ?>&num=<?php echo $matriz_resultados['movil']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);

javascript:$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',true);
}
};


" /></div></td>
</tr>
</td>
</tr>
</table>
<?php
}
?>