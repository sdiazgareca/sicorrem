<script type="text/javascript">

$(document).ready(function() {

$('#ajax1 a:contains("Guardar")').click(function() {

	if(!confirm("Esta seguro de aprobar el contrato?")) {
		return false;}

	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

 $('#ajax1 a:contains("Ver")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

$('#ajax1 a:contains("Anular")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

$('#ajax1 a:contains("EDITAR")').click(function() {
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

/* PROCESA CAMBIOS AL TITULAR DEL CONTRATO */
if ($_POST['E_TITULAR_DATOS'] > 0 && $_POST['num_solici'] > 0){
//CALCULCA COMISIONES

$sql = "
SELECT
ventas_reg.vendedor,
vendedor.cat,
ventas_reg.num_solici,
contratos.f_pago,
f_pago.comi_free,
f_pago.locomocion
FROM ventas_reg
INNER JOIN vendedor ON ventas_reg.vendedor = vendedor.nro_doc
INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
WHERE contratos.num_solici ='".$_POST['num_solici']."' ventas_reg.estado_venta=200 AND ventas_reg.cat_venta=200";


echo '<br />'.$sql.'<br />';

$query = mysql_query($sql);



$comi = mysql_fetch_array($query);

foreach ($_POST as $campo => $valor){

	if($campo != 'E_TITULAR_DATOS' && $campo != 'num_solici' && $campo != 'rut_original'){

		if($campo == 'fecha_nac'){
			$fecha = new Datos;
			$edicion = $edicion." ".$campo." = '".$fecha->cambiaf_a_mysql($_POST['fecha_nac'])."',";
		}

		if($campo == 'nro_doc'){
			$rut = new Datos;
			$rut->Rut($valor);
			$edicion = $edicion." ".$campo." = '".$rut->nro_doc."',";
		}

		if($campo != 'fecha_nac' && $campo != 'nro_doc'){
			$edicion = $edicion." ".$campo." = '".$valor."', ";
	}
}
}

$cad = substr($edicion,0,strlen($edicion)-2);

$sql = "UPDATE titulares SET ".$cad." WHERE nro_doc='".$_POST['rut_original']."'";

	if (mysql_query($sql)){
		$_GET['ver']=1;
		$_GET['CONTRATO']= $_POST['num_solici'];
	}
	else{
		echo ERROR;
	}
}


/* ANULAR */
if ($_GET['anular']){

	echo 'hola mundo...';

}

/* VER */
if ($_GET['ver']){

	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);

	$fpago = new Datos;

        echo '<h1>RENDICION N '.$_GET['RENDICION'].'</h1>';

	echo '<h1>PAGO INCORPORACION </h1>';


	$sql3 = "SELECT cod_venta_reg,cod_pago_venta,des_pago_venta
            FROM REG_VENTAS
            WHERE num_solici ='".$_GET['CONTRATO']."'
                AND REG_VENTAS.cod_estado_venta = 200
                AND REG_VENTAS.cod_cat_venta=200
                AND REG_VENTAS.rendicion ='".$_GET['RENDICION']."'";



        $query3 = mysql_query($sql3);
	$doc_pago = mysql_fetch_array($query3);

	//CHEQUE A FECHA
	if ($doc_pago['cod_pago_venta'] > 9 && $doc_pago['cod_pago_venta'] < 11){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','sec AS N_AFI'=>'');
		$rut_y = array('NULL'=>'');

	}
	//CHEQUE AL dia
	if ($doc_pago['cod_pago_venta'] > 19 && $doc_pago['cod_pago_venta'] < 21){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','sec AS N_AFI'=>'');
		$rut_y = array('NULL'=>'');

	}

	//CHEQUE AL dia
	if ($doc_pago['cod_pago_venta'] > 29 && $doc_pago['cod_pago_venta'] < 31){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_TARJETA'=>'','des_t_credito AS TARJETA'=>'','sec AS N_AFI'=>'');
		$rut_y = array('NULL'=>'');

	}

	//EFECTIVO
	if ($doc_pago['cod_pago_venta'] > 39 && $doc_pago['cod_pago_venta'] < 41){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','sec AS N_AFI'=>'');
		$rut_y = array('NULL'=>'');

	}

        //GRATIS
        if ($doc_pago['cod_pago_venta'] > 59 && $doc_pago['cod_pago_venta'] < 61){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','sec AS N_AFI'=>'');
		$rut_y = array('NULL'=>'');

	}

	$where_y = array('num_solici ='=>'"'.$_GET['CONTRATO'].'"');
	$fpago->Imprimir($campos_y,"REG_VENTAS",$where_y,'2',$rut_y);


	echo '<div style="padding:10px" align="right">
	<a class="boton" href="INT/SUB_M_INCO_1.php?RENDICION='.$_GET['RENDICION'].'&GUARDAR=1&CONTRATO='.$_GET['CONTRATO'].'&cod_venta_reg='.$doc_pago['cod_venta_reg'].'">Guardar</a>
	</div>';



}
/* LISTADO CONTRATO */
$contrato = new Datos;

if ($_POST['ff_listado'] > 0){

	foreach($_POST as $campo => $valor){



	if ($valor != $_POST['ff_listado'] && $valor != ""){

		if (is_numeric($valor)){
				$condicion[$campo]=" = ".$valor;
		}
		else{
			if($valor != 'Todos'){
					$condicion[$campo]=" LIKE '".$valor."%'";
			}
		}
	}
	}

	$campos2 = array ("CONTRATO"=>"","TITULAR"=>"","DESCRIPCION"=>"","PLAN"=>"","RENDICION"=>"");
	$rut = array("NULL"=>"");
	$get_var1 = array("ver"=>"1");
	$get_var2 = array("anular"=>"1");
	$get = array ("CONTRATO"=>"","RENDICION"=>"");
	$rut = array("TITULAR"=>"");
	$contrato->Listado_per($campos2,'BUSQ_INCOR',$condicion,'Ver','Anular',$get,$get,'INT/M_TESO_INCO.php',$rut,$get_var1,$get_var2,'table');

}

?>