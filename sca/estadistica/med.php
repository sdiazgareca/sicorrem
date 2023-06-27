<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=med.xls");

include('../conf.php');
include('../bd.php');
include('../rut.php');

$mes = $_GET['mes_conv_med'];
$anio = $_GET['anio_conv_med'];
?>

<table>
<tr>
<td>FOLIO ATENCION</td>
<td>N&ordm; FICHA</td>
<td>DIA ATENCION</td>
<td>MES ATENCION</td>
<td>A&Ntilde;O ATENCION</td>
<td>RUT_ PRESTADOR</td>
<td>DV_PRESTADOR</td>
<td>RUT_TRATANTE</td>
<td>DV_TRATANTE</td>
<td>NOMBRE TRATANTE</td>
<td>APELLIDOS TRATANTE</td>
<td>CODIGO ESPECIALIDAD</td>
<td>ESPECIALIDAD TRATANTE</td>
<td>RUT_TITULAR</td>
<td>DV_TITULAR</td>
<td>NOMBRE TITULAR</td>
<td>APELLIDOS TITULAR</td>
<td>RUT_PACIENTE</td>
<td>DV_PACIENTE</td>
<td>NOMBRE_PACIENTE</td>
<td>APELLIDOS_PACIENTE</td>
<td>CODIGO PARENTESCO</td>
<td>DESCRIPCION PARENTESCO</td>
<td>CIE 10</td>
<td>GLOSA CIE</td>
<td>CODIGO TIPO DE ATENCION</td>
<td>TIPO DE ATENCION</td>
<td>COD INST PREVISIONAL</td>
<td>DESCRIPCION  INST PREVISIONAL</td>
<td>CODIGO PRESTADOR DERIVADO</td>
<td>PRESTADOR DERIVADO</td>
<td>CODIGO TIPO COBRO</td>
<td>TIPO COBRO</td>
<td>FOLIO DOCUMENTO</td>
<td>OBSERVACIONES</td>
</tr>
<?php

$i=1;

$power="SELECT
DATE_FORMAT(hora_llamado,'%d') AS dia,
DATE_FORMAT(hora_llamado,'%m') AS mes,
DATE_FORMAT(hora_despacho,'%Y') AS anio,
personal.nombre1 AS nom_medico,
personal.apellidos AS ape_medico,
personal.rut_1 AS rutdoc,
personal.rut_d AS digdoc,
copago.boleta,
copago.folio_med,
fichas.nro_doc,
fichas.destino,
fichas.correlativo,
color.cod AS cod_color,
fichas.paciente,
color.color,
fichas.correlativo,
fichas.paramedico,
fichas.conductor,
fichas.movil,
sector.sector,
fichas.observacion,
fichas.tipo_plan,
fichas.cod_plan,
fichas.CentroHospitalario,
fichas.diagnostico,
fichas.isapre,
titulares.nombre1 AS nombre1_titu,
titulares.nombre2 AS nombre2_titu,
titulares.apellido AS apellidos_titu,
titulares.nro_doc AS rut_titular

FROM fichas
INNER JOIN color ON fichas.color=color.cod
INNER JOIN copago ON fichas.correlativo = copago.protocolo
INNER JOIN sector ON sector.cod=fichas.sector
INNER JOIN personal ON personal.rut = fichas.medico
INNER JOIN contratos ON contratos.num_solici = fichas.num_solici
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
WHERE fichas.cod_plan='W71' AND fichas.tipo_plan = '2'
and (obser_man = 24 ||  obser_man = 42 || obser_man = 45) and fichas.estado=0
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."' ".' '.$dia."
order by nro_doc";


$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>

<tr>
<td><?php echo $matriz_resultados['folio_med']; ?></td>
<td><?php echo $matriz_resultados['correlativo']; ?></td>
<td><?php echo $matriz_resultados['dia']; ?></td>
<td><?php echo $matriz_resultados['mes']; ?></td>
<td><?php echo $matriz_resultados['anio']; ?></td>

<td>96964880</td>
<td>K</td>
<td><?php echo $matriz_resultados['rutdoc']; ?></td>
<td><?php echo $matriz_resultados['digdoc']; ?></td>
<td><?php echo $matriz_resultados['nom_medico']; ?></td>
<td><?php echo $matriz_resultados['ape_medico']; ?></td>
<td>1</td>
<td>Medicina General</td>

<td><?php echo $matriz_resultados['rut_titular']; ?></td>
<td><?php echo ValidaDVRut($matriz_resultados['rut_titular']);?></td>

<td><?php echo $matriz_resultados['nombre1_titu']; ?></td>

<td><?php echo $matriz_resultados['apellidos_titu']; ?></td>
<td><?php echo $matriz_resultados['nro_doc']; ?></td>
<td><?php echo ValidaDVRut($matriz_resultados['nro_doc']);?></td>


<?php
$separar = explode(' ',$matriz_resultados['paciente']);
?>


<td><?php echo $separar[0]; ?></td>
<td><?php echo $separar[2].' '.$separar[3]; ?></td>
<?php

$parentesco="SELECT parentesco.MED,glosa_parentesco,afiliados.cod_parentesco
from afiliados
inner join parentesco on afiliados.cod_parentesco = parentesco.cod_parentesco
WHERE afiliados.nro_doc  ='".$matriz_resultados['nro_doc']."'";


$parentesco_q = mysql_query($parentesco);
$parentesco_m = mysql_fetch_array($parentesco_q);

?>

<td><?php echo $parentesco_m['MED']; ?></td>
<td><?php echo $parentesco_m['glosa_parentesco']; ?></td>

<?php
$diag = "SELECT diagnosticos_medimel.cod_med, diagnosticos_medimel.glosa FROM
diagnosticos_medimel WHERE diagnosticos_medimel.remm= '".$matriz_resultados['diagnostico']."'";

$diag_q = mysql_query($diag);
$diag_m = mysql_fetch_array($diag_q);

?>

<td><?php echo $diag_m['cod_med'];?></td>
<td>&nbsp;<?php echo $diag_m['glosa']; ?></td>

<td><?php echo $matriz_resultados['cod_color']; ?></td>
<td><?php echo $matriz_resultados['color']; ?></td>

<?php
switch($matriz_resultados['isapre']){

case 2089:
$cod_isapre ='063';
$isapre ='FUSAT';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='1';
break;


case 96501450:
$cod_isapre ='070';
$isapre ='CRUZ BLANCA ';
$cobro = 'Bonos CB';
$cod_cobro ='1';
break;

case 123:
$cod_isapre ='092';
$isapre ='BANMEDICA';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 111:
$cod_isapre ='065';
$isapre ='CHUQUICAMATA';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 96856780:
$cod_isapre ='071';
$isapre ='CONSALUD';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 155:
$cod_isapre ='001';
$isapre ='FONASA';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 666:
$cod_isapre ='078';
$isapre ='ING';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 96522500:
$cod_isapre ='088';
$isapre ='MAS VIDA';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 17:
$cod_isapre ='080';
$isapre ='VIDA TRES';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

case 949540006:
$cod_isapre ='067';
$isapre ='COLMENA GOLDEN CROSS ';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;

default:
$cod_isapre ='000';
$isapre ='SIN ISAPRE  ';
$cobro = 'Boletas de Honorarios';
$cod_cobro ='2';
break;
}
?>


<td><?php echo $cod_isapre; ?></td>
<td><?php echo $isapre; ?></td>


<?php
switch($matriz_resultados['CentroHospitalario']){

case 25:
$cod_hos ='1';
$hos ='CLINICA ANTOFAGASTA';
break;

case 6:
$cod_hos ='2';
$hos ='CLINICA LA PORTADA';
break;

case 24:
$cod_hos ='3';
$hos ='HOSPITAL MILITAR DEL NORTE';
break;

case 13:
$cod_hos ='4';
$hos ='CLINICA UROLOGICA';
break;


case 22:
$cod_hos ='5';
$hos ='CLINICA DE LA MUJER';
break;

case 26:
$cod_hos ='6';
$hos ='HOSPITAL REGIONAL DE ANTOFAGASTA';
break;

default:
$cod_hos ='';
$hos ='';
break;
}
?>



<td>&nbsp;<?php echo $cod_hos; ?></td>
<td>&nbsp;<?php echo $hos; ?></td>

<td>&nbsp;<?php echo $cod_cobro; ?></td>
<td>&nbsp;<?php echo $cobro; ?></td>

<td><?php echo $matriz_resultados['boleta'];?></td>
<td>&nbsp;</td>
</tr>
<?php
}
?>
</table>
<?php
mysql_close($conexion);
?>
