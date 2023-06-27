<script type="text/javascript">
$(document).ready(function() {
$('#ajax4 a:contains("ELI")').click(function() {

	 if(!confirm(" Esta seguro de eliminar el ZO-SE-MA?")) {
		  return false;} 
	  else {
		var ruta = $(this).attr('href');	
	 	$('#ajax4').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	}  
	});
});

</script>

<?php 
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

if (isset($_GET['cobrador'])){
	$cobrador = $_GET['cobrador'];
}
if (isset($_POST['cobrador'])){
	$cobrador = $_POST['cobrador'];
}

if (isset($_POST['ff_zosema'])){
	$zo = explode('-',$_POST['ff_zosema']);
	$sql ='UPDATE ZOSEMA SET cobrador="'.$cobrador.'", estado="1" WHERE ZO="'.$zo[0].'" AND SE="'.$zo[1].'" AND MA="'.$zo[2].'"';
	$query = mysql_query($sql);
}


if ($_GET['ELIMINAR']){
$sql ='UPDATE ZOSEMA SET cobrador=NULL, estado="0" WHERE ZO="'.$_GET['ZO'].'" AND SE="'.$_GET['SE'].'" AND MA="'.$_GET['MA'].'"';
$query = mysql_query($sql);

}

$var = new Datos;

	$campos = array("ZO"=>"","SE"=>"","MA"=>"","descripcion"=>"");
	$where = array("cobrador"=>" = '".$cobrador."'");
	$get1 = array("VER"=>"1"); 
	$get2 = array("ELIMINAR"=>"1",'cobrador'=>$cobrador);
	$rut = array("NULL"=>"");
	$get1_var = array("ZO"=>"","SE"=>"","MA"=>"");
	
	$var->Listado_per($campos,"ZOSE",$where,"","ELI",$get1_var,$get1_var,"INT/SUB_M_COBR_1.php",$rut,$get1,$get2,"table2");
?>