<?php
include('../conf.php');
include('../bd.php');

$cod = $_GET['cod'];
if( (isset($_GET['codigo'])) && (isset($_GET['diagnostico'])) ){

if($cod != $_GET['codigo']){

$consulta1 = "select cod,diagnostico from diagnostico where cod ='".$_GET['codigo']."'";
$conn = mysql_query($consulta1);
$num = mysql_num_rows($conn);

if ($num > 0){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;El codigo ya existe</div></td></tr></table>';
exit;
}
}

$query ="update diagnostico set cod='".$_GET['codigo']."',diagnostico='".$_GET['diagnostico']."',estado='1' where cod='".$_GET['cod']."'";
$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
exit;
}
}

$query = "select cod, diagnostico, estado from diagnostico where cod = '".$cod."'";
$consu = mysql_query($query);
$matri = mysql_fetch_array($consu);
?>

<table class="celda1"  style="width:500px;">
<tr>
<td class="celda2">
<strong>C&oacute;digo&nbsp;</strong>&nbsp;<input type="text" name="codigo" id="codigo"  value="<?php echo $matri['cod']; ?>"/> 
<br /><br />
<strong>Diagnostico</strong> &nbsp; <input type="text" name="diagnostico" id="diagnostico" size="60" value="<?php echo $matri['diagnostico']; ?>">
<br /><br />
<br />

<div align="right">
  <input class="boton" type="button" value="Guardar" onclick="



if ( (!document.getElementById('codigo').value) || (!document.getElementById('diagnostico').value) ){
alert('Debe llenar todos los campos');
}
else{
$ajaxload('sintomas','Diagnostico/Form_editar.php?codigo='+document.getElementById('codigo').value+'&diagnostico='+document.getElementById('diagnostico').value+'&cod=<?php echo $_GET['cod']; ?>','<div =mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);
}
" />
</div></td>
</tr>
</table>
