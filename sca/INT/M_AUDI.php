<script type="text/javascript">
$(document).ready(function() {
	
	$('td:contains("RENDIDO")').parent().addClass('verde');

	$('td:contains("NULO")').parent().addClass('rojo');

	$('td:contains("ENTREGADO")').parent().addClass('azul');
	
	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});		
	
$('#ajax3 a:contains("ANULAR")').click(function()  {

 if(!confirm(" Esta seguro de continuar?")) {
	  return false;} 
  else {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
 	}  
});

$('#ajax3 a:contains("Ver")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
});

$('#comprobar').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

});

</script>


<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$datos = new Datos;

/* Eliminar */
if( isset($_GET['ELIMINAR']) ){
    
    

    if ($_GET['ESTADO'] != 'INGRESADO' && $_GET['ESTADO'] != 'RENDIDO' && $_GET['ESTADO'] != 'OK'){

    $sql = "UPDATE `sicoremm`.`doc` SET `estado`='200' WHERE `folio`='".$_GET['FOLIO']."' AND `categoria`='".$_GET['GAT']."'";
    $query = mysql_query($sql);
    //echo $sql;
    }
    $_POST['ff_folio_bus'] = 1;
    $_POST['estado'] = 'TODOS';
}




/* LISTADO */

if ( isset($_POST['ff_folio_bus']) ){

foreach($_POST as $campo => $valor){ 
		
		
		if ($valor != $_POST['ff_folio_bus'] && $valor != ""){
			
			if ($campo =='ff_entrega'){
				$fechas = new Datos;
				$f_entrega = $fechas->cambiaf_a_mysql($_POST['ff_entrega']);
				$condicion['f_entrega']="= '".$f_entrega."'";
			}
			
			else if($valor != 'TODOS'){
				$condicion[$campo]=" LIKE '".$valor."%'";
			}
			
			if (is_numeric($valor)){
				$condicion[$campo]=" = ".$valor;
			}					
		}
	}
	
	$datos = new Datos;
	$campos = array("codigo AS COD"=>"","folio AS FOLIO"=>"","vendedor AS RUT"=>"","nombre1 as P_NOMBRE"=>"","nombre2 as S_NOMBRE"=>"","apellidos AS APELLIDOS"=>"","cat_des AS CATEGORIA"=>"","est_des AS ESTADO"=>"","f_entrega AS F_ENTREGA"=>"","codigo_est_res AS CAT"=>"","categoria as GAT"=>"");
	$rut = array('NULL'=>"");
	//$get1 =     array("ESTADO"=>"","GAT"=>"","FOLIO"=>"","RUT"=>"","CATEGORIA"=>"","P_NOMBRE"=>"");
        $get1 = array("ESTADO"=>"","GAT"=>"","FOLIO"=>"","RUT"=>"","CATEGORIA"=>"","P_NOMBRE"=>"","S_NOMBRE"=>"","CAT"=>"","COD"=>"");

	$rendir = array('RENDIR'=>'1');
	$eliminar = array('ELIMINAR'=>'1');	
	$datos->Listado_per($campos,'docu',$condicion,'Ver','ANULAR',$get1,$get1,'INT/M_AUDI.php',$rut,$rendir,$eliminar,'table');

}
?>

<?php
/* Rendicion */
if ( isset($_GET['RENDIR']) && $_GET['CAT'] != 600 && $_GET['CAT'] != 500){
	
	$rut = new Datos;

	$rut->validar_rut($_GET['RUT']);
	
	echo '<h1>VENDEDOR</h1>';
	echo '<form action="INT/SUB_M_AUDI_1.php" method="post" id="comprobar">';
	echo '
	<input type="text" value="'.$_GET['FOLIO'].'" style="display:none;" name="FOLIO">
	<input type="text" value="'.$_GET['CATEGORIA'].'" style="display:none;" name="CATEGORIA">
	<input type="text" value="'.$_GET['RUT'].'" style="display:none;" name="VENDEDOR">
	
	<table style="width:auto;">
	
	<tr>
	<td><strong>VENDEDOR</strong><td><input type="text" readonly="readonly" name="P_NOMBRE" value="'.$_GET['P_NOMBRE'].' '.$_GET['S_NOMBRE'].'"/></td>
	</tr>
	
	<tr>
	<td><strong>RUT</strong></td>
	<td><input type="text" readonly="readonly" name="ff_VENDEDOR_RUT" value="'.$rut->nro_doc .'" /></td>
	</tr>
	</table>
	
	<h1>Titular</h1>
	
	<table style="width:auto;">
	<tr>
	<td><strong>RUT TITULAR</strong></td>
	<td><input type="text" name="nro_doc" class="rut" /></td>
	<td><input type="submit" value="Comprobar" class="boton"></td>
	</table>
	</form>
	<h1>&nbsp;</h1>';
	
}

/*ING AUDITORIA */

if ( isset($_POST['ff_folio_ing'])){
	
	$campos_aud = array('folio'=>$_POST['folio'],'categoria'=>$_POST['categoria']);

        if ($_POST['categoria'] == '101' ){
        
        $campos_cont = array('num_solici'=>$_POST['folio']);
        $cont = $datos->ComDataUni($campos_cont,'contratos');
        }
        else{
            $cont = 0;
        }

        
	$aud = $datos->ComDataUni($campos_aud,'doc');
	
	$fecha = new Datos;
	
	$f_entrega = array("f_entrega"=>$fecha->cambiaf_a_mysql($_POST['ff_entrega']));
	
	
	if ($aud < 1 && $cont < 1){
	
		$datos->CompData('codigo','doc');	
		
	
		$cod = array('codigo'=>$datos->num);
		$datos->INSERT_PoST('doc','',$f_entrega,$cod);
		
		if( mysql_query($datos->query)){
			$condicion = "";
			echo OK;
		}
	
	}
	
	else{
		echo ERROR;
	}
}







//vista documentpos RENDIDOS Y LISTOS
if ( isset($_GET['RENDIR']) && ($_GET['CAT'] == 600 || $_GET['CAT'] == 500) ){
	
	//OBTENER EL NUMERO DE CONTRATO
	
	$con_sql = "SELECT num_solici,vendedor FROM doc WHERE codigo='".$_GET['COD']."'";
	
	$query = mysql_query($con_sql);
	$con = mysql_fetch_array($query);
	
	$_GET['CONTRATO'] = $con['num_solici'];

	echo '<h1>DATOS DEL VENDEDOR</h1><br />';	
	$vende = new Datos;
	
	$campos = array('nro_doc AS RUT'=>'','nombre1 AS P_NOMBRE'=>'','nombre2 AS S_NOMBRE'=>'','apellidos AS APELLIDOS'=>'','categoria AS CATEGORIA'=>'');
	$where = array('nro_doc'=>' = "'.$con['vendedor'].'"');	
	$rut = array('RUT'=>"");
	$vende->Imprimir($campos,"vend",$where,'2',$rut);
	
	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';	
	$contrato = new Datos;

	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);
	
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

	//TRANFERENCIA ELECTRONICA
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
	
	//CHEQUE AL dia
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


}


?>
<div id="ajax4"></div>
<?php
/* cerrar conexion */
mysql_close($conexion);
?>