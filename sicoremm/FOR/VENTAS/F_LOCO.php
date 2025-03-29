<script type="text/javascript">
$(document).ready(function() {

$('#ajax4 a').click(function() {
						  
 	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
 });

$('form').submit(function(){
 	
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


if ( isset($_POST['codigo'])){
	$f_pago_sql ="UPDATE sicoremm2.f_pago SET locomocion='".$_POST['locomocion']."' WHERE `codigo`='".$_POST['codigo']."'";

	$f_pago_query = mysql_query($f_pago_sql);
}

$f_pago_sql ="SELECT codigo,descripcion,comi_free,locomocion FROM f_pago WHERE codigo != 10 and codigo !=20";
$f_pago_query = mysql_query($f_pago_sql);

echo '<h1>Tabla de Locomocion </h1>';

$i = 1;

while ($f_pago = mysql_fetch_array($f_pago_query)){
		  
		  ?>
		  <form action="FOR/VENTAS/F_LOCO.php" method="post" name="<? echo 'na_'.$i; ?>" id="<? echo 'id_'.$i; ?>">
          <table style="width:500px" class="table">
          <tr>
		  <td style="display:none;"><input type="text"  value="<?php echo $f_pago['codigo']; ?>" name="codigo" readonly="readonly" id="<? echo 'name_'.$i; ?>" ></td>
		  
		  <td style="width:400px"><strong><?php echo $f_pago['descripcion']; ?></strong></td>
 		  <td><input type="text" size="5" maxlength="5" value="<?php echo $f_pago['locomocion']; ?>" name="locomocion"></td>  
		  <td><input type="submit" value="Guardar" class="boton"></td>
          </tr>
          </table>
          </form>
		  <?php
          $i ++;
		  }
?>
