<script type="text/javascript">
$(document).ready(function() {

$('td:contains("Honorario")').parent().addClass('verde');
$('td:contains("Activo")').parent().addClass('verde');
$('td:contains("Renuncia")').parent().addClass('azul');
$('td:contains("Fallecimiento")').parent().addClass('azul');
$('td:contains("CM - Cliente Moroso")').parent().addClass('rojo');
$('td:contains("Baja Automatica")').parent().addClass('rojo');
$('td:contains("Falta de Pago")').parent().addClass('rojo');
$('td:contains("Dicom")').parent().addClass('rojo');
$('td:contains("DICOM")').parent().addClass('rojo');
$('td:contains("Otras Causas")').parent().addClass('azul');
$('td:contains("HONORARIO MOROSO")').parent().addClass('rojo');
$('td:contains("Desvinculado")').parent().addClass('azul');


    $('a:contains("Contrato")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});

    $('a:contains("Mensualidad")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});

    $('a:contains("Afiliados")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


    $('a:contains("Atenciones")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


    $('a:contains("Beneficiarios")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


    $('a:contains("V_Servicios")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


    $('a:contains("F_Pago")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


$('#ajax3 a:contains("ELIMINAR")').click(function() {

 if(!confirm(" Esta seguro de eliminar el antecedente medico?")) {
	  return false;}
  else {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
}
});


$('a:contains("VER")').click(function() {

	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


$('a:contains("Cam_Titular")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});

$('a:contains("Domicilios")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


$('a:contains("Cam_Titular")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});

$('a:contains("Rem_Afiliado")').click(function() {

	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});



$('#e_ante_med').submit(function(){

	 if(!confirm(" Esta seguro de eliminar el antecedente medico?")) {
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
include_once('../CLA/Contrato.php');

/* BUSQUEDA CONTRATOS */

if ( $_POST['bus_cont1'] > 0 ){

	$datos = new Datos;

	foreach($_POST as $campo => $valor){

		if (is_numeric($valor) && $campo != 'bus_cont1'){
			$condicion[$campo]=" = ".$valor;
		}

		else if ($campo != 'bus_cont1' && is_string($valor) && $valor != ""){
			$condicion[$campo]=" LIKE '".$valor."%'";
		}
	}

	$campos = array("titular as TITULAR"=>"","num_solici AS CONT"=>"","nro_doc AS RUT"=>"","nombre1 AS NOMBRE1"=>"","apellido AS APELLIDOS"=>"","des_categoria AS CAT"=>"","des_mot_baja AS EST"=>"","cod_plan AS C_PLAN"=>"","tipo_plan AS C_PLAN"=>"","desc_plan AS D_PLAN"=>"");

	$get1 = array("CONT"=>"","RUT"=>"","TITULAR"=>"");
	$get1_var = array("VER"=>'1');
	$get2_var = array(""=>'');
	$rut = array("NULL"=>"");
	$datos->Listado_per($campos,"afi",$condicion,"","VER",$get1,$get1,"INT/M_BUSQ.php",$rut,$get1_var,$get2_var,"table2");
}


if ($_GET['CONT'] > 0){

    //echo 'acap';

    $sql ="SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
FROM afiliados
WHERE (afiliados.cod_baja='00'  ||  afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ'  ||  afiliados.cod_baja='04')
AND num_solici='".$_GET['CONT']."' GROUP BY num_solici";


$query = mysql_query($sql);

    $secuencia = mysql_fetch_array($query);

    $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
        WHERE num_solici="'.$_GET['CONT'].'"';




    /* MENU */
    
    echo '<div style="font-size:14px; font-weight:bold;" id="mens1">CONTRATO '.$_GET['CONT'].'<br />'.$_GET['EST'].'</div>';
    
        $cont = new Contrato;
    $cont->MuestraResumenContrato($_GET['CONT']);

    echo '<br /><br />';



    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Contratante=1&CONTRATO='.$_GET['CONT'].'" class="boton">Contrato</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Antenciones=1&CONTRATO='.$_GET['CONT'].'" class="boton">Atenciones</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Mensualidad=1&CONTRATO='.$_GET['CONT'].'&RUT='.$_GET['TITULAR'].'" class="boton">Mensualidad</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Afiliados=1&CONTRATO='.$_GET['CONT'].'" class="boton">Afiliados</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Cambio_titular=1&CONTRATO='.$_GET['CONT'].'&RUT='.$_GET['TITULAR'].'" class="boton">Cam_Titular</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?Rem_afiliado=1&CONTRATO='.$_GET['CONT'].'&RUT='.$_GET['TITULAR'].'" class="boton">Rem_Afiliado</a>&nbsp;';
    echo '<a href="BUSQ/M_BUSQ_SUB_1.php?domicilios=1&CONTRATO='.$_GET['CONT'].'&RUT='.$_GET['TITULAR'].'" class="boton">Domicilios</a>&nbsp;';
    echo '<br /><br />';
    echo '<div id="cont1"></div>';
}
?>
