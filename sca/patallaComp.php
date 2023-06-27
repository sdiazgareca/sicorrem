<?php
include('conf.php');
include('bd.php');

if ( isset($_GET['muestramovil_2']) ){
$consulta = "and fichas.color = '".$_GET['muestramovil_2']."'";
}

if ( isset($_GET['nombre_bus']) ){
$consulta = "and paciente like '".$_GET['nombre_bus']."%'";
}

if ( isset($_GET['direccion_bus']) ){
$consulta = "and direccion like '".$_GET['direccion_bus']."%'";
}

if (  isset($_GET['movil']) ){
$consulta = "and movil < 1000";
}

if ( isset($_GET['movil_bus']) ){
$consulta = "and movil = '".$_GET['movil_bus']."'";
}

if ( isset($_GET['espera']) ){
$consulta = "and movil >= 1000";
}

?>
<div style="height:auto">
<div align="right" style="padding:0; margin:0px; font-size:12px">

<?php echo $matriz_resultados['cod']; ?> <?php echo htmlentities($matriz_resultados['sintoma']); ?>
<a href="#" onclick="javascript:cerrarPopup('patallagrande','vol')" class="boton1">
<img style="background-color:#F7F7F7" src="IMG/exclamation.png" width="16" height="16" />
</a>
</div>

<div id="menu" style="padding:5px;" align="right">

<table align="right" style="width:100%; margin:0px;">
<tr>
<td class="celda3">
Clave
&nbsp;
<select id="muestramovil_2">
<option value="1">Rojo</option>
<option value="2">Amarillo</option>
<option value="3">Verde</option>
<option value="4">Azul</option>
</select>
&nbsp;
<input type="button" class="boton" value="Mostrar" style="color:#006699" onclick="$ajaxload('patallagrande','patallaComp.php?muestramovil_2='+document.getElementById('muestramovil_2').value,false,false,false);"/>
&nbsp;
Nombre&nbsp;
<input type="text" name="nombre_bus" id="nombre_bus" />&nbsp;
<input type="button" class="boton" value="Buscar" id="boton_nombre_bus" onclick="$ajaxload('patallagrande','patallaComp.php?nombre_bus='+document.getElementById('nombre_bus').value,false,false,false);" />
&nbsp;Direcci&oacute;n
&nbsp;
<input name="direccion_bus" type="text" id="direccion_bus"/>
&nbsp;
<input type="button" class="boton" value="Buscar" onclick="$ajaxload('patallagrande','patallaComp.php?direccion_bus='+document.getElementById('direccion_bus').value,false,false,false);" />

&nbsp;Movil
&nbsp;
<select name="movil_bus" id="movil_bus">
<option value=""></option>
<?php
$movil = "select numero from movilasig where estado = 1";
$consu = mysql_query($movil);
while ($mat = mysql_fetch_array($consu)){
?>
<option value="<?php echo $mat['numero'];?>"><?php echo $mat['numero'];?></option>
<?php
}
?>
</select>
&nbsp;
<input type="button" class="boton" value="Buscar" onclick="$ajaxload('patallagrande','patallaComp.php?movil_bus='+document.getElementById('movil_bus').value,false,false,false);" />
&nbsp;
Mostar

&nbsp;
<input type="submit" class="boton" value="Movil" onclick="$ajaxload('patallagrande','patallaComp.php?movil=1',false,false,false);" />

&nbsp;
<input type="submit" class="boton" value="Espera" onclick="$ajaxload('patallagrande','patallaComp.php?espera=1',false,false,false);" />

&nbsp;
<input type="submit" class="boton" value="Todos" onclick="$ajaxload('patallagrande','patallaComp.php',false,false,false);" />
</tr>
</table>

</div>
<br />
<table style="width:auto; margin:0px">

<?php 
include('conf.php');
include('bd.php');

$con = "SELECT count(correlativo) as coto from 
fichas 
inner join sector on  fichas.sector = sector.cod
inner join color on  fichas.color = color.cod
inner join afiliados on fichas.nro_doc = afiliados.nro_doc where estado =1";
$resultados2 = mysql_query($con);
$matriz_resultados2 = mysql_fetch_array($resultados2);


for ($i=0; $i <= $matriz_resultados2['coto']; $i = $i+5){
$contador = 1;


$query ="SELECT apellido,nombre1,nombre2,direccion,sector.sector,color.color,color.cod as cod_color,fichas.nro_doc,paciente,correlativo,movil,DATE_FORMAT(hora_llamado, '%H:%i') as hora,DATE_FORMAT(hora_llamado, '%d/%m/%Y') as dia from 
fichas 
inner join sector on  fichas.sector = sector.cod
inner join color on  fichas.color = color.cod
inner join afiliados on fichas.nro_doc = afiliados.nro_doc where estado =1 ".$consulta." group by movil limit ".$i.",5";

$resultados = mysql_query($query);
while ($matriz_resultados = mysql_fetch_array($resultados)){

if($matriz_resultados['movil'] < 10000){
$fondo ='#E3EEE6';
$texto_movil = ' Movil '.$matriz_resultados['movil'];
}
if($matriz_resultados['movil'] >= 1000){
$fondo ='#FFFFFF';
$texto_movil = ' EN ESPERA '.($matriz_resultados['movil'] - 1000);
}
if($contador == 1){
echo '<tr>';
}
?>
<td  style="border:solid 2px; background-color: <?php echo $fondo; ?>; font-size:11px;"  class="celda3">
<div>

<a class="boton1"href="#" onclick="$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultadosX['correlativo']; ?>&nro_doc=<?php echo $matriz_resultadosX['nro_doc']; ?>&num=<?php echo $matriz_resultados['movil']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);cerrarPopup('patallagrande','vol');"><img src="IMG/user.png" width="16" height="16" /></a>

<?php echo strtoupper($texto_movil); ?>&nbsp;(<?php echo $matriz_resultados['hora'].' '.$matriz_resultados['dia']; ?>)</div>

<div id="<?php echo $matriz_resultados['movil']; ?>">
<?php
$consultaX = "select color, correlativo, nro_doc, paciente from fichas where movil ='".$matriz_resultados['movil']."' and estado = 1";

$resultadosX = mysql_query($consultaX);
while ($matriz_resultadosX = mysql_fetch_array($resultadosX)){

switch($matriz_resultadosX['color']){

case '1':
$color = '#FF0000';
break;

case '2':
$color ='#FFC000';
break;

case '3':
$color ='#008000';
break;

case '4':
$color ='#0000FF';
break;
}

?>
<div style="float:left;color:<?php echo $color;?>"><?php echo strtoupper($matriz_resultadosX['paciente']); ?>&nbsp;</div>
<?php
}
?>
</div>
<br />
Dire:&nbsp;<?php echo strtoupper($matriz_resultados['direccion']);?> 
<br />
Sect:&nbsp;<?php echo strtoupper($matriz_resultados['sector']); ?>
</td>
<?php
if ($contador == 5){
echo '</tr>';
$contador = 1;}
else{
$contador = $contador+1;
}
}
?>

<?php
}
?>
</table>
</div>
<?
mysql_close($conexion);
?>