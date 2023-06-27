<?php
include('../conf.php');
include('../bd.php');
?>
<div class="formulario">
<table>
<tr>
<td class="celda1">DETALLE ATENCI&Oacute;N</td>
</tr>
</table>
<table>
<tr>
<td class="celda2">
INNER JOIN diagnostico ON diagnostico.cod = fichas.diagnostico
diagnostico.diagnostico
<?php

$query ="SELECT telefono, direccion,entre,movil,color.color AS color, sector.sector AS sector, observacion,
correlativo,num_solici, celular, edad,paciente,nro_doc,destino.destino,
DATE_FORMAT(fichas.hora_llamado,'%T %d-%m-%Y') AS llamado,
DATE_FORMAT(fichas.hora_despacho,'%T %d-%m-%Y') AS despacho,
DATE_FORMAT(fichas.hora_llegada_domicilio,'%T %d-%m-%Y') llega_domi,
DATE_FORMAT(fichas.hora_sale_domicilio,'%T %d-%m-%Y') AS sale_domi,
DATE_FORMAT(fichas.hora_llega_destino,'%T %d-%m-%Y') AS llega_destino,
DATE_FORMAT(fichas.hora_sale_destino,'%T %d-%m-%Y') AS sale_destino,
fichas.medico,
fichas.operador,
fichas.paramedico
FROM fichas
INNER JOIN color ON color.cod=fichas.color
INNER JOIN sector ON sector.cod=fichas.sector
INNER JOIN destino ON destino.cod=fichas.obser_man

WHERE correlativo ='".$_GET['protocolo']."'";
$resultados = mysql_query($query);
while($matriz_resultados = mysql_fetch_array($resultados)){

?>
<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">


<tr>
<td width="60">Correlativo:</td> <td width="140"><?php echo $matriz_resultados['correlativo']; ?></td>
<td width="46">Contrato:</td> <td width="120"><?php echo $matriz_resultados['num_solici']; ?></td>
<td width="19">Rut:</td><td width="67"><?php echo $matriz_resultados['nro_doc']; ?></td>
</tr>
</table>


<br />

<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">
<tr>
<td width="43" align="left">Paciente:</td><td width="210" align="left"><?php echo $matriz_resultados['paciente']; ?></td>
<td width="47" align="left">Telefono:</td><td width="46" align="left"><?php echo $matriz_resultados['telefono']; ?></td>
<td width="39" align="left">Celular:</td><td width="67" align="left"><?php echo $matriz_resultados['celular']; ?></td>
</tr>
</table>

<br />

<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">

<tr>
<td width="55" align="left">Direcci&oacute;n:</td> <td width="413" align="left"><?php echo $matriz_resultados['direccion']; ?></td>
</tr>

<tr>
<td align="left">Entre:</td><td align="left"><?php echo $matriz_resultados['entre']; ?></td>
</tr>

<tr>
<td align="left">Sector:</td><td align="left"><?php echo $matriz_resultados['sector']; ?></td>
</tr>

<tr>
<td align="left">Destino:</td><td align="left"><?php echo $matriz_resultados['destino']; ?></td>
</tr>
</table>


<br />

<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">

<tr>
<td width="27" align="left">Clave:</td> <td width="27" align="left"><?php echo $matriz_resultados['color']; ?></td>
<td width="30" align="left">Movil:</td><td width="27" align="left"><?php echo $matriz_resultados['movil']; ?></td>
<td width="57" align="left">Diagnostico:</td><td width="284" align="left"><?php echo $matriz_resultados['diagnostico']; ?></td>
</tr>

</table>

<br />
<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">
<tr>
<td>Observaci&oacute;n</td>
</tr>
<tr>
<td><?php echo $matriz_resultados['observacion']; ?></td>
</tr>
</table>


<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">
<caption>Horarios</caption>

<tr>
<td>Llamado</td>
<td>Despacho</td>
<td>Llegada Domicilio</td>
<td>Salida Domicilio</td>
<td>Llegada Destino</td>
<td>Salida Destino</td>
</tr>

<tr>
<td><?php echo $matriz_resultados['llamado']; ?></td>
<td><?php echo $matriz_resultados['despacho']; ?></td>
<td><?php echo $matriz_resultados['llega_domi']; ?></td>
<td><?php echo $matriz_resultados['sale_domi']; ?></td>
<td><?php echo $matriz_resultados['llega_destino']; ?></td>
<td><?php echo $matriz_resultados['sale_destino']; ?></td>
</tr>
</table>





<?php

$medico = "SELECT personal.nombre1,personal.apellidos FROM personal WHERE personal.rut='".$matriz_resultados['medico']."'";
$medico_q = mysql_query($medico);
$medico_m = mysql_fetch_array($medico_q);

$paramedico = "SELECT personal.nombre1,personal.apellidos FROM personal WHERE personal.rut='".$matriz_resultados['paramedico']."'";
$paramedico_q = mysql_query($paramedico);
$paramedico_m = mysql_fetch_array($paramedico_q);

$operador = "SELECT operador.nombre1, operador.apellido FROM operador WHERE operador.rut='".$matriz_resultados['operador']."'";
$operador_q = mysql_query($operador);
$operador_m = mysql_fetch_array($operador_q);
?>
<br/>
<table class="celda1" style="font-size:11px; width:480px; background-color:#FFF; color:#000;" border="1">
<caption>Personal</caption>
<tr>
<td>OPERADOR</td>
<td><?php echo strtoupper($operador_m['nombre1']). ' '.strtoupper($operador_m['apellido']); ?></td>
</tr>

<tr>
<td>MEDICO</td>
<td><?php echo $medico_m['nombre1']. ' '.$medico_m['apellidos']; ?></td>
</tr>

<tr>
<td>PARAMEDICO</td>
<td><?php echo $paramedico_m['nombre1']. ' '.$paramedico_m['apellidos']; ?></td>
</tr>

</table>
<?php
}
?>
</td>
</tr>
</table>
</div>
