<?php
include('../conf.php');
include('../bd.php');

$cod = $_GET['cod'];

$consulta = "select cod,sintoma,PreguntasClave,PreArribo,rojo,amarillo,verde,causas,observaciones from sintomas where cod = '".$cod."'";
$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);	

?>
<div align="right" style="padding:0; margin:0px; font-size:12px">

<?php echo $matriz_resultados['cod']; ?> <?php echo $matriz_resultados['sintoma']; ?>

<a href="#" onclick="javascript:cerrarPopup('popup','<?php echo $matriz_resultados['cod']; ?>')" class="boton1">
<img style="background-color:#F7F7F7" src="IMG/exclamation.png" width="16" height="16" />
</a>
</div>

<div style="overflow:auto; height:170px">
<table class="celda3" style="width:380px">
<tr>
<td class="celda3">Preguntas Claves</td>
</tr>

<tr>
<td class="celda2"><?php echo $matriz_resultados['PreguntasClave']; ?></td>
</tr>

<tr>
<td class="celda3">Intrucciones Pre-Arribo</td>
</tr>

<tr>
<td class="celda2"><?php echo $matriz_resultados['PreArribo']; ?></td>
</tr>
</table>

<table class="celda3" style="width:380px">
<tr>
<td class="celda3">Rojo</td>
<td class="celda3">Amarillo</td>
<td class="celda3">Verde</td>
</tr>

<tr>
<td class="celda2"><?php echo $matriz_resultados['rojo']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['amarillo']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['verde']; ?></td>
</tr>
</table>

<table class="celda3" style="width:380px">
<tr>
<td class="celda3">causas</td>
</tr>

<tr>
<td class="celda2"><?php echo $matriz_resultados['causas']; ?></td>
</tr>

<tr>
<td class="celda3">observaciones</td>
</tr>

<tr>
<td class="celda2"><?php echo $matriz_resultados['observaciones']; ?></td>
</tr>


</table>
<?	
mysql_close($conexion);
?>
</div>