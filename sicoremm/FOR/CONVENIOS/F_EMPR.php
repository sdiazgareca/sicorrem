<script type="text/javascript">
jQuery.validator.setDefaults({
	debug: true,
	success: "valid"
});;
</script>


<script type="text/javascript">
$(document).ready(function() {

	$('.rut').Rut({
		  on_error: function(){ alert('Rut incorrecto'); }
		});


	$('#ajax3 #ingVenCon').submit(function(){

 		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();
		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
			$('#ajax3').html(data);}})
			url_ajax ="";
			data_ajax="";
			return false;});
});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
<h1>INGRESO DE EMPRESAS</h1>

<form action="INT/M_CONV.php" method="post" id="ingVenCon" name="ingVenCon" >
<input type="text" name="ff_folio_int" value="1" style="display:none;" />
<div class="caja_cabezera">

Descrici&oacute;n de la Empresa</div>

<div class="caja">
 <table>
 <tr>
<td><strong>RUT</strong>&nbsp;&nbsp;<input type="text" name="nro_doc" class="rut" /></td>
<td>
 <strong>Facturaci&oacute;n</strong>

<?php
$fact = new Select;
$fact->selectSimple('f_factu','breve,codigo','breve','codigo','f_factu','f_factu','NULL');
?>
</td>

<td><strong>Giro</strong>
<?php
$giro = new Select;
$giro->selectSimple('giro','desc,codigo','desc','codigo','giro','giro','NULL');
?>
</td>

</tr>

<tr>
<td><strong>Contacto</strong>&nbsp;&nbsp;<input type="text" name="contacto" /></td>
<td>
Fono&nbsp;&nbsp;<input name="fono" type="text" maxlength="6"/>
<strong></strong>
</td>

<td>
Email
<input type="text" name="email" class="required email" id="email" size="10" />
<strong>Celular</strong>&nbsp;&nbsp;<input type="text" name="celular"size="10">
</td>

</tr>

<tr>

<td>
ZO - SE - MA
<select name="ff_ZOSEMA">
<?php
$sql = "SELECT ZO,SE,MA,ZOSEMA.descripcion FROM ZOSEMA WHERE ZOSEMA.estado=1";

$sql_query = mysql_query($sql);
while($zosema = mysql_fetch_array($sql_query)){
?>
<option value="<?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA']; ?>"><?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA'].'&nbsp;&nbsp;&nbsp;'.$zosema['descripcion']; ?></option>
<?php
}
?>
</select>
</td>


<td><strong for="ContactName">Empresa</strong>&nbsp;&nbsp;<input type="text" name="empresa" /></td>
<td><strong for="ContactName">Dia de pago</strong>&nbsp;&nbsp;
    <select name="d_pago" >
        <option value="1">1</option>
        <option value="5">5</option>
        <option value="10">10</option>
    </select>
</td>
</tr>
<tr>
<td><strong for="ContactName">Copago</strong>&nbsp;&nbsp;
    <select name="copago" >
        <option value="">&zwnj;</option>
        <?php
        $sql="SELECT cod, copago_emp FROM empresa_copago";
        $query = mysql_query($sql);
        while($cop = mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $cop['cod'];?>"><?php echo $cop['copago_emp'];?></option>
        <?php
        }
        ?>
    </select>
</td>

</tr>
</table>

</div>

<div class="caja_boton"><input type="submit" value="Guardar" class="boton"></div>
</form>
</div>
