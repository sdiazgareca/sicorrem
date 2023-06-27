

<?php
include('../../DAT/conf.php');
include('../../DAT/conf.php');
?>

<h1>EXPORTACION FLEXWIN PAGOS COBRANZA</h1>
<div class="caja">
<form action="BUSQ/M_BOL_FLEXWIN_COB.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Periodo Inicial </strong></td>
<td><input type="text" name="periodo_del" /></td>
<td><strong>Periodo Final </strong></td>
<td><input type="text" name="periodo_al" /></td>

<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>

<h1>EXPORTACION FLEXWIN VENTAS</h1>
<div class="caja">
<form action="BUSQ/M_BOL_FLEXWIN_VENT.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Periodo Inicial </strong></td>
<td><input type="text" name="periodo_del" /></td>
<td><strong>Periodo Final </strong></td>
<td><input type="text" name="periodo_al" /></td>

<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>



<h1>BOLETAS FACTURACION BIBLIA</h1>
<div class="caja">
<form action="BUSQ/M_BOL_EMI.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Periodo 01-02-2011</strong></td>
<td><input type="text" name="periodo" /></td>
<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>


<h1>BOLETAS FACTURACION (todos)</h1>
<div class="caja">
<form action="BUSQ/M_BOL_EMI2.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>DEL</strong></td>
<td><input type="text" name="del" /></td>
<td><strong>AL</strong></td>
<td><input type="text" name="al" /></td>
<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>




<h1>AFILIADOS DESC PLANILLA</h1>
<div class="caja">
<form action="BUSQ/M_BOL_DES.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Del</strong></td>
<td><input type="text" name="periodo1" /></td>
<td><strong>Al</strong></td>
<td><input type="text" name="periodo2" /></td>
<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>



<h1>BOLETAS VENTAS</h1>
<div class="caja">
<form action="BUSQ/M_BOL_VENT.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Del</strong></td>
<td><input type="text" name="periodo1" /></td>
<td><strong>Al</strong></td>
<td><input type="text" name="periodo2" /></td>
<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>



<h1>BOLETAS COPAGOS</h1>
<div class="caja">
<form action="BUSQ/M_BOL_COP.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;">
<table class="table2">
<tr>
<td><strong>Del</strong></td>
<td><input type="text" name="periodo1" /></td>
<td><strong>Al</strong></td>
<td><input type="text" name="periodo2" /></td>
<td><input type="submit" value="Crear" /></td>
</tr>
</table>
</form>
</div>

<div class="caja_cabezera">&nbsp;</div>
<div id="ajax4" class="caja">&nbsp;</div>
