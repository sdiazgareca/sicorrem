$(document).ready(function() {

 	$('#ajax3 table tr td a').click(function() {
 		if(!confirm("Esta Seguro de Eliminar?")){ 
			return false;}
	
		else{
			var ruta = $(this).attr('href');
			$('#ajax3').load(ruta);	
			return false;}
	});
	
 	$('a').click(function() {
			var ruta = $(this).attr('href');
			$('#ajax3').load(ruta);	
			return false;

	});	

});



  