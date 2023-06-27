<table>
<tr>
<td class="celda1">Personal</td>
</tr>
</table>


<table width="500px" align="center">
<tr>
<td class="celda3">
<a href="#" onclick="$ajaxload('bus','Amb/AgregarPersonal.php',false,true,true);">Agregar Personal</a>&nbsp;-&nbsp;<a href="#" onclick="$ajaxload('mensajemovil','PHP/main.php?ListaEdiatrPersonal=1',false,false,false);">Editar Personal</a>
</td>
</tr>
</table>


<div id="mensajemovil" style="overflow:auto; width:100%; height:auto">
<table width="500px" align="center">
<tr>
<td class="celda2">

<img src="IMG/user.png" alt="xxxxxxxx" width="16" height="16" />&nbsp;Registro&nbsp;
<input type="text" id="rut2" size="5" />
&nbsp;<img src="IMG/user.png" alt="dxxxxxxx" width="16" height="16" />&nbsp;Cargo&nbsp;
<select name="cargo" id="cargo">
<option value="">&nbsp;</option>
<?
include ('../conf.php');
include('../bd.php');
$consultad = "select cod, cargo from cargo";
$resultadosd = mysql_query($consultad);
while ($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<option value="<?php echo $matriz_resultados['cod'];?>"><?php echo $matriz_resultados['cargo'];?></option>
<?
}
mysql_close($conexion);
?>
</select>
&nbsp;
<img src="IMG/user.png" alt="dxxxxxxx" width="16" height="16" />&nbsp;RUT&nbsp;<input id="rut_1" type="text" size="8" maxlength="8" />&nbsp;-&nbsp;<input type="text" id="rut_d" size="1" maxlength="1" />

<br /><br />
<img src="IMG/user.png" width="16" height="16" />&nbsp;Primer Nombre
<input type="text" id="nombre1" size="15">  
<img src="IMG/user.png" alt="" width="16" height="16" />&nbsp;Segundo Nombre &nbsp;
<input type="text" id="nombre2" size="15">
<br /><br />
<img src="IMG/user.png" alt="" width="16" height="16" />&nbsp;Apellidos&nbsp;
<input type="text" id="apellidos" size="50">
<br /><br />
<div align="right">
  <input type="button" value="Guardar" class="boton" onclick="javascript:GuardarPersonal()" />
</div>
</p></td>
</tr>
</table>
</div>