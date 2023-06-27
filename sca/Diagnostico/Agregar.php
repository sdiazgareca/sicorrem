<?php
include('../conf.php');
include('../bd.php');

if( (isset($_GET['codigo'])) && (isset($_GET['diagnostico'])) ){

$query= "insert into diagnostico(cod,diagnostico) values ('".$_GET['codigo']."','".$_GET['diagnostico']."')";
$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
}
exit;
}

?>
<table class="celda1"  style="width:500px;">
<tr>
<td class="celda2">
<strong>C&oacute;digo&nbsp;</strong>&nbsp;<input type="text" name="codigo" id="codigo" /> 
<br /><br />
<strong>Diagnostico</strong> &nbsp; <input type="text" name="diagnostico" id="diagnostico" size="60">
<br /><br />
<br />

<div align="right">
  <input class="boton" type="button" value="Guardar" onclick="



if ( (!document.getElementById('codigo').value) || (!document.getElementById('diagnostico').value) ){
alert('Debe llenar todos los campos');
}
else{
$ajaxload('sintomas','Diagnostico/Agregar.php?codigo='+document.getElementById('codigo').value+'&diagnostico='+document.getElementById('diagnostico').value,'<div =mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);
}
" />
</div></td>
</tr>
</table>
