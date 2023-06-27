<table>
<tr>
<td class="celda1">Ambulancias</td>
</tr>
</table>

<table width="500px" align="center">
<tr>
<td class="celda3"><a href="#" onclick="$ajaxload('bus','Amb/AgregarAmbulancia.php',false,true,true);">Agregar Ambulancia</a>&nbsp;-&nbsp;<a href="#" onclick="$ajaxload('mensajemovil','PHP/main.php?ListaEdiatrMovil=1',false,false,false);">Editar Ambulancia</a></td>
</tr>
</table>

<div id="mensajemovil" style="overflow:auto; width:auto; height:auto">
<table width="500px" align="center">
<tr>
<td class="celda2">

<img src="IMG/car_add.png" alt="" width="16" height="16" /> Numero&nbsp;
<input type="text" id="num" size="3" />
<br/><br/>

<img src="IMG/car_add.png" width="16" height="16" />&nbsp;Marca&nbsp;
<input id="marca" type="text">
&nbsp;<img src="IMG/car_add.png" width="16" height="16" />&nbsp;Modelo&nbsp;<input type="text" id="modelo">

<br /><br />
<img src="IMG/car_add.png" alt="" width="16" height="16" />&nbsp;Chasis&nbsp;
<input id="chasis" type="text">

&nbsp;<img src="IMG/car_add.png" alt="" width="16" height="16" />&nbsp;Poliza de Seguro&nbsp;
<input type="text" id="p_seguro" size="12" >



<br /><br />
<img src="IMG/car_add.png" alt="" width="16" height="16" />&nbsp;Patente&nbsp;
<input type="text" id="patente1"  size="4" maxlength="2"> 
-&nbsp;
<input type="text" id="patente2"  size="4" maxlength="2"> 
-&nbsp;
<input type="text" id="patente3"  size="4" maxlength="2">

&nbsp;<img src="IMG/date.png" width="16" height="16" /> Año
&nbsp;
<select id="anio">
<?php
$anio = date(Y);
for ($i = 1980; $i <= $anio; $i ++){
?>
<option value="<?php echo $i;?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
<div align="right">
<input type="button" value="Guardar" class="boton" onclick="javascript:GuardarMovil();" /></div>

</td>
</tr>
</table>
</div>
