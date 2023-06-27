<?php
include('../conf.php');
include('../bd.php');
$cod = $_GET['cod'];

$query = "select tipo_traslado, convenio, paciente, telefono, celular, fecha_traslado, hora_llamado, Direccion_origen, Direccion_destino, ciudad, costo, estado, cod from traslados where cod = '".$cod."'";

$resultados = mysql_query($query);
$matriz_resultados = mysql_fetch_array($resultados);
?>
<div class="formulario">
<form method="get" name="form1">
<table style="width:500px;" class="celda1">

<tr>
<td><h1>Ficha Traslados</h1></td>
</tr>

<tr>
<td class="celda3">Tipo de Traslado</td>
<td class="celda2"><div id="tipo_tras"><?php echo $matriz_resultados['tipo_traslado']; ?></div></td>
</tr>

<tr>
<td class="celda3">Convenio</td>
<td class="celda2"><div id="convenio"><?php echo $matriz_resultados['convenio']; ?></div></td>
</tr>

<tr>
<td class="celda3">Paciente</td>
<td class="celda2"><div id="paciente"><?php echo $matriz_resultados['paciente']; ?></div></td>
</tr>
</table>
 
<table style="width:500px;" class="celda1">
<tr>
<td width="63" class="celda3">Telefono</td>
<td width="193" class="celda2"><div id="telefono"><?php echo $matriz_resultados['telefono']; ?></div></td>
<td width="52" class="celda3">Celular</td>
<td width="172" class="celda2"><div id="celular"><?php echo $matriz_resultados['celular']; ?></div></td>
</tr>

<tr>
<td class="celda3">Fecha Llamado</td>
<td class="celda2"><div id="hora_llamado"><?php echo $matriz_resultados['hora_llamado']; ?></div></td>
<td class="celda3">Fecha Traslado</td><td class="celda2"><div id="fecha_tras"><?php echo $matriz_resultados['fecha_traslado']; ?></div></td></tr>
</tr>
</table>


<table style="width:500px;" class="celda1">
<tr>
<td  class="celda3">Movil Asig</td>
</tr>
<tr>

<td class="celda2">
<div id="movil_asignados">
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0; height:80px; width:90px; height:80px; font-size:10px">
<?php
$consulta = "select numero from movilasig where estado = 0 and medico < 1";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" ondblclick="DetalleAmbulancia('<? echo $matriz_resultados['numero'];?>')" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>
</select>
</div>
</td>
</tr>
</table>

<table style="width:500px;" class="celda1">
<tr>
<td class="celda3"><img src="IMG/note.png" width="16" height="16" />&nbsp;Observaciones<br />
<input class="text" name="observacion" type="text" id="observacion" value="" size="50" />&nbsp;
<input type="button" value="Guardar" class="boton" onclick="<?php echo $funcion;?>" />
</td>
</tr>
</table>
</form>
</div>