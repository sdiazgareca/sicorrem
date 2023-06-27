<table width="500px" align="center" class="celda1" style="background:#A6B7AF">
<tr>
<td><a href="#" onclick="$ajaxload('bus','Amb/AgregarPersonal.php',false,true,true);">Agregar</a>&nbsp;-&nbsp;<a href="#" onclick="$ajaxload('mensajemovil','PHP/main.php?ListaEdiatrMovil=1',false,false,false);">Editar</a></td>
</tr>
</table>
<div id="mensajemovil" style="overflow:auto; width:auto; height:200px">
<table width="500px" align="center">
<tr>
<td class="celda2">
<p>Primer Nombre 
  <input type="text" id="nombre1">
&nbsp;Segundo Nombre &nbsp;
<input type="text" id="nombre2">
&nbsp;Apellidos&nbsp;
<input type="text" id="apellidos">
</p>
<p>
Rut&nbsp;<input type="text" id="rut2">&nbsp;Cargo
&nbsp;
<select id="cargo">
<option value="0"></option> 
<option value="1">Medico</option>
<option value="2">Paramedico</option>
<option value="3">Conductor</option>
</select>
<br>
<div align="right">
<input type="button" value="Guardar" class="boton" onclick="javascript:GuardarPersonal()" /></div>
</p>
</td>
</tr>
</table>
</div>