<script type="text/javascript">
$(document).ready(function() {

$('#ajax3 a:contains("ELIMINAR")').click(function() {

 if(!confirm(" Esta seguro de eliminar el antecedente medico?")) {
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

$('#e_ante_med').submit(function(){

	 if(!confirm(" Esta seguro de eliminar el antecedente medico?")) {
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

/* INGRESO ANTECEDENTE MEDICO */
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

/* PROCESAR EDICION */

if ($_POST['ff_edicion'] > 0){
$sql = "UPDATE ate_medicos SET descripcion='".$_POST['descripcion']."' WHERE cod='".$_POST['ff_cod']."'";

	if ($query = mysql_query($sql)){
		echo OK;
	}
	
	else{
		echo ERROR;
	}
}


/* BUSQUEDA PREVISION DE SALUD */

if ( isset($_POST['ff_bus_ante_med']) ){

	$datos = new Datos;
	
	foreach($_POST as $campo => $valor){ 

		if (is_numeric($valor) && $campo != 'ff_bus_ante_med'){
			$condicion[$campo]=" = ".$valor;
		}
			
		else if ($campo != 'ff_bus_ante_med' && is_string($valor) && $valor != ""){
			$condicion[$campo]=" LIKE '".$valor."%'";
		}					
	}

	$campos = array("cod"=>"","descripcion"=>"");
	
	$get1 = array("cod"=>"");	
	$get1_var = array("EDITAR"=>'1');
	$get2_var = array("ELIMINAR"=>'1');	
	$rut = array("NULL"=>"");
	$datos->Listado_per($campos,"ate_medicos",$condicion,"EDITAR","ELIMINAR",$get1,$get1,"INT/M_ATME.php",$rut,$get1_var,$get2_var,"table2");
} 

/* EDITAR */

if ($_GET['EDITAR'] > 0){
?>

<form method="post" name="e_ante_med" id="e_ante_med" action="INT/M_ATME.php">
<input type="text" name="ff_edicion" style="display:none" value="1"/>

<input type="text" name="ff_cod" style="display:none" value="<?php echo $_GET['cod']; ?>" />

<?php
$query = "SELECT cod, descripcion FROM  ate_medicos WHERE cod ='".$_GET['cod']."'";
$sql = mysql_query($query);
$at = mysql_fetch_array($sql);
?>

<table style="width:auto;">
  <tr>
    <td>Editar Antecedente Medico</td>
    <td><input type="text" name="descripcion" size="90" value="<?php echo $at['descripcion']; ?>" /></td>
    <td><div class="caja_boton" align="right">
      <input type="submit" value="Guardar" class="boton">
    </div></td>
  </tr>
</table>
</div>
</form>
<?php	
}

/* ELIMINAR PREVISION DE SALUD */
if ( isset($_GET['ELIMINAR']) ){	
	$query = "DELETE FROM ate_medicos WHERE cod='".$_GET['cod']."'";	
	if (mysql_query($query)){
		echo OK;
	}
	else{
		echo ERROR;
	}
}

?>
