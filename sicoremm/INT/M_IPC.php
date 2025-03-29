<script type="text/javascript">

$(document).ready(function() {

$('#ajax3 a:contains("ELIMINAR")').click(function() {

if(!confirm(" Esta seguro de eliminar el registro?")) {
	  return false;} 
  else {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
}  
});

$('a:contains("EDITAR")').click(function() {

	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});

$('#e_giro').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;} 
	
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

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


/* INGRESO IPC */
if ($_POST['ff_ing_ipc'] > 0){
	
	if ($_POST['MES'] > 0 && $_POST['ANIO'] > 2009){

		$query ="INSERT INTO IPC (ipc,ANIO,MES ) VALUES ('".$_POST['ipc']."','".$_POST['ANIO']."','".$_POST['MES']."')";
	
			if ( mysql_query($query) ){
				echo OK;
			}
			else{
				echo ERROR;
			}		
	}
	else{
		echo ERROR;
	}
}

/* PROCESAR EDICION */
if ($_POST['ff_edicion'] > 0){
$sql = "UPDATE `giro` SET `desc`='".$_POST['descripcion']."' WHERE codigo='".$_POST['ff_cod']."'";
	
	if ($query = mysql_query($sql)){
		echo OK;
	}
	
	else{
		echo ERROR;
	}
}


/* BUSQUEDA IPC */

if ( isset($_POST['ff_ipc']) ){

	$datos = new Datos;
	
	foreach($_POST as $campo => $valor){ 

		if (is_numeric($valor) && $campo != 'ff_ipc'){
			$condicion[$campo]=" = ".$valor;
		}
			
		else if ($campo != 'ff_ipc' && is_string($valor) && $valor != ""){
			$condicion[$campo]=" LIKE '".$valor."%'";
		}					
	}

	$campos = array("IPC"=>"","ANIO"=>"","MES"=>"");
	
	$get1 = array("ANIO"=>"","MES"=>"");	
	$get1_var = array("E"=>'1');
	$get2_var = array("ELIMINAR"=>'1');	
	$rut = array("NULL"=>"");
	$datos->Listado_per($campos,"IPC",$condicion,"","ELIMINAR",$get1,$get1,"INT/M_IPC.php",$rut,$get1_var,$get2_var,"table2");
} 

/* ELIMINAR IPC */
if ( isset($_GET['ELIMINAR']) ){	
	$query = "DELETE FROM IPC WHERE ANIO='".$_GET['ANIO']."' AND MES='".$_GET['MES']."'";	
	if (mysql_query($query)){
		echo OK;
	}
	
	else{
		echo ERROR;
	}
}
?>