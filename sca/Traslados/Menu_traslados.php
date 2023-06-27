

<table style="width:500px;">
<tr>
<td class="celda1" style="color:#FFFFFF">Traslados</td>
</tr>
</table>

<table style="width:500px;">
<tr>
<td class="celda3">
Tipo de Traslado&nbsp;
<select name="select">
  <option value="1" onclick="$ajaxload('traslado_s','Traslados/Tras_MedicalizadoConvenio.php',false,false,false);">Traslado Medicalizado Convenio</option>
  <option value="2" onclick="$ajaxload('traslado_s','Traslados/Tras_simpleConvenio.php',false,false,false);">Traslado Simple Convenio</option>
  <option value="3" onclick="$ajaxload('traslado_s','Traslados/Tras_Prog_Afil_Dire.php',false,false,false);">Traslado Programados Afiliados Directos</option>
  <option value="4" onclick="$ajaxload('traslado_s','Traslados/Tras_Simple_Par.php',false,false,false);">Traslado Simple de Particulares</option>
</select>
&nbsp;
<input value="Traslados" type="submit" class="boton" onclick="$ajaxload('traslado_s','Traslados/Listado_traslados.php?operador=<?php echo $_GET['operador']; ?>',false,false,false);" />
<div id="traslado_s"></div></td>
</tr>
</table>
