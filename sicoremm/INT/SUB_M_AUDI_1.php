

<?php
date_default_timezone_set('UTC');
?>

<script type="text/javascript">
$(document).ready(function() {

	//$("#identificador").get(0).value;

	$('#forma_pago_2 a').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB0').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	});

	$('#plan a').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB2').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	});

	$('#forma_pago a').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB1').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	});

	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});

	$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

	$('#ingreso').submit(function(){

		if(!confirm(" Esta seguro de igresar el contrato?")) {
		return false;}

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

if (isset($_POST['nro_doc'])){

        $sql = "DELETE FROM titulares WHERE titulares.nro_doc NOT IN (SELECT contratos.titular FROM contratos)";
        $query = mysql_query($sql);
        //echo "<br /><strong>".$sql."</strong></br />";
    
    	// COMPROBAR SI EL TITULAR TIENE MAS DE UN CONTRATO
	$datos = new Datos;
	$rut = new Datos;
	$rut->Rut($_POST['nro_doc']);

        if($rut->nro_doc < 2){
            echo 'RUT NO VALIDO';
            exit;
	}

	$campos = array('nro_doc'=>$rut->nro_doc);
	$n_titular = $datos->ComDataUni($campos,"titulares");
	$todos_afi = $datos->ComDataUni($campos,"afiliados");

        $n_titular_afiliado_sql = "Select afiliados.nro_doc from afiliados where afiliados.categoria =1 and afiliados.nro_doc='".$rut->nro_doc."'";
        $n_titular_afiliado_query = mysql_query($n_titular_afiliado_sql);
        $n_titular_afiliado = mysql_num_rows($n_titular_afiliado_query);

        $afili = "Select afiliados.nro_doc from afiliados where afiliados.categoria =2 and afiliados.nro_doc='".$rut->nro_doc."'";
        $afili_query = mysql_query($afili);
        $n_beneficiario = mysql_num_rows($afili_query);


	/* MATRIZ FORMULARIO */
	$valores= array('RUT'=>$_POST['nro_doc'],"APELLIDOS"=>"","P_NOMBRE"=>"","S_NOMBRE"=>"","F_NACIMIENTO"=>"","EMAIL"=>"");
	$calendario = array("F_NACIMIENTO"=>"calendario");

        if ($n_titular < 1 && $n_beneficiario > 0 && $n_titular_afiliado < 1 && $todos_afi > 0 ){
            echo "<h2>RUT DEL TITULAR EXISTE  COMO AFILIADO EN OTRO CONTRATO</h2>";

        }

	//RUT DEL TITULA NO IXISTE EN EL SISTEMA
	if ( ($n_titular_afiliado < 1 && $n_titular < 1) || ($n_titular < 1 && $n_beneficiario > 0 && $n_titular_afiliado < 1 && $todos_afi > 0 ) ){

	//echo ("RUT DEL TITULAR NO EXISTE EN EL SISTEMA");
	$blok = array("RUT"=>"");

	/* FORMULARIO */
    	echo '<form action="INT/SUB_M_AUDI_1.php" method="post" name="ingreso" id="ingreso">';
        echo '<h1>RENDICION</h1>';

        echo '<strong>Rendicion</strong> <input type="text" name="ff_rendicion" size="5" />';
        echo '<strong> Fecha contrato </strong> <input type="text" name="ff_f_contrato" class="calendario" size="10" />';
        echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

	echo '<input type="text" name="ff_RUT" value="'.$_POST['nro_doc'].'" style="display:none"  />';
	echo '<input type="text" name="ff_ingres" value="1" style="display:none" />';

	echo '<input type="text" name="ff_vendedor" value="'.$_POST['VENDEDOR'].'" style="display:none" />';

	$datos->Formulario($valores,'3',$rut,$calendario,$blok);
	$select = new Select;

	echo '<div style="padding:5px;">';
	echo '<strong> ESTADO CIVIL  </strong>';
	echo $select->selectSimple('civil','descripcion,codigo','descripcion','codigo','ff_civil','ff_civil','NULL');

	echo '<strong> SEXO </strong>';
	echo '<select name="ff_sexo"><option value="F">FEMENINO</option><option value="M">MASCULINO</option></select>';
	//echo '<strong>Forma de Pago   </strong>';
	//echo $select->selectSimple('civil','descripcion,codigo','descripcion','codigo','civil','civil','NULL');

	echo '<strong> PROFESION </strong>';
	echo $select->selectSimple('profesion','descripcion,codigo','descripcion','codigo','ff_profesion','ff_profesion','NULL');

	echo '<br /><br />';

	echo '<strong> FONO DE EMERGENCIA </strong> <input type="text" name="telefono_emergencia"/>';

	echo '<strong> LUGAR DE TRABAJO </strong>';
	$ciudad = new Select;
	$ciudad->selectSimple('l_trabajo','codigo,nombre','nombre','codigo','l_trabajo','l_trabajo','');

	echo '<br /><br /><strong> FONO LABORAL </strong> <input type="text" name="telefono_laboral"/>';

	echo '<strong> CIUDAD </strong>';
	$ciudad = new Select;
	$ciudad->selectSimple('ciudad','codigo,nombre','nombre','codigo','ciudad','ciudad','');

	echo '</div>';
	}


        // RUT DEL TITULAR EXISTE COMo AFILIADO
	if ( $n_titular > 0 && $todos_afi > 0){
            echo "<h2>RUT DEL TITULAR EXISTE AFILIADO EN OTRO CONTRATO</h2>";
            $ingreso = 1;
        }
        //RUT DEL TITULAR EXISTE COMO TITULAR NO COMO AFILIADO
	if ( $n_titular > 0 && $todos_afi < 1){
            echo "<h2>RUT DEL TITULAR EXISTE COMO TITULAR EN OTRO CONTRATO</h2>";
            $ingreso = 1;
        }        
        

	// RUT DEL TITULAR EXISTE COMO TITULAR NO COMO AFILIADO
	if ( $ingreso > 0){

		//COMPROBAR ESTADO DE PAGO DEL TITULAR
                $sql = "SELECT contratos.estado, contratos.num_solici, e_contrato.descripcion FROM contratos LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado WHERE contratos.titular='".$rut->nro_doc."'";
                $query = mysql_query($sql);


                echo '<h1>CONTRATOS</h1>';
                ?>
                    <table class ="table">
                        <?php while ($pago = mysql_fetch_array($query) ){ ?>
                        <tr>
                            <td><strong>Contrato</strong></td><td><?php echo $pago['num_solici']; ?></td>
                            <td><strong>Estado</strong></td><td><?php echo $pago['descripcion']; ?></td>
                            <?php if ($pago['estado'] == 3100 || $pago['estado'] == 1100 || $pago['estado'] == 600 || $pago['estado'] == 900 || $pago['estado'] == 3600){$info1 = 100; } ?>
                            <?php if ($pago['estado'] < 400){$info2 = 200; } ?>
                        </tr>

                        <?php } ?>
                    </table>
                <?

                   if ($info1 == 100){
                       echo '<h2>EL RUT ASOCIADO POSEE DEUDA<h2>';
                       exit;
                   }
                   if ($info2 == 200){
                       echo '<h2>EL RUT ASOCIADO POSEE UN CONTRATO EN CURSO<h2>';
                   }

                /*
                if($pago['estado'] != 00 || $pago['estado'] != ){

                }
                */

                echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

		$contrato = new Datos;
		$campos = array('nro_doc AS RUT'=>'','apellido AS APELLIDOS'=>'','nombre1 AS NOMBRE_1'=>'','nombre2 AS NOMBRE_2'=>'','fecha_nac AS F_NAC'=>'','email AS EMAIL'=>'','civil_des AS E_CIVIL'=>'','sexo AS SEXO'=>'','profesion_des AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','l_trabajo_desc AS L_TRABAJO'=>'','telefono_laboral AS F_LABORAL'=>'','ciudad_desc AS CIUDAD'=>'');
		$where = array('nro_doc'=>' = "'.$rut->nro_doc.'"');
		$rut = array('RUT'=>"");
		$contrato->Imprimir($campos,"TITU",$where,'2',$rut);

	echo '<form action="INT/SUB_M_AUDI_1.php" method="post" name="ingreso" id="ingreso">';

        echo '<h1>RENDICION</h1>';
        echo '<strong>Rendicion</strong> <input type="text" name="ff_rendicion" size="5" />';
        echo '<strong> Fecha contrato </strong> <input type="text" name="ff_f_contrato" class="calendario" size="10" />';

	echo '<input type="text" name="ff_ingres" value="2" style="display:none" />';
	echo '<input type="text" name="ff_RUT" value="'.$_POST['nro_doc'].'" style="display:none"  />';
	echo '<input type="text" name="RUT" value="'.$_POST['nro_doc'].'" style="display:none"  />';
	echo '<input type="text" name="ff_vendedor" value="'.$_POST['VENDEDOR'].'" style="display:none" />';

	}

	/*DATOS DEL CONTRATO */
	echo '<h1>Datos del Contrato</h1>';

	/* CONTRATO 1 */
	$contrato1 = "SELECT codigo,folio FROM doc WHERE categoria='101' AND vendedor='".$_POST['VENDEDOR']."'  AND estado < 500";
	$contrato1_query= mysql_query($contrato1);
	echo '<p><strong> CONTRATO 1 </strong><select name="ff_cont1">';
	while($cont1 = mysql_fetch_array($contrato1_query)){
		echo '<option value="'.$cont1['codigo'].'">'.$cont1['folio'].'</option>';
	}
	echo '</select>';

	/* CONTRATO 2 */
	$contrato2 = "SELECT codigo,folio FROM doc WHERE categoria='102' AND vendedor='".$_POST['VENDEDOR']."'  AND estado < 500";
	$contrato2_query = mysql_query($contrato2);

	echo '<strong> CONTRATO 2 </strong> <select name="ff_cont2">';
	while($cont2 = mysql_fetch_array($contrato2_query)){
		echo '<option value="'.$cont2['codigo'].'">'.$cont2['folio'].'</option>';
	}
	echo '</select>';

        /* DOMICILIO PARTICULAR */
        echo '<h1>DIRECCION PARTICUALR</h1>';

	echo '<strong> CALLE/PASAJE </strong> <input type="text" name="ff_a_pasaje_par" size="10" />';
	echo '<strong> VILLA/POBLACION </string><input type="text" name="ff_a_poblacion_par"';

	echo '<strong> NUMERO </strong> <input type="text" name="ff_a_numero_par" size="2" />';
	echo '<br /><br />';
	echo '<strong> DEPARTAMENTO </strong> <input type="text" name="ff_a_departamento_par" />';
	echo '<strong> PISO </strong> <input type="text" name="ff_a_piso_par" size="2" />';
	echo '<strong> LOCALIDAD </strong><input type="text" name="ff_a_localidad_par" size="10" />';
	echo '<strong> TELEFONO </strong><input type="text" name="ff_a_telefono_par" size="6" />';
        echo '<strong> ENTRE </strong><input type="text" name="ff_a_entre_par" size="6" />';
	echo '<br /><br />';

	$provincia2 = new Select;
	echo '<strong> PROVINCIA </strong>';

	$provincia2->selectSimple('provincia','codigo,provincia','provincia','codigo','ff_a_provincia_par','ff_a_provincia_par','');
	echo '<input type="text" name="MA" size="10" value="1" style="display:none;"/>';

	echo '<br /><br />';

	/*FORMA DE PAGO MENSUALIDAD */

	echo '<h2><strong> FORMA DE PAGO MENSUALIDAD </strong></h2>';
	$query_sql ="SELECT f_pago.codigo, descripcion FROM f_pago WHERE codigo != 600";
	$query = mysql_query($query_sql);
	echo '<div id="forma_pago_2" class="sub_menu">';
	while ($f_pago_M = mysql_fetch_array($query)){
		echo '<a href="INT/SUB_M_AUDI_F_PAGO_1.php?fpago_M='.$f_pago_M['codigo'].'&folio='.$_POST['FOLIO'].'&categoria='.$_POST['CATEGORIA'].'&vendedor='.$_POST['VENDEDOR'].'">'.strtoupper($f_pago_M['descripcion']).'</a>&nbsp;&nbsp;';
	}
	echo '</div>';
	echo '<div id="SUB0"></div>';

		/* PLANES */
		echo '<h2><strong>PLAN</strong></h2>';
		$query_sql ="SELECT tipo_plan,tipo_plan_desc FROM tipo_plan";
		$query = mysql_query($query_sql);
		echo '<div id="plan" class="sub_menu">';
		while ($plan = mysql_fetch_array($query)){
			echo '<a href="INT/SUB_M_AUDI_F_PAGO_1.php?plan='.$plan['tipo_plan'].'">'.strtoupper($plan['tipo_plan_desc']).'</a>&nbsp;&nbsp;';
		}
		echo '</div>';
		echo '<div id="SUB2"></div>';
//echo 'aca';
		//SUB_M_AUDI_F_PAGO_1
		echo '<div align="right"><input type="submit" value="Guardar" class="boton" /></div>';
		echo '</form>';

}


/* INGRESO DEL TITULAR */
if( isset($_POST['ff_ingres'])){

    if(isset($_POST['ff_fpago']) == false){
        echo '<div class="mensaje2">DEBE ESPECIFICAR LA FORMA DE PAGO INICIAL</div>';
        exit;
    }


	$datos = new Datos;

	$datos->Rut($_POST['ff_RUT']);
	$fecha_nac =$datos->cambiaf_a_mysql($_POST['ff_F_NACIMIENTO']);

	/* TITULAR */

	$titular_obj = new Datos;
	$agg = array('nro_doc'=>$datos->nro_doc,"nombre1"=>$_POST['ff_P_NOMBRE'],"nombre2"=>$_POST['ff_S_NOMBRE'],"apellido"=>$_POST['ff_APELLIDOS'],"email"=>$_POST['ff_EMAIL'],"fecha_nac"=>$fecha_nac,"civil"=>$_POST['ff_civil'],"sexo"=>$_POST['ff_sexo'],"profesion"=>$_POST['ff_profesion'],'telefono_emergencia'=>$_POST['telefono_emergencia'],'lugar_de_trabajo'=>$_POST['lugar_de_trabajo'],'telefono_laboral'=>$_POST['telefono_laboral'],'ciudad'=>$_POST['ciudad'],'l_trabajo'=>$_POST['l_trabajo']);
	$titular_obj->INSERT_PoST_cont('titulares',$condicion,$agg);

	if ($_POST['ff_ingres'] < 2  && $_POST['ff_ingres'] > 0){
		$transaccion['titular']= $titular_obj->query;
	}

	/* OBTENER NUMERO DE CONTRATO */
	$cont_sql ="SELECT folio FROM doc WHERE codigo ='".$_POST['ff_cont1']."'";
	$cont_query = mysql_query($cont_sql);
	$n_contrato = mysql_fetch_array($cont_query);

	/* ESTADO DEL CONTRATO 1*/
	$contrato1 = new Datos;
	$cam_doc1 = array('estado'=>'500','num_solici'=>$n_contrato['folio']);
	$con_doc1 = "WHERE codigo = '".$_POST['ff_cont1']."'";
	$contrato1->UPDATE_Param('doc',$cam_doc1,$con_doc1);

	$transaccion['contrato_1'] = $contrato1->query;

	/* ESTADO DEL CONTRATO 2*/
	$contrato2 = new Datos;
	$cam_doc2 = array('estado'=>'500','num_solici'=>$n_contrato['folio']);
	$con_doc2 = "WHERE codigo = '".$_POST['ff_cont2']."'";
	$contrato2->UPDATE_Param('doc',$cam_doc2,$con_doc2);

	$transaccion['contrato_2'] = $contrato2->query;

	$f_pago= 'NULL';

	/* INGRESO PAC */
	if ($_POST['ff_pago'] == 100){

		$documento = new Datos;
		$documento->CompData('numero','doc_f_pago');
		$f_pago = $documento->num;

		$pac = new Datos;

		$zo ="777";

		switch ($_POST['ff_banco']) {

			case 100:
			$se ="BCI";
			break;

			case 900:
			$se ="EST";
			break;

			default:
			$se ="OB";
			break;
		}

		$ma = "001";

		$rut_titular = new Datos;
		$rut_titular->Rut($_POST['ff_rut_titular_cta']);


		if ($_POST[ff_cuenta1] == $_POST[ff_cuenta2] && $_POST[ff_cuenta1] != "" && $_POST[ff_cuenta1] != 0 ){
			$otr_pac = array('nombre2'=>$_POST['ff_nombre1'],'apellidos'=>$_POST['ff_apellidos'],'t_credito'=>'NULL','numero'=>$f_pago,'banco'=>$_POST['ff_banco'],'cta'=>$_POST['ff_cuenta1'],'titular_cta'=>$_POST['ff_titular_cta'],'rut_titular_cta'=>$rut_titular->nro_doc);
		}
		else{
			echo 'Error: La cta no valida';
			exit;
		}

		/* INGRESO DEL PAC */
		$pac->INSERT_PoST_cont('doc_f_pago',$condicion,$otr_pac);

		$transaccion['pac'] = $pac->query;

		/* CAMBIO ESTADO DEL PAC */
		$pac_doc = new Datos;
		$con_doc3 = "WHERE codigo = '".$_POST['ff_pac']."'";
		$pac_doc->UPDATE_Param('doc',$cam_doc2,$con_doc3);

		$transaccion['pac_estado'] = $pac_doc->query;
	}

	/* INGRESO TARJETA DE CREDITO */
	if ($_POST['ff_pago'] == 200){

		$zo = "888";
		$se = "888";
		$ma = "888";

		$f_pago= 'NULL';
		$tajeta = new Datos;

		$rut_titular = new Datos;
		$rut_titular->Rut($_POST['ff_rut_titular_cta']);

		if ($_POST[ff_cuenta1] == $_POST[ff_cuenta2] && $_POST[ff_cuenta1] != "" && $_POST[ff_cuenta1] != 0 ){

		$documento = new Datos;
		$documento->CompData('numero','doc_f_pago');
		$f_pago = $documento->num;
		$otr_pac = array('nombre2'=>$_POST['ff_nombre1'],'apellidos'=>$_POST['ff_apellidos'],'t_credito'=>$_POST['ff_t_credito'],'numero'=>$documento->num,'banco'=>'NULL','cta'=>$_POST['ff_cuenta1'],'titular_cta'=>$_POST['ff_titular_cta'],'rut_titular_cta'=>$rut_titular->nro_doc);
		}

		else{
			echo 'Error: La cta no valida';
			exit;
		}

		/* INGRESO TARJETA */
		$tajeta->INSERT_PoST_cont('doc_f_pago',$condicion,$otr_pac);
		$transaccion['tarjeta'] = $tajeta->query;

	}

	/* INGRESO COBRO DOMICILIARIO */
	if($_POST['ff_pago'] == 300){

	//Asignar ZO-SE-MA
	$zose = explode('-',$_POST['ff_sozema']);
	$zo = $zose[0]; $se = $zose[1]; $ma = $zose[2];

	$f_pago= 'NULL';
	$domici = new Datos;

	$cod = new Datos;
	$cod->CompData('cod','domicilios');

}

	/* INGRESO TRANFERENCIA ELECTRONICA */
	if($_POST['ff_pago'] == 500){
	$zo = '222'; $se ='222' ; $ma = '222' ;
	}

	/* INGRESO EMPRES */
	if($_POST['ff_pago'] == 400){

	//Asignar ZO-SE-MA
	$zose = explode('-',$_POST['ff_sozema']);
	$zo = $zose[0]; $se = $zose[1]; $ma = $zose[2];

	$f_pago= 'NULL';

	$query_sql = "SELECT ZO, SE, MA FROM empresa WHERE empresa.nro_doc='".$_POST['empresa']."' ";
	$query = mysql_query($query_sql);

	while ($emp = mysql_fetch_array($query)){

		$zo = $emp['ZO'];
		$se = $emp['SE'];
		$ma = $emp['MA'];
	}

}

	/* INGRESO CONTRATO */
	$con = new Datos;

	$_POST['empresa'] = (is_numeric($_POST['empresa'])) ? $_POST['empresa'] : 'NULL';	
	$otr_cont = array('factu'=>$_POST['ff_factu'],'empresa'=>$_POST['empresa'],'d_pago'=>$_POST['ff_d_pago'],'secuencia'=>$_POST['ff_secuencia'],'ZO'=>$zo,'SE'=>$se,'MA'=>$ma,'num_solici'=>$n_contrato['folio'],'estado'=>'200','titular'=>$datos->nro_doc,'f_pago'=>$_POST['ff_pago'],'cod_plan'=>$_POST['ff_plan'],'tipo_plan'=>$_POST['ff_tipo_plan'],'doc_pago'=>$f_pago,'f_ingreso'=>date('Y-m-d'));
	$con->INSERT_PoST_cont('contratos',$condicion,$otr_cont);

	$transaccion['contrato'] = $con->query;



	/* INGRESO DOMICILIOS */
	if($_POST['ff_pago'] == 300){

		$_POST['piso'] = (is_numeric($_POST['piso'])) ? $_POST['piso'] : 'NULL';
		$val = array("tipo_plan"=>$_POST['ff_tipo_plan'],"cod_plan"=>$_POST['ff_plan'],"nro_doc"=>$datos->nro_doc,"num_solici"=>$n_contrato['folio'],"tipo_dom"=>"1","cod"=>$cod-num," poblacion"=>$_POST['poblacion'],"calle"=>$_POST['ff_pasaje'],"numero"=>$_POST['ff_numero'],"departamento"=>$_POST['departamento'],"piso"=>$_POST['piso'],"localidad"=>$_POST['localidad'],"telefono"=>$_POST['telefono'],"entre"=>$_POST['entre']);
		$domici->INSERT_PoST_cont('domicilios','',$val,'');
		//echo '<br />'.$domici->query.'<br />';
                $transaccion['domicilios'] = $domici->query;

	}

	if($_POST['ff_tipo_plan'] == 3){

		$cod = new Datos;
		$cod->CompData('cod','domicilios');
		$domi = new Datos;
		$_POST['piso'] = (is_numeric($_POST['piso'])) ? $_POST['piso'] : 'NULL';
		$val = array("tipo_plan"=>$_POST['ff_tipo_plan'],"cod_plan"=>$_POST['ff_plan'],"nro_doc"=>$datos->nro_doc,"num_solici"=>$n_contrato['folio'],"tipo_dom"=>"5","cod"=>$cod-num +1,"poblacion"=>$_POST['ff_a_poblacion'],"calle"=>$_POST['ff_a_pasaje'],"numero"=>$_POST['ff_a_numero'],"departamento"=>$_POST['ff_a_departamento'],"piso"=>$_POST['ff_a_piso'],"localidad"=>$_POST['ff_a_localidad'],"telefono"=>$_POST['ff_a_telefono']);
		$domi->INSERT_PoST_cont('domicilios','',$val,'');
		$transaccion['domi'] = $domi->query;

	}


	/* REGISTRO DE VENTA */

	$rutt = new Datos;
	$rutt->Rut($_POST['ff_RUT']);

//FECHA CONTRATO

$mespi = new Datos();
$fecha_mes = $mespi->cambiaf_a_mysql($_POST['ff_m_pago_i']);
$_POST['ff_rendicion'] = (is_numeric($_POST['ff_rendicion'])) ? $_POST['ff_rendicion'] : '0';
//echo '<br />'.$fecha_mes.'<br />';

	//INGRESO EFECTIVO FPAGO INCORPORACION

        //CHEQUE A FECHA
        if ($_POST['ff_fpago'] > 9 && $_POST['ff_fpago'] < 11){

            	$fecha = new Datos;

                $f_documento = $fecha->cambiaf_a_mysql($_POST['fecha_documento']);

	$veta = 'INSERT INTO
	ventas_reg(tipo_plan,cod_plan,ff_factu,n_che_tar,rendicion,mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,estado_venta,
        pago_venta,n_documento,fecha_documento,t_documento,sec,f_ingreso,bancos)VALUES
        ("'.$_POST['ff_tipo_plan'].'","'.$_POST['ff_cod_plan'].'","'.$_POST['ff_factu'].'","'.$_POST['n_che_tar'].'","'.$_POST['ff_rendicion'].'","'.$fecha_mes.'",
         "'.$n_contrato['folio'].'","'.$rutt->nro_doc.'","'.$_POST['ff_vendedor'].'",
         "'.str_replace ( ".", "",$_POST['monto']).'","'.date('Y-m-d').'","100","200",
         "'.$_POST['ff_fpago'].'","'.$_POST['ff_n_docc'].'","'.$f_documento.'",
         "'.$_POST['ff_t_doc'].'","'.$_POST['secuencia_PP'].'","'.date('Y-m-d').'","'.$_POST['ff_banco'].'")';

        		$transaccion['venta'] = $veta;
		echo $veta;

        }


        //cheque al dia
	if ($_POST['ff_fpago'] > 19 && $_POST['ff_fpago'] < 21){

		$fecha = new Datos;
		$lfecha = $fecha->cambiaf_a_mysql($_POST['fecha']);

		$veta = 'INSERT INTO
		ventas_reg(tipo_plan,cod_plan,ff_factu,rendicion,n_che_tar,bancos,mes_pago_inicial,num_solici,
                titular,vendedor,monto,fecha,cat_venta,estado_venta,pago_venta,n_documento,
		fecha_documento,t_documento,sec)
		VALUES ("'.$_POST['ff_tipo_plan'].'","'.$_POST['ff_cod_plan'].'","'.$_POST['ff_factu'].'","'.$_POST['ff_rendicion'].'","'.$_POST['n_che_tar'].'","'.$_POST['ff_banco'].'","'.$fecha_mes.'","'.$n_contrato['folio'].'","'.$rutt->nro_doc.'","'.$_POST['ff_vendedor'].'",
		"'.str_replace ( ".", "",$_POST['monto']).'","'.date('Y-m-d').'","100","200","'.$_POST['ff_fpago'].'","'.$_POST['n_documento'].'","'.$lfecha.'","'.$_POST['ff_t_doc'].'","'.$_POST['secuencia_PP'].'")';

		$transaccion['venta'] = $veta;
		echo $veta;
	}

        //INGRESO TARJETA DE CREDITO
	if ($_POST['ff_fpago'] > 29 && $_POST['ff_fpago'] < 31){

		$veta = 'INSERT INTO
		ventas_reg(tipo_plan,cod_plan,ff_factu,rendicion,n_che_tar,t_credito,mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,estado_venta,pago_venta,n_documento,
		fecha_documento,t_documento,sec)
		VALUES ("'.$_POST['ff_tipo_plan'].'","'.$_POST['ff_cod_plan'].'","'.$_POST['ff_factu'].'","'.$_POST['ff_rendicion'].'","'.$_POST['n_tarjeta'].'","'.$_POST['ff_t_credito'].'","'.$fecha_mes.'","'.$n_contrato['folio'].'","'.$rutt->nro_doc.'","'.$_POST['ff_vendedor'].'",
		"'.str_replace ( ".", "",$_POST['monto']).'","'.date('Y-m-d').'","100","200","'.$_POST['ff_fpago'].'","'.$_POST['n_documento'].'","NULL","'.$_POST['ff_t_doc'].'","'.$_POST['secuencia_PP'].'")';

		$transaccion['venta'] = $veta;
	}

        //INGRESO EFECTIVO
	if ($_POST['ff_fpago'] > 39 && $_POST['ff_fpago'] < 41){
		$veta = 'INSERT INTO
		ventas_reg(rendicion,tipo_plan,cod_plan,ff_factu,mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,estado_venta,pago_venta,n_documento,
		fecha_documento,t_documento,sec)
		VALUES ("'.$_POST['ff_rendicion'].'","'.$_POST['ff_tipo_plan'].'","'.$_POST['ff_cod_plan'].'","'.$_POST['ff_factu'].'","'.$fecha_mes.'","'.$n_contrato['folio'].'","'.$rutt->nro_doc.'","'.$_POST['ff_vendedor'].'",
		"'.str_replace ( ".", "",$_POST['monto']).'","'.date('Y-m-d').'","100","200","'.$_POST['ff_fpago'].'","'.$_POST['ff_n_docc'].'",
		NULL,"'.$_POST['ff_t_doc'].'","'.$_POST['secuencia_PP'].'")';

		$transaccion['venta'] = $veta;
	}

	//DESCUENTO X PLANILLA
	if ($_POST['ff_fpago'] > 49 && $_POST['ff_fpago'] < 51){

		$veta = 'INSERT INTO
		ventas_reg(tipo_plan,cod_plan,ff_factu,rendicion,mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,estado_venta,pago_venta,n_documento,
		fecha_documento,t_documento,sec)
		VALUES ("'.$_POST['ff_tipo_plan'].'","'.$_POST['ff_cod_plan'].'","'.$_POST['ff_factu'].'","'.$_POST['ff_rendicion'].'","'.$fecha_mes.'","'.$n_contrato['folio'].'","'.$rutt->nro_doc.'","'.$_POST['ff_vendedor'].'",
		"'.str_replace ( ".", "",$_POST['monto']).'","'.date('Y-m-d').'","100","200","'.$_POST['ff_fpago'].'","'.$_POST['ff_n_docc'].'",
		NULL,"'.$_POST['ff_t_doc'].'","'.$_POST['secuencia_PP'].'")';

		$transaccion['venta'] = $veta;

	}

        /*DOMICILIO DE PARTICULAR */
        $cod2 = new Datos;
	$cod2->CompData('cod','domicilios');
	$domi2 = new Datos;

        $val = array("tipo_plan"=>$_POST['ff_tipo_plan'],"cod_plan"=>$_POST['ff_plan'],
            "nro_doc"=>$datos->nro_doc,"num_solici"=>$n_contrato['folio'],"tipo_dom"=>"2","cod"=>$cod2->num," poblacion"=>$_POST['ff_a_poblacion_par'],"calle"=>$_POST['ff_a_pasaje_par'],"numero"=>$_POST['ff_a_numero_par'],"departamento"=>$_POST['ff_a_departamento_par'],"piso"=>$_POST['ff_a_piso_par'],"localidad"=>$_POST['ff_a_localidad_par'],"telefono"=>$_POST['ff_a_telefono_par'],"entre"=>$_POST['ff_a_entre_par']);
	$domi2->INSERT_PoST_cont('domicilios','',$val,'');
	$transaccion['domicilios2'] = $domi2->query;


	/* TRANSACCION */
	$bd = new Datos;
	$bd->Trans($transaccion);
}
?>
