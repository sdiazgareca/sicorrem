<script type="text/javascript">
$(document).ready(function() {

$('#form_secuencia').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#secuencia').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

$('#ajax3 a:contains("MODIFICAR")').click(function() {

	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
  
});

$('#ajax3 a:contains("ELIMINAR")').click(function() {

	 if(!confirm(" Esta seguro de eliminar el estado del Plan?")) {
		  return false;} 
	  else {
		var ruta = $(this).attr('href');	
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	}  
	});

$('a:contains("VER")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
?>

