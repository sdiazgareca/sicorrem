<?php
include('../conf.php');
include('../bd.php');

if ( (isset($_GET['rut'])) && (isset($_GET['clave'])) && (isset($_GET['nombre1'])) && (isset($_GET['nombre2'])) && (isset($_GET['apellido'])) && (isset($_GET['privilegio'])) ){

$consulta2 ="select rut from operador where rut = '".$_GET['rut']."'";
$resultados2 = mysql_query($consulta2);
$nfilas = mysql_num_rows ($resultados2);

if ($nfilas > 0){
echo '
<table style="width:500px;"><tr><td class="celda3">
<div class="mensaje"><img src="IMG/error.png" />&nbsp;El nombre de usuario ya existe.</div>
</td></tr></table>';
exit;
}
else{
$query="insert into operador(rut,clave,nombre1,nombre2,apellido,estado,privilegio) values('".$_GET['rut']."','".$_GET['clave']."','".$_GET['nombre1']."','".$_GET['nombre2']."','".$_GET['apellido']."','1','".$_GET['privilegio']."')";
$resultados = mysql_query($query);
if($resultados){
echo '<table style="width:500px;"><tr><td class="celda3">
<div class="mensaje"><img src="IMG/tick.png" />&nbsp;Usuario creado con exito.</div>
</td></tr></table>';
}
}
}

else{ 
?>

<table style="width:500px;">
<tr>
<td class="celda3">
Numero de Registro&nbsp;
<input type="text" id="rut" name="rut" maxlength="20">
Password&nbsp;
<input type="password" id="clave" name="clave" maxlength="6" size="7"><br /><br />
Primer Nombre&nbsp;<input type="text" id="nombre1" name="nombre1" size="60"><br /><br />
Segundo Nombre&nbsp;<input type="text" id="nombre2" name="nombre2" size="58"><br /><br />
Apellidos&nbsp;<input type="text" id="apellido" name="apellido" size="66"><br /><br />

Privilegio&nbsp;<select id="privilegio" name="privilegio">
<?php
$query='select cod, privilegio from operador_privilegio';
$resultados = mysql_query($query);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['privilegio']; ?></option>
<?php
}
?>
</select>
<div align="right"><input type="button" value="Guardar" class="boton" onClick="
var rut = document.getElementById('rut').value;
var clave = document.getElementById('clave').value;
var nombre1 = document.getElementById('nombre1').value;
var nombre2 = document.getElementById('nombre2').value;
var apellido = document.getElementById('apellido').value;
var privilegio = document.getElementById('privilegio').value;

if ((!rut) || (!clave) || (!nombre1) || (!nombre2) || (!apellido) || (!privilegio) ) {
alert('Debe llenar todos los campos');
}
else{

if(confirm('Esta seguro de guardar el usuario?')) {

$ajaxload('operadores', 'Operador/Agregar_operador.php?rut='+rut+'&clave='+clave+'&nombre1='+nombre1+'&nombre2='+nombre2+'&apellido='+apellido+'&privilegio='+privilegio,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);
}
}">
</div>



</td>
</tr>
</table>
<?php
}
mysql_close($conexion);
?>