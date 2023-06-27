<?php
include('../conf.php');
include('../bd.php');

if( (isset($_GET['traslado'])) ){


$new ="select desc_plan from planes_traslados";
$qur =mysql_query($new);
$nbd = mysql_num_rows($qur);
$nbd = $nbd + 1;

$consu = "select cod_plan from planes_traslados where tipo_plan ='6'";
$consul = mysql_query($consu);

$query ="insert into planes_traslados(tipo_plan,cod_plan,desc_plan) values ('6','PL".$nbd."','".$_GET['traslado']."')";
$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
}
exit;
}

?>



<table class="celda1"  style="width:500px;">
<tr>
<td class="celda2"><strong>Plan Traslado</strong> &nbsp; <input type="text" name="traslado" id="traslado">
<br /><br />
<div align="right">
  <input class="boton" type="button" value="Guardar" onclick="



if ( (!document.getElementById('traslado').value)){
alert('Debe llenar todos los campos');
}
else{
$ajaxload('sintomas','PLANES_TRASLADOS/AgregarPlan.php?traslado='+document.getElementById('traslado').value ,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);
}
" />
</div></td>
</tr>
</table>
