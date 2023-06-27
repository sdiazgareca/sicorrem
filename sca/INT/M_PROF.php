<script type="text/javascript">
$(document).ready(function() {

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


$('a:contains("EDITAR")').click(function() {
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

/* INGRESO ANTECEDENTE MEDICO */
/*
if ( ISSET($_POST['ff_ante_med']) ){
	$datos = new Datos;
	
	$datos->CompData('cod','ate_medicos');
	
	//$estado = array("f_ingreso"=>date('Y-m-d'));
	$cod = array("cod"=>$datos->num );
	
	$datos->INSERT_PoST('ate_medicos','',$cod,'');		
		
		if ( mysql_query($datos->query) ){
			echo OK;
		}
		else{
			echo ERROR;
		}
}
*/

/* BUSQUEDA PROFESION */
if ($_POST['ff_bus_PROF'] > 0){

	$datos = new Datos;
	
	foreach($_POST as $campo => $valor){ 

		if (is_numeric($valor) && $campo != 'ff_bus_PROF'){
			$condicion[$campo]=" = ".$valor;
		}
			
		else if ($campo != 'ff_bus_PROF' && is_string($valor) && $valor != ""){
			$condicion[$campo]=" LIKE '".$valor."%'";
		}					
	}

	$campos = array("codigo AS CODIGO"=>"","descripcion AS DESCRIPCION"=>"");
	
	$get1 = array("CODIGO"=>"");	
	$get1_var = array("EDITAR"=>'1');
	$get2_var = array("ELIMINAR"=>'1');	
	$rut = array("NULL"=>"");
	$datos->Listado_per($campos,"profesion",$condicion,"EDITAR","ELIMINAR",$get1,$get1,"INT/M_PROF.php",$rut,$get1_var,$get2_var,"table2");
} 

/* EDITAR */
if ( isset($_GET['EDITAR']) ){
	
	echo '=)';
	exit;
	
}

/* ELIMINAR PREVISION DE SALUD */
if ( isset($_GET['ELIMINAR']) ){
	echo ':))((:';
	}
?>
