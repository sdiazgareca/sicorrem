<?php
switch($matriz_resultados['cod_color']){

case '1':
$clave = '#FFE8E8';
$fondo = '#FFE8E8';
break;

case '2':
$clave = '#FFFFE0';
$fondo ='#FFFFE0';
break;

case '3':
$clave = '#C0FFC0';
$fondo ='#C0FFC0';
break;

case '4':
$clave = '#C0C0FF';
$fondo ='#C0C0FF';
break;
}

if($matriz_resultados['movil'] < 10000){
$texto_movil = '<img src="IMG/car.png" width="16" height="16" /> Movil '.$matriz_resultados['movil'];
}
else{
$texto_movil = '<img src="IMG/telephone.png" width="16" height="16" /> LLAMADA EN ESPERA';
}

?>

<tr>
<td  style="border: <?php echo $clave; ?> solid 2px; background-color: <?php echo $fondo; ?>; font-size:11px;"  class="celda3">
<?php echo strtoupper($texto_movil); ?>
<br />
<img src="IMG/user.png" width="16" height="16" /> 
<a style="color:#006699;" href="#" onclick="$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nro_doc=<?php echo $matriz_resultados['nro_doc']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);">
<?php echo strtoupper($matriz_resultados['paciente']); ?></a>
<br />
<img src="IMG/time.png" width="16" height="16" /> <?php echo $matriz_resultados['hora'].' '.$matriz_resultados['dia']; ?>
<br />
<img src="IMG/house.png" width="16" height="16" /> <?php echo strtoupper($matriz_resultados['direccion']);?> 
<br />
<img src="IMG/house.png" width="16" height="16" /> SECTOR <?php echo strtoupper($matriz_resultados['sector']); ?>
</td>
</tr>
