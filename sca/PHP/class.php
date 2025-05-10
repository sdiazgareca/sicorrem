<?php


class Personal{

function GuardarEdicionPersonal($conexion){
$consulta = "update personal set nombre1='".$_GET['nombre1']."',nombre2='".$_GET['nombre2']."', apellidos='".$_GET['apellidos']."',rut='".$_GET['rut2']."',cargo='".$_GET['cargo']."', rut_1='".$_GET['rut_1']."', rut_d='".$_GET['rut_d']."' where rut='".$_GET['rut2']."'";

$resultados = mysql_query($consulta);
if ($resultados){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE1;
echo '</td></tr></table>';
}
mysql_close($conexion);
}

function EditarPersonal($conexion,$rutpersonal){
$consulta = "select rut_1,rut_d,rut,rut, nombre1, nombre2, apellidos, cargo.cargo as ncargo, cargo.cod as ccargo 
from personal inner join cargo on personal.cargo = cargo.cod 
where rut = '".$rutpersonal."'";

$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);
include('../Amb/EditarPersonal.php');
mysql_close($conexion);
}

function ListaEdiatrPersonal($conexion){

$consulta = "select nombre1, nombre2, apellidos, rut, cargo.cargo as cargo from personal inner join cargo on personal.cargo = cargo.cod";
$resultados = mysql_query($consulta);
echo '<table align="center" width="500px">';
include('../Amb/MuestraPersonal1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Amb/MuestraPersonal2.php');
}
echo '</table>';
mysql_close($conexion);
}

function CrearPersonal($conexion){
$consulta3 = "select rut from personal where rut = '".$_GET['rut2']."'";
$resultado3 = mysql_query($consulta3);
$num1 = mysql_num_rows($resultado3);
	
	if ($num1 > 0){
		echo '</table>';
		echo '<table width="500px" align="center"><tr><td  class="celda4">';
		echo 'El codigo del Personal ya se encuentra en la BD';
		echo '</td></tr></table>';
		exit;
		mysql_close($conexion);
	}

$consulta ="insert into personal(nombre1,nombre2,apellidos,rut,cargo,rut_1,rut_d) values ('".$_GET['nombre1']."','".$_GET['nombre2']."','".$_GET['apellidos']."','".$_GET['rut2']."','".$_GET['cargo']."','".$_GET['rut_1']."','".$_GET['rut_d']."')";
$resultados = mysql_query($consulta);
if ($resultados){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE1;
echo '</td></tr></table>';
}
mysql_close($conexion);
}
}

class Movil{
var $marca;
var $modelo;
var $chasis;
var $patente;
var $anio;

function GuardarMovilAsig($conexion){

$consulta = "insert into movilasig(numero,medico,paramedico,conductor) values ('".$_GET['movil']."','".$_GET['medico']."','".$_GET['paramedico']."','".$_GET['conductor']."')";
$resultados = mysql_query($consulta);
if ($resultados){
$consulta1 ="update personal set estado='1' where rut= '".$_GET['medico']."' and estado !=2";
$consulta2 ="update personal set estado='1' where rut= '".$_GET['paramedico']."' and estado !=2";
$consulta3 ="update personal set estado='1' where rut= '".$_GET['conductor']."'"; 
$consulta4 ="update movil set estado='1' where num= '".$_GET['movil']."'"; 

$resultados1 = mysql_query($consulta1);
$resultados2 = mysql_query($consulta2);
$resultados3 = mysql_query($consulta3);
$resultados4 = mysql_query($consulta4);
}
include('../Amb/AgregarMovil.php');
mysql_close($conexion);
}

function CancelarMovilAsig($conexion){
$consulta = "select * from movilasig where estado =1 and numero ='".$_GET['num']."'";
$resultados = mysql_query($consulta);
if (mysql_num_rows($resultados) < 1 ){

$consulta22 = "select medico,paramedico,conductor from movilasig where numero ='".$_GET['num']."'";
$resultados22 = mysql_query($consulta22);

while ($matriz_resultados22 = mysql_fetch_array($resultados22)){

$consulta1 ="update personal set estado='0' where rut= '".$matriz_resultados22['medico']."' and estado !=2";
$consulta2 ="update personal set estado='0' where rut= '".$matriz_resultados22['paramedico']."'";
$consulta3 ="update personal set estado='0' where rut= '".$matriz_resultados22['conductor']."'"; 
$consulta4 ="update movil set estado='0' where num= '".$_GET['num']."'";
$consulta5 ="delete from movilasig where numero = '".$_GET['num']."'"; 

$resultados1 = mysql_query($consulta1);
$resultados2 = mysql_query($consulta2);
$resultados3 = mysql_query($consulta3);
$resultados4 = mysql_query($consulta4);
$resultados5 = mysql_query($consulta5);

if (($resultados1)&&($resultados2)&&($resultados3)&&($resultados4)&&($resultados5)){
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE1;
echo '</td></tr></table>';
}
}
}
else{
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE6;
echo '</td></tr></table>';
}
mysql_close($conexion);
}

function GuardarEdicionMovil($conexion){
$consulta = "update movil set patente='".$_GET['patente']."',anio='".$_GET['anio']."',marca='".$_GET['marca']."',modelo='".$_GET['modelo']."',chasis='".$_GET['chasis']."' where num= '".$_GET['nmovil']."'";
$resultados = mysql_query($consulta);
if ($resultados){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE1;
echo '</td></tr></table>';
}
mysql_close($conexion);
}

function EditarMovil($conexion,$nmovil){
$consulta = "select patente, anio, marca, modelo, chasis, estado from movil where num = '".$nmovil."'";
$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Amb/EditarMovil.php');
}
mysql_close($conexion);
}

function ListaEdiatrMovil($conexion){

$consulta = "select num,patente, anio, marca, modelo, chasis, estado from movil order by num";
$resultados = mysql_query($consulta);

echo '<table align="center" width="500px">';
include('../Amb/MuestraAmbulancias1.php');

while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Amb/MuestraAmbulancias2.php');
}
echo '</table>';
mysql_close($conexion);
}

function GuardarMovil($conexion){

$consulta4= "select num from movil where num = '".$_GET['num']."'";
$resultados4 = mysql_query($consulta4);

$consulta3 = "select patente from movil where patente = '".strtoupper($_GET['patente'])."'";
$resultado3 = mysql_query($consulta3);


$num1 = mysql_num_rows($resultado3);
if ($num1 > 0){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE3;
echo '</td></tr></table>';
mysql_close($conexion);
exit;
}

/*
$num2 = mysql_num_rows($resultado4);
if ($num2 > 0){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE3;
echo '</td></tr></table>';
mysql_close($conexion);
exit;
}
*/

$consulta ="insert into movil(patente,anio,marca,modelo,chasis,estado,num,p_seguro) values ('".strtoupper($_GET['patente'])."','".$_GET['anio']."','".$_GET['marca']."','".$_GET['modelo']."','".$_GET['chasis']."','0','".$_GET['num']."','".$_GET['p_seguro']."')";

$resultados = mysql_query($consulta);
	
if ($resultados){
echo '</table>';
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo MENSAJE1;
echo '</td></tr></table>';
}
mysql_close($conexion);
}
}

class Afiliados{

var $nro_doc;var $nombre1;var $nombre2;var $apellido;var $desc_plan;var $cod_baja;var $fecha_nac;var $mot_baja;
	
function MuestraDatos($conexion){
sleep(2);
$consulta = "SELECT paciente,direccion,sector.sector,color.color,color.cod AS cod_color,fichas.nro_doc,
paciente,correlativo,movil,DATE_FORMAT(hora_llamado, '%H:%i') AS hora,DATE_FORMAT(hora_llamado, '%d/%m/%Y') AS dia 

FROM 
fichas 
INNER JOIN sector ON  fichas.sector = sector.cod
INNER JOIN color ON  fichas.color = color.cod
WHERE estado =1 GROUP BY movil";

//echo "<strong><br />".$consulta."<br /><strong>";

$resultados = mysql_query($consulta);
$men = 'Todos';
include('../Form/ListadoBusqueda1.php');

while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Form/ListadoBusqueda2.php');
}
echo '</table>'; //cierre de tabla
mysql_close($conexion);
}

function MuestraDatos1($conexion){
$men = 'Todos';

if ($_GET['num'] == 2){
$query = "where movil > 1000 and estado =1 group by movil ";
$men = 'En Espera';
}

if ($_GET['num'] == 3){
$query = "where movil < 1000 and estado =1 group by movil ";
$men = 'Movil Asignado';
}

if ($_GET['num'] == 4){
$query = "where color.cod = 1 and estado =1 group by movil ";
$men = 'Clave Rojo';
}

if ($_GET['num'] == 5){
$query = "where color.cod = 2 and estado =1 group by movil ";
$men = 'Clave Amarillo';
}

if ($_GET['num'] == 6){
$query = "where color.cod = 3 and estado =1 group by movil ";
$men = 'Clave Verde';
}
if ($_GET['num'] == 7){
$query = "where color.cod = 4 and estado =1 group by movil";
$men = 'Clave Azul';
}

$consulta = "SELECT apellido,nombre1,nombre2,direccion,sector.sector,color.color,color.cod as cod_color,fichas.nro_doc,paciente,correlativo,movil,DATE_FORMAT(hora_llamado, '%H:%i') as hora,DATE_FORMAT(hora_llamado, '%d/%m/%Y') as dia from 
fichas 
INNER JOIN sector on  fichas.sector = sector.cod
INNER join color on  fichas.color = color.cod
INNER join afiliados on fichas.nro_doc = afiliados.nro_doc $query";

$resultados = mysql_query($consulta);
include('../Form/ListadoBusqueda1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Form/ListadoBusqueda2.php');
}
echo '</table>'; //cierre de tabla
mysql_close($conexion);
}

function GuardarFicha($conexion,$telefono,$direccion,$rut){

$hora = date("Y-m-d-H:i:s");

$paciente = $_GET['paciente'];
$pac = strip_tags($paciente);

$sintoma = $_GET['sintomas'];

$pizza  = $sintoma;
$trozos = explode("-", $pizza);


$con ="select max(correlativo) as maximo from fichas";
$res = mysql_query($con);
$mat = mysql_fetch_array($res);
$correlativo =$mat['maximo'];
$correlativo = $correlativo + 1;

for($i=0;$i< count($trozos);$i++){
if ($trozos[$i] > 0){
    $rutTem = (empty($_GET['rut'])) ? 0 : $_GET['rut'];  
$query ="insert into sintomas_reg(sintoma,rut,correlativo) values ('".$trozos[$i]."','".$rutTem."','".$correlativo."')";
$res = mysql_query($query);
}
}

$_GET['rut'] = (empty($_GET['rut'])) ? 0 : "'".$_GET['rut']."'";
$_GET['ncontrato'] = (empty($_GET['ncontrato'])) ? 0 : "'".$_GET['ncontrato']."'";
$_GET['isapren'] = (empty($_GET['isapren']) || $_GET['isapren'] == 'PA') ? 0 : "'".$_GET['isapren']."'";
$_GET['autorizacion'] = (empty($_GET['autorizacion'])) ? 0 : "'".$_GET['autorizacion']."'";

$consulta ="insert into fichas(correlativo,telefono,direccion,entre,movil,color,sector,observacion,hora_llamado,num_solici,celular,edad,paciente, nro_doc,operador,autorizacion,cod_plan,tipo_plan,isapre) values 
('".$correlativo."','".$_GET['telefono']."',  '".$_GET['direccion']."',  '".$_GET['entre']."', '".$_GET['movil']."',  '".$_GET['color']."',  '".$_GET['sector']."',  '".$_GET['observacion']."','".$hora."',".$_GET['ncontrato'].",'".$_GET['numcelular']."','".$_GET['edad']."','".$pac."',".$_GET['rut'].",'".$_GET['operador']."',".$_GET['autorizacion'].",'".$_GET['cod_plann']."','".$_GET['tipo_plann']."',".$_GET['isapren'].")";

//echo $consulta;


if ($_GET['movil'] >= 1000){
$query = "update movil_espera set  estado='1' where cod='".$_GET['movil']."'"; 
$query2 = mysql_query($query);
}

$resultados = mysql_query($consulta);
if ($resultados){
$coonsulta2="update movilasig set  estado='1' where numero='".$_GET['movil']."'";
$resultados2 = mysql_query($coonsulta2);
echo MENSAJE1;
}
mysql_close($conexion);
}

function BuscarRut($conexion,$mensaje1,$rut,$num_solici){

$consulta = "SELECT
    afiliados.num_solici,
    afiliados.nro_doc,
    nombre1,nombre2,
    apellido,
    mot_baja.descripcion AS descripcion1,
    mot_baja.codigo AS codigo,
    categoria.descripcion AS descripcion2,
    tipo_plan.tipo_plan_desc,
    tipo_plan.tipo_plan,
    planes.cod_plan,
    planes.tipo_plan,
    cm_gratis,
    empresa.empresa,
    planes.copago,
    planes.casa_p, planes.cm_gratis,
    reducido, planes.desc_plan,afiliados.titular,(YEAR(CURRENT_DATE)-YEAR(fecha_nac)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fecha_nac,5)) AS edad,planes.cod_plan,obras_soc.nro_doc AS isapre
FROM afiliados
LEFT JOIN mot_baja ON afiliados.cod_baja = mot_baja.codigo
LEFT JOIN categoria ON afiliados.categoria = categoria.categoria
LEFT JOIN tipo_plan ON afiliados.tipo_plan = tipo_plan.tipo_plan
LEFT JOIN obras_soc ON afiliados.obra_numero = obras_soc.nro_doc
LEFT JOIN planes ON afiliados.cod_plan = planes.cod_plan AND afiliados.tipo_plan = planes.tipo_plan
LEFT JOIN contratos ON contratos.num_solici = afiliados.num_solici AND contratos.titular = afiliados.titular
LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
where afiliados.nro_doc ='".$rut."' AND afiliados.num_solici='".$num_solici."'";

//echo $consulta;


$resultados = mysql_query($consulta);
$nbd = mysql_num_rows($resultados);

if ($nbd < 1){
    echo MENSAJE2;
    exit;
}

$matriz_resultados = mysql_fetch_array($resultados);
$rutt =$matriz_resultados['nro_doc'];
include('../Form/AgregarFicha.php');		
mysql_close($conexion);

}

function BuscarRut301($conexion,$mensaje1,$rut){
$consulta = "select afiliados.num_solici,afiliados.nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo as codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,tipo_plan.tipo_plan,reducido, planes.desc_plan,titular,(YEAR(CURRENT_DATE)-YEAR(fecha_nac)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fecha_nac,5)) as edad,planes.cod_plan,obras_soc.nro_doc as isapre
from afiliados
LEFT join mot_baja on afiliados.cod_baja = mot_baja.codigo
LEFT join categoria on afiliados.categoria = categoria.categoria
LEFT join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
LEFT join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
LEFT join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where afiliados.nro_doc ='".$rut."'";

$resultados = mysql_query($consulta);
$nbd = mysql_num_rows($resultados);
if ($nbd < 1){
echo MENSAJE2;
exit;
}

/*
$matriz_resultados = mysql_fetch_array($resultados);
$rutt =$matriz_resultados['nro_doc'];
include('../Form/AgregarFicha.php');
mysql_close($conexion);
*/

include('../Form/AgregarMovil1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){

include('../Form/AgregarMovil12.php');

}
echo '</table>';

mysql_close($conexion);

}


function BuscarNrContrato($conexion,$mensaje1,$rut){
$consulta = "select afiliados.num_solici,afiliados.nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo as codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,tipo_plan.tipo_plan,reducido, planes.desc_plan,titular,(YEAR(CURRENT_DATE)-YEAR(fecha_nac)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fecha_nac,5)) as edad,planes.cod_plan,obras_soc.nro_doc as isapre
from afiliados 
LEFT join mot_baja on afiliados.cod_baja = mot_baja.codigo 
LEFT join categoria on afiliados.categoria = categoria.categoria
LEFT join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
LEFT join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
LEFT join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where afiliados.num_solici ='".$rut."'";
		
$resultados = mysql_query($consulta);
$nbd = mysql_num_rows($resultados);
if ($nbd < 1){
echo MENSAJE2;
exit;
}
/*
$matriz_resultados = mysql_fetch_array($resultados);
$rutt =$matriz_resultados['nro_doc'];
include('../Form/AgregarFicha.php');		
mysql_close($conexion);
 */

include('../Form/AgregarMovil1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){

include('../Form/AgregarMovil12.php');

}
echo '</table>';

mysql_close($conexion);

}
	
function BuscarNombre($conexion,$mensaje1,$nombre){
$consulta = "select afiliados.num_solici,afiliados.nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,reducido, planes.desc_plan,titular,planes.cod_plan,obras_soc.nro_doc as isapre
from afiliados 
LEFT join mot_baja on afiliados.cod_baja = mot_baja.codigo 
LEFT join categoria on afiliados.categoria = categoria.categoria
LEFT join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
LEFT join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
LEFT join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where $nombre";

$resultados = mysql_query($consulta);
$nbd = mysql_num_rows($resultados);
if ($nbd < 1){
echo MENSAJE2;
exit;
} 
include('../Form/AgregarMovil1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){

include('../Form/AgregarMovil12.php');

}
echo '</table>';

mysql_close($conexion);
}

function MuestraCargas($conexion,$grupo_nd){
//$grupo_nd = $_GET['grupo_nd'];

$consulta = "select num_solici,afiliados.nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,reducido, planes.desc_plan,titular
from afiliados 
inner join mot_baja on afiliados.cod_baja = mot_baja.codigo 
inner join categoria on afiliados.categoria = categoria.categoria
inner join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
inner join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
inner join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where afiliados.num_solici ='".$grupo_nd."'";
$resultados = mysql_query($consulta);
$nbd = mysql_num_rows($resultados);
if ($nbd < 1){
echo "<div><strong>EL AFILIADO NO REGISTRA CARGAS</strong></div>";
exit;
}
include('../Form/AgregarMovil1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){

include('../Form/AgregarMovil12.php');

}
echo '</table>';
mysql_close($conexion);
}
}

?>
