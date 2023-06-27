<table style="width:500px;">
<tr>
<td class="celda1" style="color:#FFFFFF">Traslados</td>
</tr>
</table>

<table style="width:500px;">
<tr>
<td class="celda3">
Tipo de Traslado&nbsp;
<select>
<option value="1" onclick="$ajaxload('traslado_s','Traslados/Tras_MedicalizadoConvenio.php',false,false,false);">Traslado Medicalizado Convenio</option>

<option value="2" onclick="$ajaxload('traslado_s','Traslados/Tras_simpleConvenio.php',false,false,false);">Traslado Simple Convenio</option>

<option value="3" onclick="$ajaxload('traslado_s','Traslados/Tras_Prog_Afil_Dire.php',false,false,false);">Traslado Programados Afiliados Directos</option>
<option value="4">Traslado Simple de Particulares</option>
</select>
&nbsp;
<a href="#" onclick="$ajaxload('traslado_s','Traslados/Listado_traslados.php',false,false,false);">Traslados</a>
<div id="traslado_s"></div>
</td>
</tr>
</table>