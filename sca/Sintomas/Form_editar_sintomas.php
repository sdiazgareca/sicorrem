<?php
include('../conf.php');
include('../bd.php');


$cod = $_GET['cod'];

if( (isset($cod)) && (isset($_GET['sintoma'])) && (isset($_GET['preguntasclave'])) && (isset($_GET['rojo'])) && (isset($_GET['amarillo'])) && (isset($_GET['verde'])) && (isset($_GET['causas'])) && (isset($_GET['observaciones'])) ){

$query = "update sintomas set  cod='".htmlentities($cod)."',sintoma='".htmlentities($_GET['sintoma'])."',PreguntasClave='".htmlentities($_GET['preguntasclave'])."',rojo='".htmlentities($_GET['rojo'])."',amarillo='".htmlentities($_GET['amarillo'])."',verde='".htmlentities($_GET['verde'])."',causas='".htmlentities($_GET['causas'])."',observaciones='".htmlentities($_GET['observaciones'])."' where cod='".$cod."'";
$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
}
exit;
}


$query = "select * from sintomas where cod = '".$cod."'";
$consu = mysql_query($query);
$matri = mysql_fetch_array($consu);
?>

<table class="celda1" style="width:500px;">
<tr>
<td class="celda2"><strong>Sintoma</strong> &nbsp; <input name="sintoma" type="text" id="sintoma" value="<?php echo htmlentities($matri['sintoma']); ?>" size="40">
<br /><br />

<strong>Preguntas Claves&nbsp;</strong><br />
<textarea name="preguntasclave" cols="50" id="preguntasclave"><?php echo htmlentities($matri['PreguntasClave']); ?></textarea>

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
<textarea name="causas" cols="50" id="causas"><?php echo htmlentities($matri['causas']); ?></textarea>
<br /><br />

<strong>Observaciones</strong>&nbsp; 
<br />
<textarea name="observaciones" cols="50" id="observaciones"><?php echo htmlentities($matri['observaciones']); ?></textarea>
<br /><br />

<div align="right"><input class="boton" type="button" value="Guardar" onclick="

$ajaxload('sintomas','Sintomas/Form_editar_sintomas.php?cod=<?php echo $matri['cod'];?>&sintoma='+document.getElementById('sintoma').value+'&preguntasclave='+document.getElementById('preguntasclave').value+'&rojo='+document.getElementById('rojo').value+'&amarillo='+document.getElementById('amariillo').value+'&verde='+document.getElementById('verde').value+'&causas='+document.getElementById('causas').value+'&observaciones='+document.getElementById('observaciones').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);"></div></td>
</tr>
</table>