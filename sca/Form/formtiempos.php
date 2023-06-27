
<?php
include('../conf.php');
include('../bd.php');
include('../rut.php');


$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];
$num = $_GET['num'];

//COMPROBAR EL NOBRE DE NUM (MOVIL � LLAMADA EN ESPERA)
if ($num < 1000){
$men = 'Movil '.$num;
}
else{
$men = 'Llamado en Espera '.($num - 1000);
}
?>

<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td>Paciente</td>
</tr>
</table>

<!-- Aca Empieza la tabla que tiene el contenido de la tabla -->
<table style="width:500px;border:solid 1px #A6B7AF" class="celda2">
<tr>
<td>

<?php 

include('form/TABLA_TIEMPOS.php');
$consulta ="SELECT planes.casa_p,
planes.cm_gratis,
planes.copago,
planes.tiempo,
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,
DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') as hora_llega_destino,
DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') as hora_sale_destino,
DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,
DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,
DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,
DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,
sector.cod AS sector_cod,
obser_man,direccion,
edad,nro_doc,
correlativo,
telefono,
direccion,
entre,movil,color.color AS color,
color.cod,sector.sector AS sector,observacion,celular,edad,paciente,correlativo, hora_llegada_domicilio,diagnostico,obser_man,fichas.tipo_plan,isapre,fichas.cod_plan,CentroHospitalario,num_solici,CentroHospitalario
FROM fichas 
INNER JOIN sector ON sector.cod = fichas.sector
INNER JOIN color ON fichas.color = color.cod
LEFT JOIN planes ON planes.cod_plan = fichas.cod_plan AND planes.tipo_plan= fichas.tipo_plan
where movil='".$num."' and fichas.estado=1
 ";

//echo $consulta.'<br />';

$resultados = mysql_query($consulta);

while ( $matriz_resultados = mysql_fetch_array($resultados) ){// INICIO DEL WHILE PRINCIPAL


//atenciones anuales
$atencion_anual = "SELECT COUNT(fichas.hora_llamado) AS cantidad FROM fichas WHERE YEAR(fichas.hora_llamado)='".date('Y')."' AND (fichas.obser_man='24' ||  fichas.obser_man='42' || fichas.obser_man='45') AND fichas.num_solici= '".$matriz_resultados['num_solici']."'";
$atencion_anual_query = mysql_query($atencion_anual);
$atencion_mat = mysql_fetch_array($atencion_anual_query);
//atenciones mensuales
$atencion_mensual = "SELECT COUNT(fichas.hora_llamado) AS cantidad FROM fichas  WHERE YEAR(fichas.hora_llamado)='".date('Y')."' AND MONTH(fichas.hora_llamado) = '".date('m')."' AND (fichas.obser_man='24' ||  fichas.obser_man='42' || fichas.obser_man='45') AND fichas.num_solici= '".$matriz_resultados['num_solici']."'";
$atencion_mensual_query = mysql_query($atencion_mensual);
$atencion_mat_m = mysql_fetch_array($atencion_mensual_query);
//copagos pendientes
$deuda = "SELECT COUNT(copago.numero_socio) as cantidad FROM copago WHERE copago.numero_socio ='".$matriz_resultados['num_solici']."' AND ( (tipo_pago = '3')  || (tipo_pago = '4')) AND importe > 0 AND YEAR(fecha) >= 2011";
$deuda_query = mysql_query($deuda);
$deuda_query_m = mysql_fetch_array($deuda_query);


$plann = 'AFILIADO';

if($matriz_resultados['tipo_plan'] == 'PA'){
$plann ='PARTICULAR';
}
if($matriz_resultados['tipo_plan'] == 'CA'){
$plann ='FAMILIAR DIRECTO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_ME'){
$plann ='TRASLADO MEDICALIZADO CONVENIO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_CONV'){
$plann ='TRASLADO SIMPLE CONVENIO';
}

if ( ($matriz_resultados['tipo_plan'] == '1') and ($matriz_resultados['color']=='Azul')){
$plann ='TRASLADO PROGRAMADO AFILIADOS DIRECTO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_PAR'){
$plann ='TRASLADO SIMPLE DE PARTICULARES';
}
?>


<div style="text-align:center; font-size:12px; border-bottom:none; border-top:none;">Protocolo <?php echo $matriz_resultados['correlativo']; ?><br /><?php echo $plann; ?></div>

<br />

<?
include('form/ANULAR.php');

if($matriz_resultados['color'] != 'Azul'){
include('form/COPAGO.php');
}
else{
include('form/COPAGO2.php');
}
?>
<br /><br />

<?php
if ($matriz_resultados['cod_plan'] != 'PA'){
include('form/Info_copago.php');
}
//COMPRUEBA QUE TIPO DE PLAN SEA DIFERENTE DE "CA" Y "PA"
if ( ($matriz_resultados['tipo_plan'] != 'PA') && ($matriz_resultados['tipo_plan'] != 'TRA_ME') && ($matriz_resultados['tipo_plan'] != 'TRA_CONV') && ($matriz_resultados['tipo_plan'] != 'TRA_PAR')){
include('form/TABLA_DATOS_AFILIADOS_REGISTRADOS.php');
}

include('form/TABLA_FORMULARIO2.php');

if ($matriz_resultados['color'] != 'Azul'){
include('form/Sintomas.php');
}
?>

<?php
}// FIN DEL WHILE PRINCIPAL
mysql_close($conexion);
?>
<!-- FIN DE LA TABLA QUE CONTIENE -->
</td>
</tr>
</table>