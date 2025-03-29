<script type="text/javascript">
$(document).ready(function() {

$('#ajax #F_AUDI').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#ajax3').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

 $('#ajax1 a').click(function() {

	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>GESTI&Oacute;N EMPRESAS</h1>

<div class="caja_cabezera">EMPRESAS</div>
<form action="BUSQ/M_BUSQ_CONV.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_folio_bus" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>

<td>
    
    <strong>NOMBRE</strong>

    <?php

    $sql ="SELECT empresa.empresa, empresa.nro_doc FROM empresa ORDER BY empresa";
    $query = mysql_query($sql);
    ?>
    &zwj;
    <select name="empresa">

    <?php

    while ($empresa = mysql_fetch_array($query)){
    ?>
        <option value="<?php echo $empresa['nro_doc']; ?>"><?php echo $empresa['empresa']; ?></option>
    <?php
    }
    ?>
    </select>

    &zwj;<strong>TIPO</strong>
       <select name="TIPO">
        <option value="NOMI">Nomnina</option>
        <option value="ATEN">Atenciones</option>
    </select>

</td>





<td><div align="right"><input type="submit" value="Buscar" class="boton" /></div></td>
</tr>
</table>

</div>

</form>


































<h1>NOMINA DE CONVENIOS</h1>

<div class="caja_cabezera">EMPRESAS</div>
<form action="DOC/Nomina_convenios.php" method="post" name="F_AUDI">
<input type="text" name="ff_folio_bus" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>

<td><strong>NOMBRE</strong></td>
<td>
    <?php

    $sql ="SELECT empresa.empresa, empresa.nro_doc FROM empresa ORDER BY empresa";
    $query = mysql_query($sql);
    ?>
    &zwj;
    <select name="empresa">

    <?php

    while ($empresa = mysql_fetch_array($query)){
    ?>
        <option value="<?php echo $empresa['nro_doc']; ?>"><?php echo $empresa['empresa']; ?></option>
    <?php
    }
    ?>
    </select>


</td>
<td><strong>PERIODO</strong></td>
<td><input type="text" class="calendario" name="periodo" /></td>

<td><strong>COPAGOS</strong></td>
<td>
<strong>Del</strong> <input type="text" class="calendario" name="del" />
<strong>Al</strong> <input type="text" class="calendario" name="al" /></td>





<td><div align="right"><input type="submit" value="Buscar" class="boton" /></div></td>
</tr>
</table>

</div>

</form>































<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>