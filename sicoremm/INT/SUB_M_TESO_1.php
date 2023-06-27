
<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


if ($_GET['GUARDAR'] > 0 && $_GET['CONTRATO'] > 0){

	$tran = new Datos;

	$mat['doc']= "UPDATE doc SET estado='600' WHERE num_solici='".$_GET['CONTRATO']."'";
	$mat['ventas_reg']="UPDATE ventas_reg SET estado_venta='200' WHERE num_solici='".$_GET['CONTRATO']."'";
	$mat['contratos']="UPDATE contratos SET estado ='100' WHERE num_solici='".$_GET['CONTRATO']."'";

	$tran->Trans($mat);
}

?>