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
include_once('../CLA/Afiliados.php');
include_once('../CLA/Titular.php');
include_once('../CLA/Contrato.php');

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

    //DATOS DEL RESPONSABLE DEL PAGO
    $datosRespo = new Titular();
    $datosRespo->DatosContratante($_GET['CONTRATO'],1);

    //VALOR MENSUAL DE LOS SERVICIOS
    $valorMensual = new Contrato;
    $valorMensual->ValorMensual($_GET['CONTRATO'],1);

    //OBTIENE FORMA DE PAGO
    $pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
    $pago_sql = mysql_query($pago);
    $tipo_pago = mysql_fetch_array($pago_sql);

    //FORMA DE PAGO MENSUAL

    $valorMensual->FormaPago($_GET['CONTRATO'],$tipo_pago['cod_f_pago'],1);

    //OBTIENE LA FORMA DE PAGO
    $sql3 ="SELECT cod_pago_venta, des_pago_venta FROM REG_VENTAS WHERE num_solici='".$_GET['CONTRATO']."'";
    
    //echo $sql3;

    $query = mysql_query($sql3);
    $fpago = mysql_fetch_array($query);


    //echo '<br />'.$fpago['cod_pago_venta'].'<br />';

    //FORMA DE PAGO INICIAL
    $valorMensual->FormaPagoInicial($_GET['CONTRATO'],$fpago['cod_pago_venta'],1);

    echo '<h1>GRUPO FAMILIAR</h1>';
    $afi = new Afiliados;
    $afi->VerAfiliados($_GET['CONTRATO'],'BUSQ/M_BUSQ_SUB_1.php?editar_afi=1','0');


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

	<h1>Ingreso de Afiliados</h1>

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