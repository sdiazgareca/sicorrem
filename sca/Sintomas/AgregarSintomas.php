<?php
include('../conf.php');
include('../bd.php');

if( (isset($_GET['sintoma'])) && (isset($_GET['preguntasclave'])) && (isset($_GET['rojo'])) && (isset($_GET['amarillo'])) && (isset($_GET['verde'])) && (isset($_GET['causas'])) && (isset($_GET['observaciones'])) ){


$query ="insert into sintomas(sintoma,PreguntasClave,rojo,amarillo,verde,causas,observaciones,estado) values ('".htmlentities($_GET['sintoma'])."','".htmlentities($_GET['preguntasclave'])."','".htmlentities($_GET['rojo'])."','".htmlentities($_GET['amarillo'])."','".htmlentities($_GET['verde'])."','".htmlentities($_GET['causas'])."','".htmlentities($_GET['observaciones'])."','1')";

$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
}
exit;
}

?>



<table class="celda1"  style="width:500px;">
<tr>
<td class="celda2"><strong>Sintoma</strong> &nbsp; <input type="text" name="sintoma" id="sintoma">
<br /><br />

<strong>Preguntas Claves&nbsp;</strong><br />
<textarea name="preguntasclave" cols="50" id="preguntasclave"></textarea>

<br /><br />

<table style="width:480px;">
<tr>
<td><strong>Rojo</strong></td>
<td><strong>Amarillo</strong></td>
<td><strong>Verde</strong></td>
</tr>

<tr>
<td><textarea name="rojo" cols="20" id="rojo"><?php echo htmlentities($matri['rojo']); ?></textarea></td>
<td><textarea name="amariillo" cols="20" id="amariillo"><?php echo htmlentities($matri['amarillo']); ?></textarea></td>
<td><textarea name="verde" cols="20" id="verde"><?php echo htmlentities($matri['verde']); ?></textarea></td>
</tr>
</table>

<br /><br />
<strong>Causas</strong>&nbsp; 
<br />
<textarea name="causas" cols="50" id="causas"></textarea>
<br /><br />

<strong>Observaciones</strong>&nbsp; 
<br />
<textarea name="observaciones" cols="50" id="observaciones"></textarea>
<br /><br />

<div align="right">
  <input class="boton" type="button" value="Guardar" onclick="



if ( (!document.getElementById('sintoma').value) || (!document.getElementById('preguntasclave').value) || (!document.getElementById('rojo').value) || (!document.getElementById('amariillo').value) || (!document.getElementById('verde').value) || (!document.getElementById('causas').value) || (!document.getElementById('observaciones').value) ){
alert('Debe llenar todos los campos');
}
else{
$ajaxload('sintomas','Sintomas/AgregarSintomas.php?sintoma='+document.getElementById('sintoma').value+'&preguntasclave='+document.getElementById('preguntasclave').value+'&rojo='+document.getElementById('rojo').value+'&amarillo='+document.getElementById('amariillo').value+'&verde='+document.getElementById('verde').value+'&causas='+document.getElementById('causas').value+'&observaciones='+document.getElementById('observaciones').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);
}
" />
</div></td>
</tr>
</table>
