<?php
if($matriz_resultados['movil'] < 1000){
$fondo ='#E3EEE6';
$texto_movil = ' Movil '.$matriz_resultados['movil'];
}
if($matriz_resultados['movil'] >= 1000){
$fondo ='#FFFFFF';
$texto_movil = ' EN ESPERA '.($matriz_resultados['movil'] -1000);
}
?>

<tr>

<td  style=" color:#003366; border:solid 2px; background-color: <?php echo $fondo; ?>; font-size:11px;"  class="celda3">
<div>
<strong>PROTOCOLO <?php echo $matriz_resultados['correlativo']; ?></strong><br />
<a class="boton1"href="#" onclick="$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nro_doc=<?php echo $matriz_resultados['nro_doc']; ?>&num=<?php echo $matriz_resultados['movil']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);"><img src="IMG/user.png" width="16" height="16" /></a>

<?php echo strtoupper($texto_movil); ?>&nbsp;(<?php echo $matriz_resultados['hora'].' '.$matriz_resultados['dia']; ?>)
</div>

<div id="<?php echo $matriz_resultados['movil']; ?>" style="width:auto;">
<?php
$consultaX = "select color,correlativo, nro_doc, paciente from fichas where movil ='".$matriz_resultados['movil']."' and estado = 1";


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
<div style="color:<?php echo $color;?>"><?php echo htmlentities($matriz_resultadosX['paciente']); ?></div>
<?php
}
?>
</div>
&nbsp;<?php echo htmlentities($matriz_resultados['direccion']);?> 
<br />SECTOR <?php echo htmlentities($matriz_resultados['sector']); ?></td>
</tr>