<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');



if ($_GET['GUARDAR'] > 0 && $_GET['CONTRATO'] > 0){

        $tran = new Datos;
        
        $mat['doc']= "UPDATE doc SET estado='600' WHERE num_solici='".$_GET['CONTRATO']."'";
	$mat['ventas_reg']="UPDATE ventas_reg SET estado_venta='300' WHERE num_solici='".$_GET['CONTRATO']."' AND ventas_reg.codigo='".$_GET['cod_venta_reg']."' AND ventas_reg.rendicion='".$_GET['RENDICION']."'";
	$mat['contratos']="UPDATE contratos SET estado ='100' WHERE num_solici='".$_GET['CONTRATO']."'";

	$tran->Trans($mat);
}


if ($_GET['apro'] > 0){

	//OBTENER DATOS CONTRATO
	$con_q = "SELECT secuencia,f_pago,doc_pago FROM contratos WHERE num_solici='".$_GET['num_solici']."' AND titular='".$_GET['titular']."' AND cod_plan='".$_GET['cod_plan']."' AND tipo_plan='".$_GET['tipo_plan']."'";
	$query_con = mysql_query($con_q);
	$cont = mysql_fetch_array($query_con);

	//OBTENER VENDEDOR
	$query_vend = "SELECT vendedor,f_entrega FROM doc WHERE categoria = 101 AND num_solici ='".$_GET['num_solici']."'";
	$query_v = mysql_query($query_vend);
	$vend = mysql_fetch_array($query_v);

	//OBTENER MONTO
	$qyery_mont = "SELECT secuencia, valor, cod_plan, tipo_plan FROM valor_plan WHERE cod_plan='".$_GET['cod_plan']."' AND tipo_plan='".$_GET['tipo_plan']."' AND secuencia='".$cont['secuencia']."'";
	$query_m = mysql_query($qyery_mont);
	$monto = mysql_fetch_array($query_m);

	echo "UPDATE doc SET estado='600' WHERE num_solici='".$_GET['num_solici']."' AND vendedor='".$vend['vendedor']."'";
	echo '<br />';

	echo "UPDATE contratos SET estado='100' WHERE num_solici='".$_GET['num_solici']."' AND titular='".$_GET['titular']."' AND cod_plan='".$_GET['cod_plan']."' AND tipo_plan='".$_GET['tipo_plan']."'";
	echo '<br />';

	/*echo "INSERT INTO
	ventas_reg(codigo,num_solici,titular,vendedor,monto,fecha,cat_venta,estado_venta,pago_venta,n_documento,fecha_documento)
	VALUES('".$_GET['num_solici']."','".$_GET['num_solici']."','".$_GET['titular']."','".$vend['vendedor']."','".$monto['valor']."'
	,'','300','100','".$cont['f_pago']."','".$cont['doc_pago']."','".$vend['f_entrega']."')";
	echo '<br />';

	//CREAR CTA
	
        $ctacte_s = "SELECT * FROM emi_temp WHERE num_solici='".$_GET['num_solici']."'";
	$catcte_q = mysql_query($ctacte_s);
	$cta = mysql_fetch_assoc($catcte_q);

	$insert_cte ="INSERT INTO
	ctacte (tip_doc, nro_doc                , tipo_comp )
	VALUES ('1',     '".$_GET['titular']."' ,  )";
          
         */
}

if ($_GET['dene'] > 0){
	echo 'denegar';
	echo '<br />'.$_GET['cod_plan'];
}

if ($_GET['eli'] > 0){
	echo 'eliminar';
	echo '<br />'.$_GET['cod_plan'];
}

?>