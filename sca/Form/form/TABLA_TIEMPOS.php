
<?php

//OBTIENE VALORES HORA LLEGADA; HORA SALIDA ETC...
$consulta = "SELECT nro_doc,DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') AS hora_llamado,
DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') AS hora_despacho,
DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') AS hora_salida_base,
DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_llegada_domicilio,
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_sale_domicilio,
DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') AS hora_llega_destino,
DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') AS hora_sale_destino,
telefono,direccion,entre,movil,color,sector.sector AS sector,obser_man,
observacion,celular,edad,paciente,correlativo,obser_man,diagnostico,
num_solici
FROM fichas INNER JOIN sector ON sector.cod = fichas.sector  where movil='".$num."' and estado=1";

$resultados = mysql_query($consulta);
$matriz_resultados1 = mysql_fetch_array($resultados);
?>
<!-- MUESTRA EL TITULO y BOTON PARA ASIGNAR HORARIO--> 
<h1>
<img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;<?php echo $men; ?>
<?php if ($num < 1000){
?>
&nbsp;
<a href="#" class="boton1" onClick="MuestraVentana('control_de_tiempos','<?php echo $matriz_resultados1['nro_doc']; ?>','<?php echo $matriz_resultados1['correlativo']; ?>')">
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
<?php
if ( ($matriz_resultados1['color'] == '4') || ($matriz_resultados1['obser_man'] == '45') ){
?>
<tr>
<td width="70" class="celda3" style="background-color:#FFFEE0">Hs llega Dest<br />
  <?php echo $matriz_resultados1['hora_llega_destino']; ?></td>
<td width="70" class="celda3" style="background-color:#FFFEE0">Hs sale Dest<br />
  <?php echo $matriz_resultados1['hora_sale_destino']; ?></td>
</tr>
<?php
}
?>
</table>
<br />
