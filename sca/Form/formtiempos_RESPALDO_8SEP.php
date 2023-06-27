<?php
include('../conf.php');
include('../bd.php');
include('../rut.php');

//Identificar Variables GET
$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];
$num = $_GET['num'];

//GRAVAR VALORES
if (  (isset($_GET['paciente'])) && (isset($_GET['direccion'])) && (isset($_GET['edad'])) && (isset($_GET['sector'])) && (isset($_GET['clave'])) && (isset($_GET['observaciones'])) && (isset($_GET['num'])) && (isset($_GET['protocolo'])) || (isset($_GET['telefono'])) || (isset($_GET['celular']))  ){

$consulta_Y = "UPDATE fichas SET telefono='".$_GET['telefono']."', celular='".$_GET['celular']."', paciente='".$_GET['paciente']."', direccion='".$_GET['direccion']."' , sector='".$_GET['sector']."', color='".$_GET['clave']."',observacion='".$_GET['observaciones']."',edad='".$_GET['edad']."' where correlativo='".$_GET['protocolo']."'";
$resultados_Y = mysql_query($consulta_Y);
}
//COMPROBAR EL NOBRE DE NUM (MOVIL ó LLAMADA EN ESPERA)
if ($num < 1000){
$men = 'Movil '.$num;
}
else{
$men = 'Llamado en Espera '.($num - 1000);
}
?>


<!-- Ecabezado de Tabla (titulo PACIENTE) -->
<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td>Paciente</td>
</tr>
</table>

<!-- Aca Empieza la tabla que tiene el contenido de la tabla -->
<table style="width:500px;border:solid 1px #A6B7AF" class="celda2">
<tr>
<td>
<?php

//OBTIENE VALORES HORA LLEGADA; HORA SALIDA ETC...
$consulta = "select nro_doc,DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo,obser_man,diagnostico from fichas inner join sector on sector.cod = fichas.sector where movil='".$num."' and estado=1";

$resultados = mysql_query($consulta);
$matriz_resultados1 = mysql_fetch_array($resultados);
?>
<!-- MUESTRA EL TITULO y BOTON PARA ASIGNAR HORARIO--> 
<h1>
<img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;<?php echo $men; ?>
<?php if ($num < 1000){
?>
&nbsp;
<a href="#" class="boton1" onclick="MuestraVentana('control_de_tiempos','<?php echo $matriz_resultados1['nro_doc']; ?>','<?php echo $matriz_resultados1['correlativo']; ?>')">
<img src="IMG/time.png" width="16" height="16" /></a> Asignar horario<?php } ?>
</h1>

<!-- TABLA DE HORARIOS HORARIO--> 
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
$consulta ="SELECT
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') as hora_llega_destino,DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') as hora_sale_destino, DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio, sector.cod AS sector_cod,obser_man,direccion,edad,nro_doc,correlativo,telefono,direccion,entre,movil,color.color,color.cod,sector.sector AS sector,observacion,celular,edad,paciente,correlativo, hora_llegada_domicilio,diagnostico,obser_man,tipo_plan,isapre,cod_plan,tipo_plan,CentroHospitalario,num_solici
FROM fichas 
INNER JOIN sector ON sector.cod = fichas.sector 
INNER JOIN color ON fichas.color = color.cod where movil='".$num."' and fichas.estado=1";

$resultados = mysql_query($consulta);
?>

<?php

while ( $matriz_resultados = mysql_fetch_array($resultados) ){// INICIO DEL WHILE PRINCIPAL


	//COMPRUEBA QUE TIPO DE PLAN SEA DIFERENTE DE "CA" Y "PA"
	if ( ($matriz_resultados['tipo_plan'] != 'CA') && ($matriz_resultados['tipo_plan'] != 'PA') ){
		
		//OBTIENE NOMBRE DE ISAPRE, PLANES
		$consul = "SELECT fichas.nro_doc as rut,obras_soc.descripcion, planes.desc_plan FROM fichas INNER JOIN obras_soc ON fichas.isapre = obras_soc.nro_doc INNER JOIN planes ON fichas.cod_plan = planes.cod_plan WHERE fichas.tipo_plan= planes.tipo_plan and fichas.nro_doc = '".$matriz_resultados['nro_doc']."' and fichas.num_solici= '".$matriz_resultados['num_solici']."'";
		
		
		$resull = mysql_query($consul);
		$matriz = mysql_fetch_array($resull);
		
		//OBTIENE NOMBRE AFILIADO, APELLIDO, MOT_ BAJA DESDE AFILIADOS
		$mat_rut = "SELECT afiliados.nombre1, afiliados.apellido,  mot_baja.descripcion, afiliados.cod_baja, mot_baja.codigo
					FROM afiliados INNER JOIN mot_baja ON mot_baja.codigo = afiliados.cod_baja WHERE afiliados.nro_doc = '".$matriz
					['rut']."'";
					
		$mat_rut_resul = mysql_query($mat_rut);
		$mat_rut_resul_1 = mysql_fetch_array($mat_rut_resul);
?>

<br /> 

<!-- Muestra TABLA AFILIADO, ESTADO -->
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="40">Afiliado</td>
<td width="133"><?php echo $mat_rut_resul_1['nombre1'].' '.$mat_rut_resul_1['apellido']; ?></td>
<?php
if (($mat_rut_resul_1['codigo'] == 00) || ($mat_rut_resul_1['codigo'] == 05)){
?>
<td width="44">Estado</td>
<td width="100" style="color:#009900"><?php echo $mat_rut_resul_1['descripcion']; ?></td>
<?php
}
else {
?>
<td width="44">Estado</td>
<td width="100"><blink style="color:#FF0000;"><?php echo $mat_rut_resul_1['descripcion']; ?></blink></td>

<?php
}
?>
</tr>
</table>

<!-- Muestra TABLA RUT, PLAN, CONVENIO -->
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="37">Rut</td>
<td width="73" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['rut'].' - '.ValidaDVRut($matriz['rut']); ?></td>
<td width="26">Isapre</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['descripcion'] ?></td>
<td width="58">Plan</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['desc_plan'] ?></td>
</tr>
</table>

<?php		
}// FIN IF "CA" Y "PA"

?>




<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF;" class="celda3">
<tr>

<td width="68" class="celda3" style="background-color:#FFFEE0">

<div style="text-align:center; font-size:12px; border-bottom:none; border-top:none;">Protocolo <?php echo $matriz_resultados['correlativo']; ?></div>

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
<option  class="text" value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['color']; ?></option>
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

<td>


<div id="movil_asignados_<?php echo $matriz_resultados['correlativo']; ?>" style="background-color:#FFFEE0; padding:1px;width:100px;" align="left">

<a style="color:#000000" href="#" onclick="$ajaxload('movil_asignados_<?php echo $matriz_resultados['correlativo']; ?>', 'Form/Muestra_moviol_compartir5.php?id=movil_<?php echo $matriz_resultados['correlativo']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>&movil=<?php echo $matriz_resultados['movil']; ?>',false,false,false);">Movil Libre</a>

<select name="movil_<?php echo $matriz_resultados['correlativo']; ?>" size="5" id="movil_<?php echo $matriz_resultados['correlativo']; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
<?php
$consultare = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
<option class="text" onDblClick="
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
<option class="text" onDblClick="
if(confirm('Esta seguro de establecer en espera al paciente?')){
cambiar_amb3(this.value,'<?php echo $matriz_resultados['correlativo']; ?>','<?php echo $num;?>');}" value="<?php echo $matriz_resultadosre['cod']; ?>"><?php echo 'Espera '.$matriz_resultadosre['espera']; ?></option>
<?php
}
?>
</select>
</div></td>
</tr>
</table>
<div style="width:400px; float:left;">&nbsp;</div><div align="right" style="width:auto; float:left;">
<input type="button" class="boton" value="Gravar" onclick="
var paciente = document.getElementById('paciente_<?php echo $matriz_resultados['correlativo']; ?>').value;
var direccion = document.getElementById('direccion_<?php echo $matriz_resultados['correlativo']; ?>').value;

var edad = document.getElementById('edad_<?php echo $matriz_resultados['correlativo']; ?>').value;
var sector = document.getElementById('sector_<?php echo $matriz_resultados['correlativo']; ?>').value;
var clave = document.getElementById('clave_<?php echo $matriz_resultados['correlativo']; ?>').value;
var observaciones = document.getElementById('observaciones_<?php echo $matriz_resultados['correlativo']; ?>').value;
var num = <?php echo $_GET['num']; ?>;
var protocolo = <?php echo $matriz_resultados['correlativo']; ?>;
var telefono = document.getElementById('telefono_<?php echo $matriz_resultados['correlativo']; ?>').value;
var celular = document.getElementById('celular_<?php echo $matriz_resultados['correlativo']; ?>').value;

if(confirm('Esta seguro de guardar los cambios?')) {	
$ajaxload('bus', 'form/formtiempos.php?paciente='+paciente+'&direccion='+direccion+'&edad='+edad+'&sector='+sector+'&clave='+clave+'&observaciones='+observaciones+'&num='+num+'&protocolo='+protocolo+'&telefono='+telefono+'&celular='+celular,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false)
if($ajaxload){
javascript:$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',true);
}
};


" /></div></td>
</tr>
<tr>
<td>
<br />
Sintomas
<br />
<?php


$consulta_sintomas = "SELECT sintomas.sintoma as sint FROM sintomas INNER JOIN sintomas_reg ON sintomas.cod=sintomas_reg.sintoma WHERE correlativo='".$matriz_resultados['correlativo']."'";		
$resintoma = mysql_query($consulta_sintomas);
while($matriz_sintoma = mysql_fetch_array($resintoma)){
echo $matriz_sintoma['sint'].'<br/>';
}
?>
<br />
<!-- SELECT PARA ELIMINAR SOLITUD DE MOVIL --> 
Anular&nbsp;&nbsp;
<select style="width:300px;" id="destino_<?php echo $matriz_resultados['correlativo']; ?>">
<?php

if ($matriz_resultados['cod'] != '4'){
$consu = "where otros = 1";
}
else{
$consu = "where azul = 1";
}
$query = "select cod,destino from destino ".$consu."";
$respuesta = mysql_query($query);
while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>

<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta seguro de anular el llamado?')){

var destino = document.getElementById('destino_<?php echo $matriz_resultados['correlativo']; ?>').value;
  
$ajaxload('bus','Form/Actualizar_ficha.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&direccion=<?php echo $matriz_resultados['direccion']; ?>&color=<?php echo $matriz_resultados['cod'];; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" />
<!-- SELECT PARA ELIMINAR SOLITUD DE MOVIL --></td>
</tr>
<!-- IMPORTANTEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->



<tr>
<td>
<br /><br />
<table style="width:400px;" class="celda1">

<tr>
<td><?php echo '<h1>PROTOCOLO '.$matriz_resultados['correlativo'].'</h1>'; ?></td>
</tr>


<?php
if ($matriz_resultados['cod_plan'] != 'PA'){
?>
<tr>
<td class="celda3">
<?php
$atencion_anual = "SELECT COUNT(copago.numero_socio) as cantidad FROM copago WHERE copago.numero_socio ='".$matriz_resultados['num_solici']."' AND YEAR(fecha) = '".date('Y')."'";
$atencion_anual_query = mysql_query($atencion_anual);
$atencion_mat = mysql_fetch_array($atencion_anual_query);

echo '<h1>Atenciones Anuales: '.$atencion_mat['cantidad'].'</h1>';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$atencion_mensual = "SELECT COUNT(copago.numero_socio) as cantidad FROM copago WHERE copago.numero_socio ='".$matriz_resultados['num_solici']."' AND MONTH(fecha) = '".date('m')."'";
$atencion_mensual_query = mysql_query($atencion_mensual);
$atencion_mat_m = mysql_fetch_array($atencion_mensual_query);

echo '<h1>Atenciones en este mes: '.$atencion_mat_m['cantidad'].'</h1>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$deuda = "SELECT COUNT(copago.numero_socio) as cantidad FROM copago WHERE copago.numero_socio ='".$matriz_resultados['num_solici']."' AND ( (tipo_pago = '3')  || (tipo_pago = '4'))";

$deuda_query = mysql_query($deuda);
$deuda_query_m = mysql_fetch_array($deuda_query);

echo '<h1>Copagos pendientes: '.$deuda_query_m['cantidad'].'</h1>';

?>

</td>
</tr>
<?php
}
?>
</table>

<?php
/////////////////////////////////////// MUESTRA PARA AZULES  ////////////////////////////////////////////////////////////////////////////////////

if ($matriz_resultados['cod'] == '4'){
?>
<table style="width:400px;" class="celda1">
<tr>
<td class="celda3">
<?php
$azul="SELECT fichas.paciente,DATE_FORMAT(fichas.hora_llamado,'%d-%m-%Y %H:%i:%S') AS hora_llamado,traslado_tipo.traslado,traslados.ciudad, traslados.Direccion_destino, traslados.Direccion_origen,DATE_FORMAT(traslados.fecha_traslado,'%d-%m-%Y %H:%i:%S') AS fecha_traslado
FROM fichas 
INNER JOIN traslados ON traslados.cod=fichas.traslado 
INNER JOIN traslado_tipo ON traslado_tipo.cod=traslados.tipo_traslado
WHERE color='4' AND correlativo ='".$matriz_resultados['correlativo']."' ";

$query_azul=mysql_query($azul);
$mat_azul=mysql_fetch_array($query_azul);

echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00">'.$mat_azul['traslado'].'</div><br />';
echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00"">'.'Paciente '.$mat_azul['paciente'].'</div><br />';
echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00">'.'Direcci&oacute;n Origen: '.$mat_azul['Direccion_origen'].'</div><br />';
echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00"">'.'Direcci&oacute;n Destino: '.$mat_azul['Direccion_destino'].' '.$mat_azul['ciudad'].'</div><br />';
echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00">'.'Fecha de Traslado: '.$mat_azul['fecha_traslado'].'</div><br />';
echo '<div style="padding:5px;background:#FFFEE0;color:#00CC00">'.'Fecha LLamado: '.$mat_azul['hora_llamado'].'</div><br />';
?>
</td>
</tr>
</table>

<?php 
}
/////////////////////////////////////// Fin MUESTRA PARA AZULES  ////////////////////////////////////////////////////////////////////////////////////
?>

<br /><br />
<?php
/////////////////////////////////////////////////-------------------------------------------------------------------------------------
if ( ($num < 1000) and ($matriz_resultados['hora_llamado'] > 0) and ($matriz_resultados['hora_despacho'] > 0) and ($matriz_resultados['hora_salida_base'] > 0) and ($matriz_resultados['hora_llegada_domicilio'] > 0) ){
?>
Acci&oacute;n&nbsp;&nbsp;
<select id="destino2_<?php echo $matriz_resultados['correlativo']; ?>" style="width:300px">
<?php
if ($matriz_resultados['cod'] != '4'){/*****************************************************/

$consu2 = "where accion = 2";
}
else{
$consu2 = "where accion = 2";
}

$query = "select * from destino ".$consu2."";
$respuesta = mysql_query($query);
?>
      
<?php
while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
    </select>
    <input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta de realizar los cambios?')){

var destino = document.getElementById('destino2_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha20.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados['correlativo']; ?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" />
<br  /><br />
<?php 
if ($matriz_resultados['obser_man'] == '45' || $matriz_resultados['obser_man'] == '42' )
{ 
?>
Diagnostico&nbsp;
<select id="diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>" style="width:auto">
<option value="0">&nbsp;</option>
<?php
$query = "select cod, diagnostico from diagnostico order by cod";
$respuesta = mysql_query($query);

while ($diagnostico = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $diagnostico['cod']; ?>"><?php echo $diagnostico['cod']; ?></option>
<?
}
?>
</select>
<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var diagnostico = document.getElementById('diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha4.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&diagnostico='+diagnostico,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" />
<?php 
if ($matriz_resultados['obser_man'] == '45')
{ 
?>
&nbsp;
C. Hospitalario&nbsp;
<select style="width:80px;" id="centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>">
<?php
$hospital ="SELECT cod, Lugar FROM centrohospita";
$hospital_q = mysql_query($hospital);
while ($mat_hospi = mysql_fetch_array($hospital_q)){
?>
<option value="<?php echo $mat_hospi['cod']; ?>"><?php echo $mat_hospi['Lugar']; ?></option>
<?php
}
?>
</select>

&nbsp;<input type="button" value="Aceptar" class="boton" 

onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var hospital = document.getElementById('centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>').value;

$ajaxload('bus','Form/Actualizar_ficha40.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&hospital='+hospital,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
"

 />
<?php
}
?>

<br /><br />
<table style="width:400px;" class="celda1">
<tr>
<td class="celda3">
<?
///////////////////////////////////////////////////////////////////////////////////////////
$estado = "SELECT destino FROM destino WHERE cod = '".$matriz_resultados['obser_man']."'";
$con_estado = mysql_query($estado);
$estado_num = mysql_num_rows($con_estado);

if($estado_num > 0){

$mat_estado = mysql_fetch_array($con_estado);
echo '<h1 style="color:#00CC66">Estado: '.$mat_estado['destino'].'</h1>';
}
else{
echo '<br /><blink style="color:#FF0000">Debe Registrar accion</blink>';
}

$diagnostico_n = "SELECT diagnostico.diagnostico FROM fichas INNER JOIN diagnostico ON diagnostico.cod = fichas.diagnostico WHERE fichas.correlativo = ".$matriz_resultados['correlativo']."";
$diagnostico_n_q = mysql_query($diagnostico_n);
$diag_num = mysql_num_rows($diagnostico_n_q);

if($diag_num > 0){
$mat_diag_q = mysql_fetch_array($diagnostico_n_q);
echo '<h1 style="color:#00CC66">Diagnostico: '.$mat_diag_q['diagnostico'].'</h1>';
}
else{
echo '<blink style="color:#FF0000">Debe Registrar el diagnostico</blink>';

}

if ($matriz_resultados['obser_man'] == '45')
{ 
	$estado = "SELECT Lugar FROM centrohospita WHERE cod = '".$matriz_resultados['CentroHospitalario']."'";
	$con_estado = mysql_query($estado);
	$estado_num = mysql_num_rows($con_estado);

	if($estado_num > 0){

	$mat_estado = mysql_fetch_array($con_estado);
	echo '<h1 style="color:#00CC66">Centro Hospitalario: '.$mat_estado['Lugar'].'</h1>';
	}
	else{
	echo '<br /><blink style="color:#FF0000">Debe Registrar el Centro Hospitalario</blink>';
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($matriz_resultados['cod_plan'] == 'CA'){
$plann = 'CARGA NO REGISTRADA';
}
if($matriz_resultados['cod_plan'] == 'PA'){
$plann = 'PARTICULAR';
}

if (($matriz_resultados['cod_plan'] != 'PA') && ($matriz_resultados['cod_plan'] != 'CA')){

$plann =$matriz['desc_plan'];
}
echo '<h1 style="color:#00CC66">Plan: '.$plann.'</h1>';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</td>
</tr>
</table>
<br /><br />
<?php 
if ($matriz_resultados['obser_man'] == '45')
{ 
?>
<table style="width:auto; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda2">
<tr>
<td class="celda3" style="background-color:#FFFEE0">
<a href="#" onclick="$ajaxload('bus','Form/cambiarhora.php?corre=<?php echo $num; ?>','Cargando',false,false);
if($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo'];?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}">Hs Llega Destino</a><br />
  <div id="hs_Llega_Destino_<?php echo $matriz_resultados['correlativo']; ?>"><?php echo $matriz_resultados['hora_llega_destino']; ?></div></td>

<td class="celda3" style="background-color:#FFFEE0">
<a href="#" onclick="$ajaxload('bus','Form/cambiarhora2.php?corre=<?php echo $num; ?>','Cargando',false,false);
if($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo'];?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}
">Hs sale Destino</a><br />
  <div id="hs_sale_Destino_<?php echo $matriz_resultados['correlativo']; ?>"><?php echo $matriz_resultados['hora_sale_destino']; ?></div></td>
</tr>
</table>
<?php
}
?>
<br />
Boleta&nbsp;<input type="text" id="boleta_<?php echo $matriz_resultados['correlativo']; ?>" />&nbsp;
Importe&nbsp;<input type="text" id="importe_<?php echo $matriz_resultados['correlativo']; ?>" /><br /><br />
Tipo de Pago&nbsp;<select name="tipopago" id="tipo_pago<?php echo $matriz_resultados['correlativo']; ?>">
  <option value="1">EFECTIVO</option>
  <option value="2">CHEQUE</option>
  <option value="3">PENDIENTE</option>
  <option value="4">CASOS ESPECIALES</option>
  <option value="5">DESC. X PLANILLA</option>
</select>
<?php
}//FIN IF COM PURBEA
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------- -->  
<br /><br />
<div align="right"><input type="button" value="GUARDAR" class="boton" id="guardar_<?php echo $matriz_resultados['correlativo']; ?>" / onclick="
var boleta= document.getElementById('boleta_<?php echo $matriz_resultados['correlativo']; ?>').value;
var importe= document.getElementById('importe_<?php echo $matriz_resultados['correlativo']; ?>').value;
var tipo_pago =document.getElementById('tipo_pago<?php echo $matriz_resultados['correlativo']; ?>').value; 

if( (!boleta) || (!importe) || (!tipo_pago) ){
alert('Debe llenar los campos');
}
else{
$ajaxload('bus','Form/guardar_form.php?boleta='+boleta+'&importe='+importe+'&tipo_pago='+tipo_pago+'&movil=<?php echo $matriz_resultados['movil']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nsocio=<?php echo $matriz_resultados['num_solici']; ?>','Cargando',false,false);
}
" ></div>
</td>
</tr>
<!-- IMPORTANTEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->
</table>
</td>
</tr>
</table>

  <?php
}//FIN TRASLADOA CENTRO HOSPITALARIO
?>
<?php
}// FIN DEL WHILE PRINCIPAL
mysql_close($conexion);
?>
<!-- FIN DE LA TABLA QUE CONTIENE -->
