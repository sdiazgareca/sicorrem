<script type="text/javascript">

$(document).ready(function() {

$('#ajax1 a:contains("Recargar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });



});

</script>
aqui
<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Afiliados.php');

//COMPROBAR RUT EXISTENTES



if ($_POST['afi'] > 0){
$rut = new Datos;

$rut->Rut($_POST['nro_doc']);

$sql = "SELECT nro_doc FROM afiliados WHERE nro_doc = '".$rut->nro_doc."'
    AND (cod_baja = 'AZ' || cod_baja ='00' || cod_baja= '01' || cod_baja='05')";

$query = mysql_query($sql);
$num = mysql_num_rows($query);

$sql2 = "SELECT titulares.nro_doc, contratos.estado FROM titulares
INNER JOIN contratos ON contratos.titular = titulares.nro_doc
WHERE titulares.nro_doc='".$rut->nro_doc."' AND (estado = 900 || estado ='3600' || estado='3100')";
$query2 = mysql_query($sql2);
$num2 = mysql_num_rows($query2);


if ($num > 0 || $num2 > 0){

        if($num2 > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe como titular en otro contrato y tiene deuda pendiente</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_INCO_CON.php?SEC='.$_POST['SEC'].'&ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

        if($num > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe en la base de datos como activo</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_INCO_CON.php?SEC='.$_POST['SEC'].'&ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

}
else{

$fech = $rut->cambiaf_a_mysql($_POST['fecha_nac']);

if ( $_POST['titular'] != $rut->nro_doc ) {
	$categoria = '2';
}

else{
	$categoria = '1';
}

$dat = new Datos;

$inser['cont'] ="INSERT INTO afiliados (nro_doc,nombre1,nombre2,apellido,sexo,obra_afi,fecha_nac,cod_parentesco,
num_solici,cod_plan,tipo_plan,fecha_alta,titular,fecha_act,fecha_ing,pais,cod_baja, categoria)
VALUES('".$rut->nro_doc."','".$_POST['nombre1']."','".$_POST['nombre2']."','".$_POST['apellido']."','".$_POST['sexo']."','".$_POST['obra_afi']."',
'".$fech."' ,'".$_POST['cod_parentesco']."','".$_POST['num_solici']."',
'".$_POST['cod_plan']."','".$_POST['tipo_plan']."','".$_POST['fecha_alta']."','".$_POST['titular']."','".$_POST['fecha_act']."',
'".$_POST['fecha_ing']."','".$_POST['pais']."','".$_POST['cod_baja']."','".$categoria."')";


foreach( $_POST as $campo => $valor){

	$cadena = explode("_",$campo);

	if ($cadena[0] == "ATE"  &&  $valor > 0){
		$inser[$campo.$valor] = "INSERT INTO `sicoremm`.`ate_medicos_reg`(`codigo`,`ate_medicos`) VALUES ( '".$rut->nro_doc."','".$valor."')";

	}
}


$dat->Trans($inser);

	//DATOS DEL CONTRATO

	$sql = "SELECT num_solici, contratos.titular, contratos.secuencia, contratos.cod_plan, contratos.tipo_plan FROM contratos WHERE contratos.num_solici='".$_POST['num_solici']."'";
	$query = mysql_query($sql);
	$comi = mysql_fetch_array($query);

	$campos = "SELECT nro_doc AS RUT,nombre1 AS NOMBRE1,nombre2 AS NOMBRE2,apellido AS APELLIDOS,
	sexo AS SEXO,des_obras_soc AS P_SALUD,fecha_nac AS F_NAC,
	num_solici AS N_CONTRATO,cod_plan AS COD_PLAN,tipo_plan AS T_PLAN,
	desc_plan AS PLAN,fecha_ing AS F_INGRESO,
	des_mot_baja AS ESTADO,des_categoria AS CATEGORIA
	FROM afi WHERE afi.num_solici='".$_POST['num_solici']."'";

	$query = mysql_query($campos);

?>

<h2>Afiliado</h2>
<table class="table">
<tr>

<?php

	$cont = 0;

	$mat = mysql_fetch_assoc($query);

	foreach($mat as $campos => $values){
		echo '<td><strong>'.$campos.'</strong></td><td>'.$values.'</td>';
		$cont ++;
		if ( ($cont % 4)  < 1){
			echo '</tr>';
		}
	}
?>
</tr>
</table>
<br /><br/>
<?php
}

}


if ($_POST['BOLL']){

	//CALCULCA COMISIONES
	$sql = "SELECT
                        ventas_reg.mes_pago_inicial,
			ventas_reg.monto,
			ventas_reg.vendedor,
			vendedor.cat, /* 100 FREELANCE 200 CONTRATADO */
			ventas_reg.num_solici,
			contratos.f_pago,
			f_pago.comi_free,
			f_pago.locomocion,
			contratos.cod_plan,
			contratos.tipo_plan,
                        contratos.titular
			FROM ventas_reg
			INNER JOIN vendedor ON ventas_reg.vendedor = vendedor.nro_doc
			INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
			INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
			WHERE contratos.num_solici ='".$_POST['num_solici']."'
			";

	$query = mysql_query($sql);
	$comi = mysql_fetch_array($query);

	//$comision = $comi['monto'] * $comi['comi_free'] /100;


      

	$query2['boleta'] = "UPDATE sicoremm.ventas_reg SET estado_veta=300, n_documento='".$_POST['n_boleta']."',locominion='".$comi['locomocion']."' WHERE num_solici='".$_POST['num_solici']."' AND cat_venta='200' AND vendedor='".$comi['vendedor']."'";
	$query2['contrato'] = "UPDATE sicoremm.contratos SET estado='500' WHERE num_solici='".$_POST['num_solici']."'";

        
        $query3['ctacte'] ="INSERT INTO cta
            (tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)
            VALUES ('B','50','1','".$comi['titular']."','".$_POST['n_boleta']."','100','','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

        $sec = new Afiliados;
        $sec->Secuencia($_POST['num_solici']);

        $tr = new Datos;
	$tr->Trans($query2);

	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_POST['num_solici'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);


	echo '<br /><h1>VALOR MENSUAL DE LOS SERVICIOS</h1>';

	$valores = new Datos;
	$campos_v = array('cod_plan AS COD_PLAN'=>'','tipo_plan AS TIPO_PLAN'=>'','desc_plan AS PLAN'=>'','valor AS VALOR_MENSUALIDAD'=>'','secuencia AS GRUPO_FAMILIAR'=>'','copago AS VALOR_COPAGO'=>'','d_pago AS DIA_DE_PAGO'=>'');
	$rut_v = array('NULO'=>'');
	$where_v = array('num_solici'=>' = "'.$_POST['num_solici'].'"');

	$valores->Imprimir($campos_v,"contr",$where_v,'2',$rut_v);

	$pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_POST['num_solici']."'";
	$pago_sql = mysql_query($pago);
	$tipo_pago = mysql_fetch_array($pago_sql);


	echo '<br /><h1>FORMA DE PAGO MENSUAL</h1>';

	$fpago = new Datos;

	//PAC
	if ($tipo_pago['cod_f_pago'] == 100){

	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','banco_des AS BANCO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$_POST['num_solici'].'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);

	}

	//TARJETA DE CREDITO
	if ($tipo_pago['cod_f_pago'] == 200){

	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','t_credito_des AS T_CREDITO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$_POST['num_solici'].'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);

	}
	//COBRO DOMICILIARIO
	if ($tipo_pago['cod_f_pago'] == 300){

	$campos_f =array('calle AS CALLE'=>'','numero AS NUMERO'=>'','piso AS PISO'=>'','departamento AS DEPARTAMENTO'=>'','localidad AS LOCALIDAD'=>'','telefono AS FONO'=>'','email AS EMAIL'=>'','entre as ENTRE'=>'');
	$rut_f = array('NULL'=>'');
	$where_f = array('num_solici'=>' = "'.$_POST['num_solici'].'"','tipo_dom ='=>'1');
	echo '<strong>DOMICILIO DE COBRO</strong>';
	$fpago->Imprimir($campos_f,"domicilios",$where_f,'4',$rut_f);
	}

	//DESCUENTO POR PLANILLA
	if ($tipo_pago['cod_f_pago'] == 400){

	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');

	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$_POST['num_solici']."'";
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

	$sql3 = "SELECT cod_pago_venta,des_pago_venta FROM REG_VENTAS WHERE num_solici ='".$_POST['num_solici']."'";
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

	$where_y = array('num_solici ='=>'"'.$_POST['num_solici'].'"');
	$fpago->Imprimir($campos_y,"REG_VENTAS",$where_y,'2',$rut_y);

	//DATOS DEL CONTRATO

	$sql = "SELECT num_solici, contratos.titular, contratos.secuencia, contratos.cod_plan, contratos.tipo_plan FROM contratos WHERE contratos.num_solici='".$_POST[�num_solici�]."'";
	$query = mysql_query($sql);
	$comi = mysql_fetch_array($query);
        echo '<div class="mensaje1">';
	echo '<h1>GRUPO FAMILIAR</h1>';
	$campos = "SELECT nro_doc AS RUT,nombre1 AS NOMBRE1,nombre2 AS NOMBRE2,apellido AS APELLIDOS,
	sexo AS SEXO,des_obras_soc AS P_SALUD,fecha_nac AS F_NAC,
	num_solici AS N_CONTRATO,cod_plan AS COD_PLAN,tipo_plan AS T_PLAN,
	desc_plan AS PLAN,fecha_ing AS F_INGRESO,
	des_mot_baja AS ESTADO,des_categoria AS CATEGORIA
	FROM afi WHERE afi.num_solici='".$_POST['num_solici']."'";

	$query = mysql_query($campos);
?>
<h2>Afiliado</h2>
<table class="table">
<tr>

<?php

	$cont = 0;

	$mat = mysql_fetch_assoc($query);

	foreach($mat as $campos => $values){
		echo '<td><strong>'.$campos.'</strong></td><td>'.$values.'</td>';
		$cont ++;
		if ( ($cont % 4)  < 1){
			echo '</tr>';
		}
	}
?>
</tr>
</table>
</div>
<br /><br />

<div>
<a target="_blank" href="BIN/DOC1.pdf" class="boton">C. Bienv</a>
<a target="_blank" href="BIN/DOC1.pdf" class="boton">Boleta</a>
</div>
<?php
}
?>