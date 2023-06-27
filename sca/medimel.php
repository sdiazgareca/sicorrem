<form method="get" action="RTF.php">
<table style="width:500px;">
<tr>
<td class="celda1">Medimel</td>
</tr>

<tr>
<td class="celda3">
Mes 
  <select id="mes" name="mes">
<option value="01">Enero</option>
<option value="02">Febrero</option>
<option value="03">Marzo</option>
<option value="04">Abril</option>
<option value="05">Mayo</option>
<option value="06">Junio</option>
<option value="07">Julio</option>
<option value="08">Agosto</option>
<option value="09">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>
</select>
A&ntilde;o&nbsp;
<select id="anio" name="anio">
<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
<option value="<?php echo (date('Y'))+1; ?>"><?php echo (date('Y'))+1; ?></option>
</select>
<div align="right"><input type="submit" class="boton" value="Generar"></div>
</td>
</tr>
</table>
</form>