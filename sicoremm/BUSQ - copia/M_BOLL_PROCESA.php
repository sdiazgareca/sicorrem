<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');


$fecha2 = explode("-",$_POST['fecha']);




$sql = "UPDATE  ventas_reg SET ff_factu='".$_POST['ff_factu']."',ventas_reg.fecha='".$fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]."', ventas_reg.vendedor='".$_POST['vendedor']."',
    ventas_reg.n_documento='".$_POST['n_documento']."',
ventas_reg.monto='".$_POST['monto']."', ventas_reg.rendicion='".$_POST['rendicion']."' WHERE ventas_reg.codigo='".$_POST['codigo']."'";

//echo $sql;
$query = mysql_query($sql);


if($query){

    echo '<div class="mensaje1">OK</div>';
}
else{
    echo '<div class="mensaje1">:(</div>';
}
?>
