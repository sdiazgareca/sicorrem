<script type="text/javascript">
$(document).ready(function() {


$('#_ipc').submit(function(){
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

});


</script>
<form method="post" name="_ipc" id="_ipc" action="INT/M_IPC.php">

<input type="text" name="ff_ing_ipc" value="1" id="ff_ing_ipc" style="display:none"/>

<table style="width:auto;">
  <tr>
    <td><strong>PORCENTAJE</strong></td>
    <td><input type="text" name="ipc" size="6" maxlength="6" /></td>
    <td><strong>Mes</strong></td>
    <td>
    <select name="MES">
    <option value=""></option>
    	<?php
    	 for ($i =1; $i < 13; $i ++){
    		echo '<option value="'.$i.'">'.$i.'</option>';
    	 }
    	?>
    </select>
    </td>
       
    <td><strong>A&ntilde;o</strong></td>
    <td><input type="text" name="ANIO" size="5" maxlength="4" value=<?php echo date('Y');?> /></td>
    
    <td><div class="caja_boton" align="right">
    
    <input type="submit" value="Guardar" class="boton">
   	</div>
    
    </td>
  </tr>
</table>
</div>
</form>