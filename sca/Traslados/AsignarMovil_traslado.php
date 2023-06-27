<?php
include('../conf.php');
include('../bd.php');

if ( isset($_GET['guardar']) ){


$direccion = 'De '.$_GET['d_origen'].' a '.$_GET['d_destino'];

$con ="select max(correlativo) as maximo from fichas";
$res = mysql_query($con);
$mat = mysql_fetch_array($res);
$correlativo =$mat['maximo'];
$correlativo = $correlativo +1;

$query="UPDATE fichas SET fichas.operador='".$_GET['operador']."',correlativo='".$correlativo."',fichas.celular='".$_GET['celular']."' ,telefono='".$_GET['telefono']."',movil='".$_GET['movil']."',obser_man='49',hora_llamado='".$_GET['hora_llamado']."',direccion='".$direccion."',sector='".$_GET['sector']."',observacion='".$_GET['obser']."',estado='1' WHERE fichas.traslado='".$_GET['cod']."'";

$con = "UPDATE movilasig SET estado='1' WHERE numero = '".$_GET['movil']."'";
$qqq= mysql_query($con);
$resultados = mysql_query($query);

$con2 = "UPDATE traslados SET estado='1' WHERE cod='".$_GET['cod']."'";
$qqq2= mysql_query($con2);


/*
$_GET['fecha_tras'];
$_GET['d_origen'];
$_GET['d_destino'];
*/
echo MENSAJE88;

exit;
}

$cod = $_GET['cod'];

$query = "SELECT hora_llamado as hora_mysql,fichas.telefono,fichas.celular,DATE_FORMAT(fichas.hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,traslados.Direccion_origen,traslados.Direccion_destino,traslado_tipo.traslado AS tipo_traslado, planes_traslados.desc_plan,fichas.paciente,DATE_FORMAT(traslados.fecha_traslado,'%d-%m-%Y %H:%i:%S') as fecha_traslado, traslados.cod AS cod
FROM fichas 
INNER JOIN traslados ON traslados.cod=fichas.traslado 
INNER JOIN traslado_tipo ON traslado_tipo.cod=traslados.tipo_traslado
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE fichas.estado=0 AND traslados.estado=0 AND traslados.cod='".$cod."' AND fichas.traslado='".$cod."'";

$resultados = mysql_query($query);
$matriz_resultados = mysql_fetch_array($resultados);
?>
<div class="formulario">
<form method="get" name="form1">
 <br />
<table style="width:480px;" class="celda2">

<tr class="celda1">
<td><h1>Ficha Traslados</h1></td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="celda3">Tipo de Traslado</td>
<td class="celda2"><div id="tipo_tras"><?php echo $matriz_resultados['tipo_traslado']; ?></div></td>
</tr>

<tr>
<td class="celda3">Convenio</td>
<td class="celda2"><div id="convenio"><?php echo $matriz_resultados['desc_plan']; ?></div></td>
</tr>

<tr>
<td class="celda3">Paciente</td>
<td class="celda2"><div id="paciente"><input style="width:90%;" type="text" value="<?php echo $matriz_resultados['paciente']; ?>" id="paciente" /></td>
</tr>
</table>
 
<table style="width:480px;" class="celda2">
<tr>
<td width="63" class="celda3">Telefono</td>
<td width="193" class="celda2"><input style="width:90%;" type="text" id="telefono" value="<?php echo $matriz_resultados['telefono']; ?>" /></td>
<td width="52" class="celda3">Celular</td>
<td width="172" class="celda2"><input style="width:90%;" id="celular" type="text" value="<?php echo $matriz_resultados['celular']; ?>" /></td>
</tr>

<tr>
<td class="celda3">Fecha Llamado</td>
<td class="celda2"><input style="width:90%;" id="hora_llamado" value="<?php echo $matriz_resultados['hora_llamado']; ?>" /></td>
<td class="celda3">Fecha Traslado</td><td class="celda2"><input style="width:90%;" type="text" id="fecha_tras" value="<?php echo $matriz_resultados['fecha_traslado']; ?>" /></td>
</tr>

<tr>
<td class="celda3">Direcci&oacute;n Origen</td>
<td class="celda2"><input type="text" style="width:90%;" value="<?php echo $matriz_resultados['Direccion_origen']; ?>" id="d_origen" /></td>
<td class="celda3">Destino</td>
<td class="celda2"><input type="text" style="width:90%;" value="<?php echo $matriz_resultados['Direccion_destino']; ?>" id="d_destino" /></td>
</tr>
</tr>
</table>


<table style="width:480px;" class="celda2">
<tr>
<td class="celda3">Movil</td>
<td class="celda3">Sector</td>
</tr>
<tr>

<td class="celda2">
<div id="movil_asignados">
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0; height:80px; width:220px; height:80px; font-size:10px">
<?php

if ( ($matriz_resultados['tipo_traslado'] == 'Traslado Programados Afiliados Directos')||($matriz_resultados['tipo_traslado'] == 'Traslado Medicalizado Convenio')){
$consulta = "select numero from movilasig where estado = 0 "/*and medico > 1"*/;
}
else{
$consulta = "select numero from movilasig where estado = 0 "/* and medico < 2 "*/;		
}
$resultados = mysql_query($consulta);
while($matriz_resultados2 = mysql_fetch_array($resultados)){
?>
<option class="text"  value="<?php echo $matriz_resultados2['numero']; ?>" id="movil"><?php echo 'Movil '.$matriz_resultados2['numero']; ?></option>
<?php
}
?>
</select>
</div>
</td>
<td class="celda2">

<select name="sector" id="sector" size="5" style="background-color:#FFFEE0; height:80px; width:220px; height:80px; font-size:10px">
<?php

$consulta_sector = "SELECT sector.cod, sector.sector FROM sector";		
$resultados_sector = mysql_query($consulta_sector);
while($mat_sector = mysql_fetch_array($resultados_sector)){
?>
<option class="text" value="<?php echo $mat_sector['cod']; ?>"><?php echo $mat_sector['sector']; ?></option>
<?php
}
?>
</select>


</td>
</tr>
</table>

<table style="width:480px;" class="celda2">
<tr>
<td class="celda3"><img src="IMG/note.png" width="16" height="16" />&nbsp;Observaciones<br />
<input type="text" value="<?php echo $matriz_resultados['hora_mysql']; ?>" id="mysql" style="display:none;" />
<input class="text" name="observacion" type="text" id="observacion" value="" size="50" style="width:450px; height:60px;" />
<br /><br />

<div align="right">
<input type="button" value="Guardar" class="boton" onclick="
if  ( (!document.getElementById('movil').value) || (!document.getElementById('sector').value) ) {
alert('Debe asignar el movil y el sector');
}
else{
if(confirm('Desea asignar el movil?')) {


var telefono = document.getElementById('telefono').value;
var celular = document.getElementById('celular').value;
var hora_llamado = document.getElementById('mysql').value;
var fecha_tras = document.getElementById('fecha_tras').value;
var d_origen = document.getElementById('d_origen').value;
var d_destino = document.getElementById('d_destino').value;
var sector = document.getElementById('sector').value;
var observacion = document.getElementById('observacion').value;


$ajaxload('traslado_s','Traslados/AsignarMovil_traslado.php?guardar=1&cod=<?php echo $cod; ?>&operador=<?php echo $_GET['operador']; ?>&fecha_tras='+fecha_tras+'&d_origen='+d_origen+'&d_destino='+d_destino+'&telefono='+telefono+'&celular='+celular+'&hora_llamado='+hora_llamado+'&movil='+document.getElementById('movil').value+'&obser='+document.getElementById('observacion').value+'&sector='+sector,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);}

if ($ajaxload){
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',true);
if ($ajaxload){
$ajaxload('cabezera','Traslados/Actualizar_Aviso.php',false,false,false);
}
}
}
" />
</div>

</td>
</tr>
</table>

</form>
</div>