$(document).ready(function() {
 
 $('#tabs1 a').click(function() {
					  
 	var ruta = $(this).attr('href');	
 	$('#ajax').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });

 $('#cargando_imagen').ajaxStart(function() {									  
	$(this).show();
 	}).ajaxStop(function() {
 	$(this).hide();
 });
 
 /*
 $(function() {
		   $(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });
});
 */

});