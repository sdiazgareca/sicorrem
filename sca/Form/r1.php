<?php
include('../conf.php');
include('../bd.php');
include('../rut.php');

$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];
$num = $_GET['num'];
if ($num < 1000){
$men = 'Movil '.$num;
}
else{
$men = 'Llamado en Espera '.($num - 1000);
}
?>
<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td>Paciente</td>
</tr>
</table>

<table style="width:500px;border:solid 1px #A6B7AF" class="celda2">
<tr>
<td>
<?php
$consulta = "select nro_doc,DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo,obser_man,diagnostico from fichas inner join sector on sector.cod = fichas.sector where movil='".$num."' and estado=1";

$resultados = mysql_query($consulta);
$matriz_resultados1 = mysql_fetch_array($resultados);
?>

<h1><a class="boton1"><img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;<?php echo $men; ?>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="boton1" onclick="MuestraVentana('control_de_tiempos','<?php echo $matriz_resultados['nro_doc']; ?>','<?php echo $matriz_resultados['correlativo']; ?>')"><img src="IMG/time.png" width="16" height="16" /></a> Asignar horario
</h1>

<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda2">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Hs Llamado<br /><?php echo $matriz_resultados1['hora_llamado']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs Despacho<br /><?php echo $matriz_resultados1['hora_despacho']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs salida bas<br /><?php echo $matriz_resultados1['hora_salida_base']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs Lleg dom<br /><?php echo $matriz_resultados1['hora_llegada_domicilio']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs sale dom<br /><?php echo $matriz_resultados1['hora_sale_domicilio']; ?></td>
</tr>
</table>

<?php

$consulta ="SELECT sector.cod,obser_man,direccion,edad,nro_doc,correlativo,telefono,direccion,entre,movil,color,sector.sector AS sector,observacion,celular,edad,paciente,correlativo, hora_llegada_domicilio,diagnostico,obser_man,tipo_plan,isapre,cod_plan FROM fichas INNER JOIN sector ON sector.cod = fichas.sector where movil='".$num."'";

$resultados = mysql_query($consulta);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){

//IDENTIFICA EL TIPO DE PLAN

if ( ($matriz_resultados['tipo_plan'] <> 'CA') || ($matriz_resultados['tipo_plan'] <> 'PA') ){
$consul = "SELECT fichas.nro_doc as rut,obras_soc.descripcion, planes.desc_plan FROM fichas INNER JOIN obras_soc ON fichas.isapre = obras_soc.nro_doc
INNER JOIN planes ON fichas.cod_plan = planes.cod_plan WHERE fichas.tipo_plan = planes.tipo_plan and fichas.nro_doc = '".$matriz_resultados['nro_doc']."'";

$resull = mysql_query($consul);
$matriz = mysql_fetch_array($resull);

$mat_rut = "SELECT afiliados.nombre1, afiliados.apellido,  mot_baja.descripcion, afiliados.cod_baja, mot_baja.codigo
FROM afiliados INNER JOIN mot_baja ON mot_baja.codigo = afiliados.cod_baja
WHERE afiliados.nro_doc = '".$matriz['rut']."'";
$mat_rut_resul = mysql_query($mat_rut);
$mat_rut_resul_1 = mysql_fetch_array($mat_rut_resul);
?>
<br /><br />

<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="47">Afiliado</td>
<?php echo $mat_rut_resul_1['nombre1'].' '.$mat_rut_resul_1['apellido']; ?><td width="133"></td>
<?php
if (($mat_rut_resul_1['codigo'] == 00) || ($mat_rut_resul_1['codigo'] == 05)){
?>
<td width="44">Estado</td>
<td width="100" style="color:#009900"><?php echo $mat_rut_resul_1['descripcion']; ?></td>
<?php
}
else {
?>
<td width="42">Estado</td>
<td width="86"><blink style="color:#FF0000;"><?php echo $mat_rut_resul_1['descripcion']; ?></blink></td>
<?php
}
?>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">

<tr>
<td width="37">Rut</td>
<td width="73" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['rut'].' - '.ValidaDVRut($matriz['rut']); ?></td>
<td width="26">Plan</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['descripcion'] ?></td>
<td width="58">Convenio</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['desc_plan'] ?></td>
</tr>
</table>
<?php
}
?>
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="68" class="celda3" style="background-color:#FFFEE0">
<div style="text-align:center; font-size:12px;">Protocolo <?php echo $matriz_resultados['correlativo']; ?></div>
<br />

Paciente
<br />
<input type="text" value="<?php echo strtoupper($matriz_resultados['paciente']); ?>" size="80" />
<br /><br />
Direcci&oacute;n
<br />
<input type="text" value="<?php echo strtoupper($matriz_resultados['direccion']); ?>" size="80" />
<br /><br />
Edad&nbsp;<input type="text" value="<?php echo $matriz_resultados['edad']; ?>" size="1" maxlength="2" />
Sector&nbsp;<select>
<option value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['sector']; ?></option>
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
Clave

<select>
<?php
$consulta = "select cod,color from color where cod < 4 order by cod";
$resultados = mysql_query($consulta);

while ($matriz_resultadosy = mysql_fetch_array($resultados)){
?>
<option class="text" value="<?php echo $matriz_resultadosy['cod'];?>"><? echo htmlentities($matriz_resultadosy['color']);?></option>
<?php
}
?>
<option value=""></option>
</select> 

<br />
<br />
Observaciones<br />
<textarea style="width:450px;"><?php echo $matriz_resultados['obser_man']; ?></textarea>

</td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>
<td>Sintomas</td>
</tr>
<tr>
<td class="celda2">
<?php
$consu = "select sintomas.sintoma from sintomas
inner join sintomas_reg on sintomas_reg.sintoma = sintomas.cod
inner join afiliados on afiliados.nro_doc = sintomas_reg.rut
where sintomas_reg.rut = ".$matriz_resultados['nro_doc']." and sintomas_reg.correlativo = '".$matriz_resultados['correlativo']."'";

$resul = mysql_query($consu);
while ($mat = mysql_fetch_array($resul)){
echo strtoupper($mat['sintoma'].'- ');
}
?>
</td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
