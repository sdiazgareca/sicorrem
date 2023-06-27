<?php
include('../conf.php');
include('../bd.php');

if ( isset($_GET['guardar']) ){

echo $_GET['convenio'].'<br />';
echo $_GET['paciente'].'<br />';
echo $_GET['telefono'].'<br />';
echo $_GET['celular'].'<br />';
echo $_GET['fecha_llamado'].'<br />';
echo $_GET['fecha_traslado'].'<br />';
echo $_GET['movil'].'<br />';
echo $_GET['obser'].'<br />';
echo $_GET['tipo_tras'];

if ($_GET['tipo_tras'] == 'Traslado Programados Afiliados Directos'){
$tras = 'T3';
}

if ($_GET['tipo_tras'] == 'Traslado Simple Particular'){
$tras = 'T4';
}

if ($_GET['tipo_tras'] == 'Traslado Simple Convenio'){
$tras = 'T2';
}
	
if ($_GET['tipo_tras'] == 'Traslado Medicalizado Convenio'){
$tras = 'T1';
}

$con ="select max(correlativo) as maximo from fichas";
$res = mysql_query($con);
$mat = mysql_fetch_array($res);
$correlativo =$mat['maximo'];
$correlativo = $correlativo + 1;

$nuevaconsulta="insert into sintomas_reg (sintoma,rut,correlativo) values ('$tras','','$correlativo')";
$REE = mysql_query($nuevaconsulta);


$consulta="insert into fichas(correlativo,sector,entre,telefono,direccion,movil,color,observacion,hora_llamado,celular,paciente,operador,obser_man, destino,estado,cod_plan,tipo_plan,isapre) 

values (".$correlativo.",'4','".entre."','".$_GET['telefono']."','direccion','".$_GET['movil']."','4','".$_GET['obser']."','".$_GET['fecha_llamado']."',  '".$_GET['celular']."', '".$_GET['paciente']."',  '".$_GET['operador']."',  '',  '',  '1',  '',  '',  '')";
$resultados = mysql_query($consulta);

$coonsulta2="update movilasig set  estado='1' where numero='".$_GET['movil']."'";
$resultados2 = mysql_query($coonsulta2);

$conul ="update traslados set estado='1' where cod='".$_GET['cod']."'";
$resul =  mysql_query($conul);
exit;
}

$cod = $_GET['cod'];

$query = "select ciudad,Direccion_destino,Direccion_origen,desc_plan,tipo_traslado, traslados.convenio as convenio, paciente, telefono, celular, fecha_traslado, hora_llamado, Direccion_origen, Direccion_destino, ciudad, costo, estado, cod, DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%s') as horallamado, DATE_FORMAT(fecha_traslado,'%d-%m-%Y %H:%s') as fechatraslado
from traslados inner join planes on planes.cod_plan = traslados.convenio where cod = '".$cod."'";

$resultados = mysql_query($query);
$matriz_resultados = mysql_fetch_array($resultados);
?>
<div class="formulario">
<form method="get" name="form1">
 <br />
<table style="width:480px;" class="celda1">

<tr>
<td><h1>Ficha Traslados</h1></td>
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
<td class="celda2"><div id="paciente"><?php echo $matriz_resultados['paciente']; ?></div></td>
</tr>
</table>
 
<table style="width:480px;" class="celda1">
<tr>
<td width="63" class="celda3">Telefono</td>
<td width="193" class="celda2"><div id="telefono"><?php echo $matriz_resultados['telefono']; ?></div></td>
<td width="52" class="celda3">Celular</td>
<td width="172" class="celda2"><div id="celular"><?php echo $matriz_resultados['celular']; ?></div></td>
</tr>

<tr>
<td class="celda3">Fecha Llamado</td>
<td class="celda2"><div id="hora_llamado"><?php echo $matriz_resultados['horallamado']; ?></div></td>
<td class="celda3">Fecha Traslado</td><td class="celda2"><div id="fecha_tras"><?php echo $matriz_resultados['fechatraslado']; ?></div></td>
</tr>

<tr>
<td class="celda3">Direcci&oacute;n Origen</td>
<td class="celda2"><?php echo $matriz_resultados['Direccion_origen']; ?></td>
<td class="celda3">Destino</td>
<td class="celda2"><?php echo $matriz_resultados['Direccion_destino']; ?></td>
</tr>
</tr>
</table>


<table style="width:480px;" class="celda1">
<tr>
<td class="celda3">Movil</td>
<td class="celda3">Sector</td>
</tr>
<tr>

<td class="celda2">
<div id="movil_asignados">
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0; height:80px; width:90px; height:80px; font-size:10px">
<?php

if ( ($matriz_resultados['tipo_traslado'] == 'Traslado Programados Afiliados Directos ')||($matriz_resultados['tipo_traslado'] == 'Traslado Medicalizado Convenio')){
$consulta = "select numero from movilasig where estado = 0 and medico > 0";
}
else{
$consulta = "select numero from movilasig where estado = 0 and medico < 1";		
}
$resultados = mysql_query($consulta);
while($matriz_resultados2 = mysql_fetch_array($resultados)){
?>
<option class="text" ondblclick="DetalleAmbulancia('<? echo $matriz_resultados['numero'];?>')" value="<?php echo $matriz_resultados2['numero']; ?>"><?php echo 'Movil '.$matriz_resultados2['numero']; ?></option>
<?php
}
?>
</select>
</div>
</td>
<td class="celda2">

<select name="sector" size="5" id="sector" style="background-color:#FFFEE0; height:80px; width:90px; height:80px; font-size:10px">
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

<table style="width:480px;" class="celda1">
<tr>
<td class="celda3"><img src="IMG/note.png" width="16" height="16" />&nbsp;Observaciones<br />

<input class="text" name="observacion" type="text" id="observacion" value="" size="50" />&nbsp;
<input type="button" value="Guardar" class="boton" onclick="if (!document.getElementById('movil').value){
alert('Debe asignar el movil');
}
else{
if(confirm('Desea asignar el movil?')) {
$ajaxload('traslado_s','Traslados/AsignarMovil_traslado.php?guardar=1&tipo_tras=<?php echo $matriz_resultados['tipo_traslado']; ?>&cod=<?php echo $cod; ?>&operador=<?php echo $_GET['operador']; ?>&convenio=<?php echo $matriz_resultados['convenio']; ?>&paciente=<?php echo $matriz_resultados['paciente']; ?>&telefono=<?php echo $matriz_resultados['telefono']; ?>&celular=<?php echo $matriz_resultados['celular']; ?>&fecha_llamado=<?php echo $matriz_resultados['hora_llamado']; ?>&fecha_traslado=<?php echo $matriz_resultados['fecha_traslado']; ?>&movil='+document.getElementById('movil').value+'&obser='+document.getElementById('observacion').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);}
}" />
</td>
</tr>
</table>
</form>
</div>