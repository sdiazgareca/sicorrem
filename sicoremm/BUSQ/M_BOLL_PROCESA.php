<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');


if($_GET['limpiar'] == 1){

    $query_sql="TRUNCATE TABLE `sicoremm2`.`emi_par_ventas`";
    $query = mysql_query($query_sql);

    if($query){

     echo '<div class="mensaje1">Repositorio de boletas limpio.</div>';

    }
    else{
        echo '<div class="mensaje2">Error</div>';
    }
    exit;
}


if($_GET['imprimir'] > 0){
    

    $mas_sql="INSERT INTO `sicoremm2`.`emi_par_ventas`
	(`titular`,
	`comprovante`,
	`contrato`,
	`fecha_sistema`
	)
	VALUES
	('".$_GET['titular']."',
	'".$_GET['comprovante']."',
	'".$_GET['contrato']."',
	'".date('Y-m-d')."'
	)";

    $query= mysql_query($mas_sql);

    if($query){

    echo '<div class="mensaje1">OK</div>';
}
else{
    echo '<div class="mensaje2">:(</div>';
}

    exit;
    
}



$fecha2 = explode("-",$_POST['fecha']);
$mes_pago_inicial = explode("-",$_POST['mes_pago_inicial']);



$sql = "UPDATE  ventas_reg SET ff_factu='".$_POST['ff_factu']."',ventas_reg.fecha='".$fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]."', ventas_reg.vendedor='".$_POST['vendedor']."',
    ventas_reg.n_documento='".$_POST['n_documento']."',ventas_reg.mes_pago_inicial='".$mes_pago_inicial[2]."-".$mes_pago_inicial[1]."-".$mes_pago_inicial[0]."',
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
