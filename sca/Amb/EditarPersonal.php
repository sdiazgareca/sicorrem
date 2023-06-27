<table width="500px" align="center">
<tr>
<td class="celda2">
Primer Nombre&nbsp;<input type="text" id="nombre1" value="<? echo $matriz_resultados['nombre1']; ?>">
&nbsp;
<img src="IMG/user.png" alt="dxxxxxxx" width="16" height="16" />&nbsp;RUT&nbsp;<input id="rut_1" type="text" size="8" maxlength="8" value="<? echo $matriz_resultados['rut_1']; ?>" />&nbsp;-&nbsp;<input type="text" id="rut_d" size="1" maxlength="1" value="<? echo $matriz_resultados['rut_d']; ?>" />

<br /><br />

Segundo Nombre &nbsp;
<input type="text" id="nombre2"  value="<? echo $matriz_resultados['nombre2']; ?>">
&nbsp;Apellidos&nbsp;
<input type="text" id="apellidos"  value="<? echo $matriz_resultados['apellidos']; ?>">
<br /><br />
Registro&nbsp;
<input type="text" id="rut2"  value="<? echo $matriz_resultados['rut']; ?>">&nbsp;Cargo
&nbsp;
<select id="cargo">
<option value="<?php echo $matriz_resultados['ccargo']; ?> "><?php echo $matriz_resultados['ncargo']; ?></option>
<?
include ('../conf.php');
include('../bd.php');
$consultad = "select cod, cargo from cargo";
$resultadosd = mysql_query($consultad);

while ($matriz_resultados2 = mysql_fetch_array($resultadosd)){

?>
<option value="<?php echo $matriz_resultados2['cod'];?>"><?php echo $matriz_resultados2['cargo'];?></option> 
<?
}
mysql_close($conexion);
?>
</select>
<br /><br />
<div align="right">
<input type="button" value="Guardar" class="boton" onclick="javascript:EditarPersonal()" /></div>
</td>
</tr>
</table>