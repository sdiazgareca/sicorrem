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
<td>CODIGO ESPECIALIDAD</td>
<td>ESPECIALIDAD TRATANTE</td>
<td>RUT_TITULAR</td>
<td>DV_TITULAR</td>
<td>NOMBRE TITULAR</td>
<td>RUT_PACIENTE</td>
<td>DV_PACIENTE</td>
<td>NOMBRE_PACIENTE</td>
<td>CODIGO PARENTESCO</td>
<td>DESCRIPCION PARENTESCO</td>
<td>CIE 10</td>
<td>GLOSA CIE</td>
<td>COD REMM</td>
<td>CODIGO TIPO DE ATENCION</td>
<td>TIPO DE ATENCION</td>
<td>CODIGO INSTITUCION PREVISIONAL</td>
<td>DESCRIPCION INSTITUCION PREVISIONAL</td>
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

fichas.medico as medico,
fichas.nro_doc,
fichas.destino,
fichas.correlativo,
fichas.paciente,
fichas.correlativo,
fichas.paramedico,
fichas.conductor,
fichas.movil,
fichas.observacion,
fichas.tipo_plan,
fichas.cod_plan,
fichas.CentroHospitalario,
color.cod as cod_color,
color.color,
sector.sector,
diagnostico,
personal.rut_1,
personal.rut_d,
glosa,
cod_med

FROM fichas
LEFT JOIN diagnosticos_medimel on  CONVERT(fichas.diagnostico using utf8) = convert(remm using utf8)
INNER JOIN personal on fichas.medico = personal.rut
INNER JOIN color ON fichas.color=color.cod
INNER JOIN sector ON sector.cod=fichas.sector where cod_plan='W71'
and (obser_man = 24 ||  obser_man = 42 || obser_man = 45) and fichas.estado=0  AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."' ".' '.$dia." order by nro_doc";


$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>

<tr>
<td><?php echo $boleta_m['boleta']; ?></td>
<td><?php echo $matriz_resultados['correlativo']; ?></td>
<td><?php echo $matriz_resultados['dia']; ?></td>
<td><?php echo $matriz_resultados['mes']; ?></td>
<td><?php echo $matriz_resultados['anio']; ?></td>

<td>96964880</td>
<td>K</td>
<td>&nbsp;<?php echo $matriz_resultados['rut_1']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['rut_d']; ?></td>

<td>1</td>
<td>Medicina General</td>


<?php
$titular="select obras_soc.nro_doc as cod_isa,descripcion,nombre1,titular
from afiliados
inner join fichas on fichas.nro_doc = afiliados.nro_doc and fichas.nro_doc='".$matriz_resultados['nro_doc']."'  and afiliados.cod_plan ='W71'
INNER JOIN obras_soc ON afiliados.obra_numero = obras_soc.nro_doc";
$titular_q = mysql_query($titular);
$titular_n = mysql_num_rows($medicos_q);
$titular_m = mysql_fetch_array($titular_q);
?>
<td><?php echo $titular_m['grupo_nd']; ?></td>
<td><?php echo ValidaDVRut($titular_m['grupo_nd']);?></td>
<td><?php echo $titular_m['nombre1']; ?></td>


<td><?php echo $matriz_resultados['nro_doc']; ?></td>
<td><?php echo ValidaDVRut($matriz_resultados['nro_doc']);?></td>


<?php
$separar = explode(' ',$matriz_resultados['paciente']);
?>


<td><?php echo $separar[0]; ?></td>

<?php
$parentesco="select parentesco.cod_parentesco,glosa_parentesco
from afiliados
inner join parentesco on afiliados.cod_parentesco = parentesco.cod_parentesco
and afiliados.nro_doc ='".$matriz_resultados['nro_doc']."' and afiliados.cod_plan ='W71'";

$parentesco_q = mysql_query($parentesco);
$parentesco_m = mysql_fetch_array($parentesco_q);

$parent = $parentesco_m['cod_parentesco'];

switch($parent){

case 100:
$parent1 = 1;
break;

case 200:
$parent1 = 2;
break;

case 300:
$parent1 = 5;
break;

case 400:
$parent1 = 6;
break;

case 500:
$parent1 = 8;
break;

case 600:
$parent1 = 3;
break;
}

?>

<td><?php echo $parent1; ?></td>
<td><?php echo $parentesco_m['glosa_parentesco']; ?></td>

<td>&nbsp;<?php echo $matriz_resultados['cod_med'];?></td>
<td>&nbsp;<?php echo $matriz_resultados['glosa'];?></td>
<td>&nbsp;<?php echo $matriz_resultados['diagnostico'];?></td>

<td><?php echo $matriz_resultados['cod_color']; ?></td>
<td><?php echo $matriz_resultados['color']; ?></td>

<?php
switch($titular_m['cod_isa']){

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

case 968567802:
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

case 0:
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

<?php
$boleta = "select boleta,importe from fichas inner join copago on copago.protocolo = fichas.correlativo and fichas.correlativo ='".$matriz_resultados['correlativo']."'";

$boleta_q = mysql_query($boleta);
$boleta_m = mysql_fetch_array($boleta_q);
?>


<td>&nbsp;<?php
if($boleta_m['importe'] > 0){
echo $boleta_m['importe'];
}
?></td>
<td>&nbsp;</td>
</tr>
<?php
}
?>
</table>
<?php
mysql_close($conexion);
?>
