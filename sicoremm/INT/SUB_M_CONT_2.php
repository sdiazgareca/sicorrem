<script type="text/javascript">

$(document).ready(function() {

$('.rut').Rut({
  	on_error: function(){ alert('Rut incorrecto'); }
});

$('#ajax1 a:contains("VOLVER")').click(function() {
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

 $('#ajax1 a:contains("PARTICULAR")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

 $('#ajax1 a:contains("CONVENIO")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

 $('#ajax1 a:contains("AREA_PROT")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

	$('#e_titular').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#ajax3').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#valor').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#ajax3').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});

</script>

<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

if ($_GET['V_SERVICIOS'] >0 && $_GET['CONTRATO'] > 0){



	echo '<br /><h1>VALOR MENSUAL DE LOS SERVICIOS</h1><br />';

	$valores = new Datos;
	$campos_v = array('cod_plan AS COD_PLAN'=>'','tipo_plan AS TIPO_PLAN'=>'','desc_plan AS PLAN'=>'','valor AS VALOR_MENSUALIDAD'=>'','secuencia AS GRUPO_FAMILIAR'=>'','copago AS VALOR_COPAGO'=>'');
	$rut_v = array('NULO'=>'');
	$where_v = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');

	$valores->Imprimir($campos_v,"contr",$where_v,'2',$rut_v);
	echo '<br />';
		echo '<form action="INT/SUB_M_TESO_3.php" method="post" id="valor" name="valor">';

                echo '<input type="text" value="1" name="vms" style="display:none;" /> ';

		$query_sql ="SELECT tipo_plan,tipo_plan_desc FROM tipo_plan";
		$query = mysql_query($query_sql);
		echo '<div id="plan" class="sub_menu">';
		while ($plan = mysql_fetch_array($query)){
			echo '<a href="INT/DETALLE_PLAN_1.php?plan='.$plan['tipo_plan'].'">'.strtoupper($plan['tipo_plan_desc']).'</a>&nbsp;&nbsp;';
		}
		echo '</div>';

		echo '<div id="SUB20"></div>';
		echo '<br />';
		echo '<div align="right">
		<a class="boton" href="INT/M_TESO.php?ver=1&CONTRATO='.$_GET['CONTRATO'].'">VOLVER</a>
		<input type="submit" value="Guardar" class="boton" />
		</div>';

		echo '</form>';

}



if ($_GET['CONTRATANTE'] > 0 && $_GET['CONTRATO'] > 0){

	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

	$sql = "SELECT nro_doc, apellido, email,
			fecha_nac, nombre1, nombre2, civil_cod,civil_des,
			sexo, profesion_cod,profesion_des, telefono_emergencia, l_trabajo_cod,l_trabajo_desc,
			telefono_laboral,ciudad_desc,ciudad_cod,telefono_particular
			FROM TITU
			INNER JOIN contratos ON contratos.titular = TITU.nro_doc
			WHERE contratos.num_solici='".$_GET['CONTRATO']."'";

	$query = mysql_query($sql);

	$con = mysql_fetch_array($query);

	$datos = new Datos;

	echo '<form action="INT/M_CONT.php" method="post" name="e_titular" id="e_titular">';
	echo '<input type="text" name="E_TITULAR_DATOS" value="1" style="display:none" />';
	echo '<input type="text" name="num_solici" value="'.$_GET['CONTRATO'].'" style="display:none" />';


	$rut = new Datos;
	$rut->validar_rut($con['nro_doc']);

	echo '<table>
    <tr>
  	<input type="text" name="rut_original" value="'.$con['nro_doc'].'" style="display:none" />
    <td><strong>RUT</strong></td><td><input type="text" value="'.$rut->nro_doc.'" name="nro_doc" class="rut" /></td>
    <td><strong>P_NOMBRE</strong></td><td><input type="text" value="'.$con['nombre1'].'" name="nombre1" /></td>
    <td><strong>S_NOMBRE</strong></td><td><input type="text" value="'.$con['nombre2'].'" name="nombre2" /></td>
    </tr>

    <tr>
    <td><strong>APELLIDOS</strong></td><td><input type="text" value="'.$con['apellido'].'" name="apellido" /></td>
    <td><strong>F_NACIMIENTO</strong></td><td><input type="text" value="'.$con['fecha_nac'].'" name="fecha_nac" class="calendario" /></td>
    <td><strong>EMAIL</strong></td><td><input type="text" value="'.$con['email'].'" name="email" /></td>
    </tr>';
	echo '</table>';

	echo '<table>';
	echo '<tr>';
	$civil = new Select;
	echo '<td><strong> ESTADO CIVIL</strong></td>';
	echo '<td>'.$civil->selectOpp2('civil','descripcion,codigo','descripcion','codigo','civil','civil','NULL',$con['civil_cod'],$con['civil_des']).'</td>';
	echo '<td><strong> SEXO </strong></td>';
	echo '<td><select name="sexo"><option value="'.$con['sexo'].'" style="background:#09C">'.$con['sexo'].'</option><option value="F">F</option><option value="M">M</option></select></td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td><strong> PROFESION</td></strong>';
	$profesion = new Select;
	echo '<td>'.$profesion->selectOpp2('profesion','descripcion,codigo','descripcion','codigo','profesion','profesion','NULL',$con['profesion_cod'],$con['profesion_des']).'</td>';
	echo '<td><strong>FONO DE EMERGENCIA</strong></td><td><input type="text" name="telefono_emergencia" value="'.$con['telefono_emergencia'].'"/></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong> LUGAR DE TRABAJO </strong></td>';
	$trabajo = new Select;
	echo '<td>'.$trabajo->selectOpp2('l_trabajo','codigo,nombre','nombre','codigo','l_trabajo','l_trabajo','',$con['l_trabajo_cod'],$con['l_trabajo_desc']).'</td>';
	echo '<td><strong>FONO LABORAL</strong></td><td><input type="text" name="telefono_laboral" value="'.$con['telefono_laboral'].'"/></td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td><strong>CIUDAD</strong></td>';
	$ciudad = new Select;
	echo '<td>'.$ciudad->selectOpp2('ciudad','codigo,nombre','nombre','codigo','ciudad','ciudad','',$con['ciudad_cod'],$con['ciudad_desc']).'</td>';
	echo '<td><strong>FONO PARTICULAR</strong></td><td><input type="text" name="telefono_particular" value="'.$con['telefono_particular'].'"/></td></td>';
	echo '</table>';

	echo '<div style="padding:10px" align="right">
	<a class="boton" href="INT/M_CONT.php?ver=1&CONTRATO='.$_GET['CONTRATO'].'">VOLVER</a>
	<input type="submit" value="EDITAR" class="boton" />
	</div>';

}


?>