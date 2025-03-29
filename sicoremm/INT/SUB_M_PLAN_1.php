<script type="text/javascript">
$(document).ready(function() {
$('#ajax3 a:contains("MODIFICAR")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#secuencia').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
  
});

$('#ajax3 a:contains("ELIMINAR")').click(function() {

	 if(!confirm(" Esta seguro de eliminar el estado del Plan?")) {
		  return false;} 
	  else {
		var ruta = $(this).attr('href');	
	 	$('#secuencia').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	}  
	});

$('#form_sec').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#secuencia').html(data);}}) 
	
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


if (isset($_POST['EDITAR'])){
	$query = "UPDATE valor_plan SET valor='".$_POST['valor']."' WHERE secuencia='".$_POST['secuencia']."' AND cod_plan='".$_POST['cod_plan']."' AND tipo_plan='".$_POST['tipo_plan']."'";
	$con = mysql_query($query);
}


if ($_GET['ELIMINAR'] > 0){
	$sql = "DELETE FROM valor_plan WHERE secuencia= '".$_GET['SECUENCIA']."' AND cod_plan = '".$_GET['COD']."' AND tipo_plan = '".$_GET['CAT']."'";
	$query = mysql_query($sql);
	
	$_POST['secuencia'] = $_GET['SECUENCIA'];
	$_POST['cod_plan'] = $_GET['COD'];
	$_POST['tipo_plan'] = $_GET['CAT'];
	
}

if( (isset($_POST['secuencia'])) && ($_GET['ELIMINAR'] < 1) && ($_GET['MODIFICAR'] < 1) && ($_POST['EDITAR'] < 1) ){
	
	$datos = new Datos;
	
	/* OPTIMIZA CON USO SE ARREGLOS */
	
	//comprobar secuencia
	$secuencia_ant_s ="SELECT secuencia,valor FROM valor_plan WHERE cod_plan ='".$_POST['cod_plan']."' AND tipo_plan ='".$_POST['tipo_plan']."' AND secuencia = (".$_POST['secuencia']." - 1)";
	$secuencia_ant_q = mysql_query($secuencia_ant_s);
	$secuencia_ant = mysql_fetch_array($secuencia_ant_q);
	
	//comprobar si existen secuencias
	$contador = new Datos;
	$campos = array("cod_plan"=>$_POST['cod_plan'],"tipo_plan"=>$_POST['tipo_plan']);
	$num = $contador->ComDataUni($campos,'valor_plan');
	
	//si exsiten secuencias
	if ($num > 0 && ($_POST['valor'] >= ($secuencia_ant['valor']))){
		$datos->INSERT_PoST('valor_plan','','',$_POST['cod_plan']);
			if (mysql_query($datos->query)){
				echo "";
			}
			else{
				echo ERROR;
	 		}	
	}
		
	//comprobar el valor si no existe secuenia se ingresa	
	if (!$secuencia_ant['valor'] && $num < 1){
		$datos->INSERT_PoST('valor_plan','','',$_POST['cod_plan']);
			if (mysql_query($datos->query)){
				echo "";
			}
			else{
				echo ERROR;
			}
		}
}		

if ( $_GET['MODIFICAR'] < 1){

$datos = new Datos;

$campos = array("secuencia AS SECUENCIA"=>"","valor AS VALOR"=>"","cod_plan AS COD"=>"","tipo_plan AS CAT"=>"");	
$eliminar = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");
$ver = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");	
$rut = array("NULL"=>"");
$var_ver = array("MODIFICAR"=>'1');
$var_eli = array("ELIMINAR"=>'1');	
$condicion = array("cod_plan = '"=>$_POST['cod_plan']."'","tipo_plan = '"=>$_POST['tipo_plan']."'");
$datos->Listado_per($campos,'valor_plan',$condicion,'MODIFICAR','ELIMINAR',$ver,$eliminar,'INT/SUB_M_PLAN_1.php',$rut,$var_ver,$var_eli,'table2');
}

if ($_GET['MODIFICAR'] > 0){

	echo '<form action="INT/SUB_M_PLAN_1.php" method="post" id="form_sec" name="form_sec">';
	echo '<table><tr><td>
		
		<div class="caja">
		
		<table>
		
		<tr>
		<td style="display:none;"><input type="text" name="EDITAR" value="1" /></td>
		<td><strong>SECUENCIA</strong>&nbsp;<input type="text" name="secuencia" size="5" maxlength="2" value="'.$_GET['SECUENCIA'].'" readonly="readonly" /></td>
		<td><strong>VALOR</strong>&nbsp;<input type="text" name="valor" size="8" maxlength="8" value="'.$_GET['VALOR'].'" /></td>
		<td><strong>COD_PLAN</strong>&nbsp;<input type="text" name="cod_plan" size="8" maxlength="3" readonly="readonly" value="'.$_GET['COD'].'" /></td>
		<td><strong>TIPO_PLAN</strong>&nbsp;<input type="text" name="tipo_plan" size="8" maxlength="8" readonly="readonly" value="'.$_GET['CAT'].'" /></td>
		<td>&nbsp;</td><td><input type="submit" value="Cambiar" /></td>
		</tr>
		
		</table>
		
		</div>
		</form>';
}

?>