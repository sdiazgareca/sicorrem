
<script type="text/javascript">
$(document).ready(function() {
$('#ajax4 a:contains("ELIMINAR")').click(function() {

if(!confirm("Esta seguro eliminar?")) {
	return false;} 

	var ruta = $(this).attr('href');	
 	$('#ajax4').load(ruta);
	$.ajax({cache: false});
	ruta = "";
	var ruta ="";
 	return false;
	});
});
</script>


<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
$datos = new Datos;


if ( isset($_GET['ELIMINAR']) ){
	
	$query = "DELETE FROM comi_contr WHERE codigo='".$_GET['COD']."'";
	
	if (mysql_query($query)){
		echo OK;
	}
	else{
		echo ERROR;
	}

}

if ( isset($_POST['ff_comi']) ){
	
	$sql = "SELECT codigo,de,a,porcentaje FROM comi_contr";
	$query = mysql_query($sql);
	
	$codigo = new Datos;
	$codigo->CompData("codigo","comi_contr");
	
	if( $_POST['de'] == $_POST['a']){
		echo ERROR;
		exit;
	}
	
	while ($dato = mysql_fetch_assoc($query) ){
		foreach($dato as $indice => $valor) {
			
			if ($indice == 'de' && $valor >= $_POST['de'] ){
				echo ERROR;
				exit;
			}
			
			if ($indice == 'a' && $valor > $_POST['a'] ){
				echo ERROR;
				exit;
			}
			
		}
	}
	
	$datos = new Datos;
	$condicion ="";
	$agg = "";
	$otr = array("codigo"=>$codigo->num);
	$datos->INSERT_PoST("comi_contr",$condicion,$agg,$otr);
	
	echo $datos->query;
	
	if (mysql_query($datos->query) ){
		echo OK;
	}
	else{
		echo ERROR;
	}
}

$campos = array("codigo AS COD"=>"","de AS DE"=>"","a AS A"=>"","porcentaje AS PORCENTAJE"=>"");

$get1 = array("COD"=>"");

$rut = array("NULL"=>"");

$get1_var = array("ELIMINAR"=>"1");

$datos->Listado_per($campos,"comi_contr","","","ELIMINAR",$get1,$get1,"INT/M_CCON.php",$rut,$get1_var,$get1_var,"table2");

?>