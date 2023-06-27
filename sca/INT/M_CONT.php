<script type="text/javascript">

$(document).ready(function() {

	
$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('.rut').Rut({
  on_error: function(){ alert('Rut incorrecto'); }
});	
	
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

$('#ajax1 a:contains("Editar")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 }); 

$('#bol').submit(function(){

	if(!confirm("Recuerde almecenar los afiliados del contrato, Desea continuar?")) {
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

/* PROCESA CAMBIOS AL TITULAR DEL CONTRATO */
if ($_POST['E_TITULAR_DATOS'] > 0 && $_POST['num_solici'] > 0){

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
if ( isset($_GET['ver']) ){

	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';	
	
	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);

        //BOTON EDITAR
        echo '<div style="padding:10px" align="right">
	<a class="boton" href="INT/SUB_M_CONT_2.php?CONTRATANTE=1&CONTRATO='.$_GET['CONTRATO'].'">Editar</a>
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
	
	//DATOS DEL CONTRATO
	
	$sql_num = "SELECT num_solici, contratos.titular, contratos.secuencia, contratos.cod_plan, contratos.tipo_plan FROM contratos WHERE contratos.num_solici='".$_GET['CONTRATO']."'";	
	$query_num = mysql_query($sql_num);
	
	$comi = mysql_fetch_array($query_num);
	
	$campos2 = "SELECT nro_doc AS RUT,nombre1 AS NOMBRE1,nombre2 AS NOMBRE2,apellido AS APELLIDOS,
	sexo AS SEXO,des_obras_soc AS P_SALUD,fecha_nac AS F_NAC,
	num_solici AS N_CONTRATO,cod_plan AS COD_PLAN,tipo_plan AS T_PLAN,
	desc_plan AS PLAN,fecha_ing AS F_INGRESO,
	des_mot_baja AS ESTADO,des_categoria AS CATEGORIA 
	FROM afi 
	WHERE afi.num_solici='".$_GET['CONTRATO']."'";
	
	$query2 = mysql_query($campos2);
	$num2 = mysql_num_rows($query2);	
	
	echo '<h1>GRUPO FAMILIAR</h1>';
	if ($num2 > 0){
		$cont = 0;
		while($mat_2 = mysql_fetch_array($query2)){
		
			echo '<h2>Afiliado</h2><table class="table"><tr>';		
			echo '<td><strong>RUT</strong></td><td>'.$mat_2['RUT'].'</td>';
			echo '<td><strong>NOMBRE1</strong></td><td>'.$mat_2['NOMBRE1'].'</td>';
			echo '<td><strong>NOMBRE2</strong></td><td>'.$mat_2['NOMBRE2'].'</td>';
			echo '<td><strong>APELLIDOS</strong></td><td>'.$mat_2['APELLIDOS'].'</td>';
			echo '</tr><tr>';
			echo '<td><strong>SEXO</strong></td><td>'.$mat_2['SEXO'].'</td>';
			echo '<td><strong>P_SALUD</strong></td><td>'.$mat_2['P_SALUD'].'</td>';
			echo '<td><strong>F_NAC</strong></td><td>'.$mat_2['F_NAC'].'</td>';
			echo '<td><strong>N_CONTRATO</strong></td><td>'.$mat_2['N_CONTRATO'].'</td>';			
			echo '</tr><tr>';
			echo '<td><strong>COD_PLAN</strong></td><td>'.$mat_2['COD_PLAN'].'</td>';
			echo '<td><strong>T_PLAN</strong></td><td>'.$mat_2['T_PLAN'].'</td>';
			echo '<td><strong>ESTADO</strong></td><td>'.$mat_2['ESTADO'].'</td>';
			echo '<td><strong>CATEGORIA</strong></td><td>'.$mat_2['CATEGORIA'].'</td>';			
			echo '</tr></table>';
		}
		
	}
	
	$stop = ($comi['secuencia'] - $num2);
	
	for($i = 1; $i < ($stop + 1); $i++ ){
?>

	<script type="text/javascript">
	$(document).ready(function() {	
		$('#ingreso<?php echo $i; ?>').submit(function(){
		if(!confirm(" Esta seguro de ingresar el registro?")) {
			  return false;} 
		
		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();
		
		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
		$('#ing<?php echo $i; ?>').html(data);}}) 
		
		url_ajax ="";
		data_ajax="";
		
		return false;});
	});
	</script>


<div id="ing<?php echo $i; ?>" name="ing<?php echo $i; ?>">
	
	<h2>Afiliado</h2>

	<form action="INT/M_CONT_SUB_1.php" method="post" id="ingreso<?php echo $i; ?>" name="ingreso<?php echo $i; ?>">
	<table class="table">
	<tr>
	<td><strong>RUT</strong></td><td><input type="text" name="nro_doc" class="rut"/></td>	
	<td><strong>NOMBRE 1</strong></td><td><input type="text" name="nombre1"/></td>
	</tr>
	
	<tr>
	<td><strong>NOMBRE 2</strong></td><td><input type="text" name="nombre2"/></td>
	<td><strong>APELLIDOS</strong></td><td><input type="text" name="apellido"/></td>
	</tr>
	
	<tr>
	<td><strong>SEXO</strong></td><td><select name="sexo"><option value=""></option><option value="M">MASCULINO</option><option value="F">FEMENINO</option></select></td>
	
	<td><strong>P. DE SALUD</strong></td>
	<td>
	<?php
	$isa_sql = "SELECT nro_doc, descripcion FROM obras_soc";
	$isa_query = mysql_query($isa_sql);
	
	?>
	<select name="obra_afi">
	<option value=""></option>
	<?php 
	while ($isa = mysql_fetch_array($isa_query)){
	?>
	<option value="<?php echo $isa['nro_doc']; ?>"><?php echo $isa['descripcion']; ?></option>
	<?php 
	}
	?>
	</select>
	</td>
	
	</tr>
	
	<tr>
	<td><strong>F.NAC</strong></td><td><input type="text" name="fecha_nac" class="calendario"/></td>	
	<td><strong>PARENTESCO</strong></td>
	
	<td>
	
	<?php
	$pare_sql = "SELECT cod_parentesco, glosa_parentesco FROM parentesco WHERE cod_parentesco != 500";
	$pare_query = mysql_query($pare_sql);
	
	?>
	<select name="cod_parentesco">
	<option value=""></option>
	<?php 
	while ($pare = mysql_fetch_array($pare_query)){
	?>
	<option value="<?php echo $pare['cod_parentesco']; ?>"><?php echo $pare['glosa_parentesco']; ?></option>
	<?php 
	}
	?>
	</select>
	
	</td>	
	</tr>

	<tr style="display:none">
	<td><strong>num_solici</strong></td><td><input type="text" name="afi" value="1"/></td>
	<td><strong>num_solici</strong></td><td><input type="text" name="num_solici" value="<?php echo $comi['num_solici']; ?>"/></td>
	<td><strong>cod_plan</strong></td><td><input type="text" name="cod_plan" value="<?php echo $comi['cod_plan']; ?>"/></td>
	<td><strong>tipo_plan</strong></td><td><input type="text" name="tipo_plan" value="<?php echo $comi['tipo_plan']; ?>"/></td>
	<td><strong>fecha_alta</strong></td><td><input type="text" name="fecha_alta" value="<?php echo date('Y-m-d'); ?>"/></td>	
	<td><strong>titular</strong></td><td><input type="text" name="titular" value="<?php echo $comi['titular']; ?>"/></td>
	<td><strong>fecha_act</strong></td><td><input type="text" name="fecha_act" value="<?php echo date('Y-m-d'); ?>"/></td>		
	<td><strong>fecha_ing</strong></td><td><input type="text" name="fecha_ing" value="<?php echo date('Y-m-d'); ?>"/></td>
	<td><strong>pais</strong></td><td><input type="text" name="pais" value="600"/></td>	
	<td><strong>cod_baja</strong></td><td><input type="text" name="cod_baja" value="00"/></td>
	</tr>
	
	</table>
	
	<br /><h1>Antecedentes Medicos</h1>
	<table class="table2">
	<tr>
	<?php 
	$cont = 0;
	$sql2 ="SELECT cod, descripcion FROM ate_medicos";
	$mysql2 = mysql_query($sql2);
	
	while ($ate = mysql_fetch_array($mysql2)){
		
		echo '<td><strong>'.$ate['descripcion'].'</strong></td><td><input name="ATE_'.$cont.'" type="checkbox" value="'.$ate['cod'].'" /></td>';
		$cont ++;
		
		if( ($cont % 4) < 1){
			echo '</tr>';
		}
		
		
	}
	?>
	</tr>
	</table>
	<div align="right"><input type="submit" value="Guardar" class="boton" /></div>
	
	</form>
</div>	
<?php 	
}
?>

<form action="INT/M_CONT_SUB_1.php" method="post" id="bol" name="bol">
<table class="table2">
<tr>
<td><strong>N BOLETA</strong></td>
<td><input type="text" name="n_boleta" /></td>
<td><input type="submit" value="Guardar" class="boton" /></td>
</tr>

<tr style="display:none">
<td><input type="text" name="BOLL" value="1"/></td>
<td><input type="text" name="num_solici" value="<?php echo $comi['num_solici']; ?>"/></td>
</tr>

</table>
</form>

<?php
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
	
	$campos = array ("CONTRATO"=>"","TITULAR"=>"","DESCRIPCION"=>"","PLAN"=>"","SEC"=>"");
	$rut = array("NULL"=>"");
	$get_var1 = array("ver"=>"1");
	$get_var2 = array("anular"=>"1");
	$get = array ("CONTRATO"=>"","SEC"=>"");
	$rut = array("TITULAR"=>"");
	$contrato->Listado_per($campos,'INCOR_C',$condicion,'Ver','Anular',$get,$get,'INT/M_CONT.php',$rut,$get_var1,$get_var2,'table');
}
?>