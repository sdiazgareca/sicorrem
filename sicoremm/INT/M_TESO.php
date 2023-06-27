<script type="text/javascript">

$(document).ready(function() {

$('#ajax1 a:contains("Aprobar")').click(function() {

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

                	if(!confirm("Esta seguro eliminar?")) {
		return false;}
		var ruta = $(this).attr('href');	
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 }); 

$('#ajax1 a:contains("Editar")').click(function() {
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
include_once('../CLA/Titular.php');
include_once('../CLA/Contrato.php');
include_once('../CLA/Domicilio.php');

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



        //DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO
        $datosRespo = new Titular;
        $datosRespo->DatosContratante($_GET['CONTRATO'],1);
	
        //VALOR MENSUAL DE LOS SERVICIOS
        $valorMensual = new Contrato;
        $valorMensual->ValorMensual($_GET['CONTRATO'],1);

        //OBTIENE LA FORMA DE PAGO
	$pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
	$pago_sql = mysql_query($pago);
	$tipo_pago = mysql_fetch_array($pago_sql);

        //FORMA DE PAGO MENSUAL
        $valorMensual->FormaPago($_GET['CONTRATO'], $tipo_pago['cod_f_pago'],1);

        //OBTIENE FORMA DE PAGO INICIAL
        $sql3 = "SELECT cod_pago_venta,des_pago_venta FROM REG_VENTAS WHERE num_solici ='".$_GET['CONTRATO']."'";
	//echo $sql3;
        $query3 = mysql_query($sql3);
	$doc_pago = mysql_fetch_array($query3);

        $sql__ = "SELECT titular,rendicion FROM ventas_reg WHERE num_solici='".$_GET['CONTRATO']."'";
        $query__ = mysql_query($sql__);
        $rendicion = mysql_fetch_array($query__);

        //FORMA DE PAGO INICIAL
        $valorMensual->FormaPagoInicial($_GET['CONTRATO'], $doc_pago['cod_pago_venta'],$rendicion['rendicion']);

        echo '<br />';
        //DOMICILIOS
        $dom = new Domicilio();
        $dom->Display( $_GET['CONTRATO'], $rendicion['titular'],'#ajax3');

        echo '<br />';
        //INGRESO DEL CONTRATO
	echo '<div style="padding:10px" align="right"><a class="boton" href="INT/SUB_M_TESO_1.php?GUARDAR=1&CONTRATO='.$_GET['CONTRATO'].'"> Aprobar</a></div>';


}



/* ANULAR */
if ($_GET['anular']){

        //echo $_GET['CONTRATO'];

        $afiliados = "SELECT * FROM afiliados WHERE titular='".$_GET['TITULAR']."'";
        $contratos = "SELECT * FROM contratos WHERE titular='".$_GET['TITULAR']."'";
        $titulares ="SELECT * FROM titulares WHERE titulares.nro_doc='".$_GET['TITULAR']."'";

        $q_afiliados = mysql_query($afiliados);
        $q_contratos = mysql_query($contratos);
        $q_titulares = mysql_query($titulares);

        $num_afiliados = mysql_num_rows($q_afiliados);
        $num_contratos = mysql_num_rows($q_contratos);
        $num_titulares = mysql_num_rows($q_titulares);

//echo 'n afiliados'.$num_afiliados.'<br />';
//echo 'n contratos'.$num_contratos.'<br />';
//echo 'n titulares'.$num_titulares.'<br />';

        if ($num_afiliados < 1){

            $query['titular'] = "DELETE FROM titulares WHERE nro_doc='".$_GET['TITULAR']."'";
            //echo $query['titular'].'<br />';
        }

        $query['doc'] ="DELETE FROM doc WHERE num_solici ='".$_GET['CONTRATO']."'";
        $query['doc_f_pago']="DELETE FROM doc_f_pago WHERE numero ='".$_GET['CONTRATO']."'";
        $query['contrato'] = "DELETE FROM contratos where contratos.num_solici='".$_GET['CONTRATO']."'";
        $query['afiliados'] ="DELETE FROM afiliados where afiliados.num_solici='".$_GET['CONTRATO']."'";
        $query['domicilios'] ="DELETE FROM domicilios where domicilios.num_solici='".$_GET['CONTRATO']."'";
        $query['ventas'] ="DELETE FROM ventas_reg where num_solici='".$_GET['CONTRATO']."' AND rendicion='".$_GET['RENDICION']."'";

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
