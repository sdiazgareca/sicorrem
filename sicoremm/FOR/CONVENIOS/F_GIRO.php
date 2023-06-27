<script type="text/javascript">
$(document).ready(function() {


$('#_ante_med').submit(function(){
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

});


</script>
<form method="post" name="_ante_med" id="_ante_med" action="INT/M_GIRO.php">
<input type="text" name="ff_ante_med" style="display:none" />
<table style="width:auto;">
  <tr>
    <td>Descripcion Giro</td>
    <td><input type="text" name="desc" size="90" /></td>
    <td><div class="caja_boton" align="right">
      <input type="submit" value="Guardar" class="boton">
    </div></td>
  </tr>
</table>
</div>
</form>