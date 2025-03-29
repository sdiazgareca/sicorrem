
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
	
	$query = "DELETE FROM bonos_contr WHERE codigo='".$_GET['COD']."'";
	$query2 = mysql_query($query);
}

if ($_POST['ff_bono'] > 0 &&  $_POST['monto'] > 100){
	

$sql ="INSERT INTO bonos_contr(codigo,de,a,monto) VALUES (NULL,'".$_POST['de']."','".$_POST['a']."','".$_POST['monto']."')";
$query = mysql_query($sql);

}

$campos = array("codigo AS COD"=>"","de AS DE"=>"","a AS A"=>"","monto AS MONTO"=>"");
$get1 = array("COD"=>"");
$rut = array("NULL"=>"");
$get1_var = array("ELIMINAR"=>"1");
$datos->Listado_per($campos,"bonos_contr","","","ELIMINAR",$get1,$get1,"INT/M_BONO.php",$rut,$get1_var,$get1_var,"table2");

?>