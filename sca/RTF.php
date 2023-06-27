<?PHP

include('conf.php');
include('bd.php');

$con = "select afiliados.grupo_nd,obras_soc.descripcion,color.color,fichas.celular,fichas.telefono,glosa_parentesco,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y') as hora_llamado,correlativo,fichas.nro_doc,paciente,diagnostico.diagnostico 
from fichas 
inner join diagnostico on diagnostico.cod = fichas.diagnostico
inner join afiliados on afiliados.nro_doc = fichas.nro_doc
inner join parentesco on parentesco.cod_parentesco = afiliados.cod_parentesco
inner join color on color.cod = fichas.color
inner join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
where fichas.cod_plan = 'W71' and DATE_FORMAT(hora_llegada_domicilio,'%Y') = ".$_GET['anio']." and DATE_FORMAT(hora_llegada_domicilio,'%m') = '".$_GET['mes']."' ";

$resultados2 = mysql_query($con);

header('Content-type: application/msword');
header('Content-Disposition: inline; filename=ejemplo.rtf'); 
$output="{\\rtf1{\fonttbl{\f0 Arial;}}";   
while($matriz_resultados2 = mysql_fetch_array($resultados2)){


$output.= "{\\b\fs17 ReMM}";
$output.= "\\par ";
$output.= "{\\b\fs17 RESCATE MEDICO MOVIL}";

$output.= "\\par ";

$output.= "{\\fs20\\uc1\qc\b\
FOLIO N\'ba ".$matriz_resultados2['correlativo']."  \par\par}"; //<-- Texto de tamaño 30 para el Subtítulo

$output.= "{\\fs25\\qc\b\
FORMULARIO DE ATENCION PACIENTES MEDIMEL \par\par}"; //<-- Texto de tamaño 30 para el Subtítulo      


$output.= "{\\fs18\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\b\ N\'ba FICHA DE ATENCION: ".$matriz_resultados2['correlativo']."}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER       

$output.= "{\\fs18\\b\ FECHA ".$matriz_resultados2['hora_llamado']."}";
$output.= "{\\fs18\\tab\\tab\\tab\\tab\\tab\\b\ ISAPRE: ".$matriz_resultados2['descripcion']."}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$con2 = "select nro_doc,nombre1,apellido from afiliados where cod_parentesco = '100' and grupo_nd = '".$matriz_resultados2['grupo_nd']."'";
$resultado = mysql_query($con2);
$matriz_resultados3 = mysql_fetch_array($resultado);

$output.= "{\\fs20\\b\ Nombre Titular \\tab\\tab : ".$matriz_resultados3['nombre1'].' '.$matriz_resultados3['apellido']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ RUT Titular \\tab\\tab\\tab : ".$matriz_resultados3['nro_doc']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Nombre Paciente \\tab\\tab : ".$matriz_resultados2['paciente']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ RUT Paciente \\tab\\tab\\tab : ".$matriz_resultados2['nro_doc']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Parentesco Paciente \\tab\\tab : ".$matriz_resultados2['glosa_parentesco']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Fono \\tab\\tab\\tab\\tab : ".$matriz_resultados2['telefono']."\\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Celular \\tab\\tab\\tab : ".$matriz_resultados2['celular']."\\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Diagnostico \\tab\\tab\\tab : ".$matriz_resultados2['diagnostico']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER

$output.= "{\\fs20\\b\ Tipo de Atenci\'f3\ n \\tab\\tab : ".$matriz_resultados2['color']." \\tab}";
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
}
$output.="}";
echo $output;
mysql_close($conexion);
?>