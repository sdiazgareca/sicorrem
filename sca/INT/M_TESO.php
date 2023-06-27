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
vendedor.cat, /* 100 FREELANCE 200 CONTRATADO */
ventas_reg.num_solici,
contratos.f_pago,
f_pago.comi_free,
f_pago.locomocion
FROM ventas_reg
INNER JOIN vendedor ON ventas_reg.vendedor = vendedor.nro_doc
INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
WHERE contratos.num_solici ='".$_POST['num_solici']."'
";

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


/* VER */
if ($_GET['ver']){
	
	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';
	
	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);
	echo '<div style="padding:10px" align="right">
	<a class="boton" href="INT/SUB_M_TESO_2.php?CONTRATANTE=1&CONTRATO='.$_GET['CONTRATO'].'">EDITAR</a>
	</div>';
	
	echo '<br /><h1>VALOR MENSUAL DE LOS SERVICIOS</h1>';



	$valores = new Datos;
	$campos_v = array('cod_plan AS COD_PLAN'=>'','tipo_plan AS TIPO_PLAN'=>'','desc_plan AS PLAN'=>'','valor AS VALOR_MENSUALIDAD'=>'','secuencia AS GRUPO_FAMILIAR'=>'','copago AS VALOR_COPAGO'=>'','d_pago AS DIA_DE_PAGO'=>'');
	$rut_v = array('NULO'=>'');
	$where_v = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	
	$valores->Imprimir($campos_v,"contr",$where_v,'2',$rut_v);
	
	$pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
	$pago_sql = mysql_query($pago);
	$tipo_pago = mysql_fetch_array($pago_sql);
	
	echo '<br /><h1>FORMA DE PAGO MENSUAL</h1>';

	$fpago = new Datos;
	echo $tipo_pago['cod_f_pago'].'<br />';
	//PAC
	if ($tipo_pago['cod_f_pago'] == 100){
		
	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','banco_des AS BANCO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);
	
	}
	
	//TARJETA DE CREDITO
	if ($tipo_pago['cod_f_pago'] == 200){
		
	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','t_credito_des AS T_CREDITO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);
	
	}	
	//COBRO DOMICILIARIO
	if ($tipo_pago['cod_f_pago'] == 300){
		
	$campos_f =array('calle AS CALLE'=>'','numero AS NUMERO'=>'','piso AS PISO'=>'','departamento AS DEPARTAMENTO'=>'','localidad AS LOCALIDAD'=>'','telefono AS FONO'=>'','email AS EMAIL'=>'','entre as ENTRE'=>'');
	$rut_f = array('NULL'=>'');
	$where_f = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"','tipo_dom ='=>'1');
	echo '<strong>DOMICILIO DE COBRO</strong>';
	$fpago->Imprimir($campos_f,"domicilios",$where_f,'4',$rut_f);
	}	
	
	//DESCUENTO POR PLANILLA
	if ($tipo_pago['cod_f_pago'] == 400){
		
	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');
	
	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$_GET['CONTRATO']."'";
	$query = mysql_query($sql);
	$emp = mysql_fetch_array($query);	
	
	$where_e = array('nro_doc ='=>'"'.$emp['empresa'].'"');
	echo '<strong>DESCUENTO POR PLANILLA</strong>';
	$fpago->Imprimir($campos_e,'emp',$where_e,'3',$rut_e);
	}

	//DESCUENTO POR PLANILLA
	if ($tipo_pago['cod_f_pago'] == 500){
	echo '<strong>TRASFERENCIA ELECTRONICA </strong>';
	}
	
	echo '<br /><h1>PAGO INICIAL</h1>';

	$sql3 = "SELECT cod_pago_venta,des_pago_venta FROM REG_VENTAS WHERE num_solici ='".$_GET['CONTRATO']."'";
	
        

        $query3 = mysql_query($sql3);
	$doc_pago = mysql_fetch_array($query3);
	
	//CHEQUE A FECHA
	if ($doc_pago['cod_pago_venta'] > 9 && $doc_pago['cod_pago_venta'] < 11){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}
	//CHEQUE AL dia
	if ($doc_pago['cod_pago_venta'] > 19 && $doc_pago['cod_pago_venta'] < 21){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}	
	
	//TARJETA DE CREDITO
	if ($doc_pago['cod_pago_venta'] > 29 && $doc_pago['cod_pago_venta'] < 31){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_TARJETA'=>'','des_t_credito AS TARJETA'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}

	//EFECTIVO
	if ($doc_pago['cod_pago_venta'] > 39 && $doc_pago['cod_pago_venta'] < 41){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');
	}

        //DESCUENTO POR PLANILLA
        if ($doc_pago['cod_pago_venta'] > 49 && $doc_pago['cod_pago_venta'] < 51){
            
            $campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'');
            $rut_y = array('NULL'=>'');

	}
	
	$where_y = array('num_solici ='=>'"'.$_GET['CONTRATO'].'"');
	$fpago->Imprimir($campos_y,"REG_VENTAS",$where_y,'2',$rut_y);
	//echo 'acaaaaaaaaaaaa';
	echo '<div style="padding:10px" align="right">
	<a class="boton" href="INT/SUB_M_TESO_1.php?GUARDAR=1&CONTRATO='.$_GET['CONTRATO'].'">Guardar</a>
	</div>';
	
}



/* ANULAR */
if ($_GET['anular']){

        echo $_GET['CONTRATO'];

        $titular = "SELECT * FROM afiliados WHERE titular='".$_GET['TITULAR']."'";
        $contratos_2 = "SELECT FROM contratos WHERE titular='".$_GET['TITULAR']."'";

        $q_titular = mysql_query($titular);
        $q_afiliados = mysql_query($contratos_2);

        $num_titular = mysql_num_rows($q_titular);
        $num_afiliados = mysql_num_rows($q_afiliados);

        if ($num_titular < 2 || $num_afiliados < 2){

            $query['titular'] = "DELETE FROM titulares WHERE nro_doc='".$_GET['TITULAR']."'";
        }
        $query['doc'] ="DELETE FROM doc WHERE num_solici ='".$_GET['CONTRATO']."'";
        $query['doc_f_pago']="DELETE FROM doc_f_pago WHERE numero ='".$_GET['CONTRATO']."'";
        $query['contrato'] = "DELETE FROM contratos where contratos.num_solici='".$_GET['CONTRATO']."'";
        $query['afiliados'] ="DELETE FROM afiliados where afiliados.num_solici='".$_GET['CONTRATO']."'";
        $query['domicilios'] ="DELETE FROM domicilios where domicilios.num_solici='".$_GET['CONTRATO']."'";

        $transaccion = new Datos;

        $transaccion->Trans($query);

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
	
	$campos = array ("num_solici AS CONTRATO"=>"","titular AS TITULAR"=>"","descripcion AS DESCRIPCION"=>"","desc_plan AS PLAN"=>"");
	$rut = array("NULL"=>"");
	$get_var1 = array("ver"=>"1");
	$get_var2 = array("anular"=>"1");
	$get = array ("CONTRATO"=>"","TITULAR"=>'');
	$rut = array("TITULAR"=>"");
	$contrato->Listado_per($campos,'contr',$condicion,'Ver','Anular',$get,$get,'INT/M_TESO.php',$rut,$get_var1,$get_var2,'table');
	
}

?>

