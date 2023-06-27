<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=estadistica.xls");


error_reporting(E_ALL);
ini_set("display_errors", 1);
include('../conf.php');
include('../bd.php');

$f_del = explode("-",$_GET['f_del']);
$fecha_del = $f_del[2].'-'.$f_del[1].'-'.$f_del[0];

$f_al = explode("-",$_GET['f_al']);
$fecha_al = $f_al[2].'-'.$f_al[1].'-'.$f_al[0];

$vaalida_fecha_al = checkdate($f_al[1], $f_al[0], $f_al[2]);
$vaalida_fecha_del = checkdate($f_del[1], $f_del[0], $f_del[2]);

if ($vaalida_fecha_al != true || $vaalida_fecha_del!=true){
    
    echo 'Error fechas no validas';
    exit;
    
} 
$TOTAL=0;
$horaentre = $_GET['H_ENTRE'].':'.$_GET['M_ENTRE'].':00';
$horaenlas = $_GET['H_AL'].':'.$_GET['H_AL'].':00';


echo '<h2>CONSULTA DESDE EL '.$_GET['f_del'].' AL '.$_GET['f_al'].' ENTRE LAS '.$horaentre.' Y LAS '.$horaenlas.'</h2>';


$sql ="SELECT COUNT(fichas.correlativo) AS total,destino.destino as descripcion
FROM fichas
INNER JOIN destino ON destino.cod=fichas.obser_man
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
GROUP BY destino.cod";

$query = mysql_query($sql);

echo '<h3>RESUMEN DE LLAMADOS</h3>';

echo '<br />';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";

echo '<h3>ATENCIONES REALIZADAS</h3>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////



$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, color.color as descripcion
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY color.cod";
//echo $sql;
$query = mysql_query($sql);


echo '<br /><div style="font-size:15px; font-weight:bold">Resumen C&oacute;digos de Llamados</div>';
echo "<table border=“1” style=“font-size:10px”>";

    

    while($salida = mysql_fetch_array($query)){
    
    echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, color.color as descripcion,destino.destino
FROM fichas
INNER JOIN color ON color.cod = fichas.color
INNER JOIN destino ON destino.cod=fichas.obser_man
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY color.cod,destino.cod";
//echo $sql;
$query = mysql_query($sql);


echo '<div style="font-size:15px; font-weight:bold">Resumen C&oacute;digos de Llamados y Destino</div>';
echo "<table border=“1” style=“font-size:10px”>";

    

    while($salida = mysql_fetch_array($query)){
    
    echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td><td>".$salida['destino']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td><yd></td></tr>"; 
echo "</table>";



//////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<br />';
$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, sector.sector as descripcion
FROM fichas
INNER JOIN sector ON sector.cod = fichas.sector
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY fichas.sector";

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen  de Atenci&oacute;n por Sectores</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";













//////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<br />';
$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, sector.sector as descripcion,color.color
FROM fichas
INNER JOIN sector ON sector.cod = fichas.sector
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY fichas.sector,color.cod";

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen  de Atenci&oacute;n por Sectores</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td><td>".$salida['color']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td><td></td></tr>"; 
echo "</table>";


//////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo '<br />';
$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, copago.importe as descripcion
FROM fichas
INNER JOIN copago ON copago.protocolo = fichas.correlativo
WHERE estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY copago.importe";

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen  de Atenci&oacute;nes por valor del Copago</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";





//////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<br />';
$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, planes.desc_plan as descripcion, fichas.tipo_plan 
FROM fichas
LEFT JOIN planes ON planes.cod_plan = fichas.cod_plan AND fichas.tipo_plan = planes.tipo_plan
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY fichas.cod_plan, fichas.tipo_plan";
//echo '<br /><strong>'.$sql.'</strong><br />';
$query = mysql_query($sql);


echo '<div style="font-size:15px; font-weight:bold">Resumen por Planes (Atenciones Realizadas)</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        
         if($salida['descripcion'] == ""){
            $salida['descripcion'] = $salida['tipo_plan'];
        }
        
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";    







///////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<br />';
$TOTAL =0;

$sql ="SELECT COUNT(fichas.correlativo) AS total, tipo_plan.tipo_plan_desc as descripcion, fichas.tipo_plan 
FROM fichas
LEFT JOIN tipo_plan ON tipo_plan.tipo_plan = fichas.tipo_plan
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY fichas.tipo_plan";
//echo '<br /><strong>'.$sql.'</strong><br />';
$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen por Planes (Atenciones Realizadas)</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        
         if($salida['descripcion'] == ""){
            $salida['descripcion'] = $salida['tipo_plan'];
        }
        
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";  


////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<br />';
$TOTAL=0;

echo '<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Traslados (Atenciones Realizadas)</td>';

$consulta = "SELECT COUNT(traslados.convenio) as total, planes_traslados.desc_plan as tras
FROM fichas
INNER JOIN traslados ON traslados.cod = fichas.traslado
INNER JOIN traslado_tipo ON traslado_tipo.cod = traslados.tipo_traslado
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE fichas.estado =0 AND  
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY traslados.convenio";

$consulta_q = mysql_query($consulta);

echo '<table border=“1” style=“font-size:10px”>';

while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){

echo'<tr>';
echo '<td>'.strtoupper($matriz_resultados['tras']).'</td>';
echo '<td>'.strtoupper($matriz_resultados['total']).'</td>';
echo '</tr>';
$TOTAL = $matriz_resultados['total'] + $TOTAL;
}
echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo '</table>';








///////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<br />';
$TOTAL =0;


$sql ="SELECT COUNT(fichas.correlativo) AS total, CONCAT(personal.nombre1,' ',personal.apellidos) as descripcion
FROM fichas
INNER JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')    
GROUP BY personal.rut";

//echo $sql;

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Médico (Atenciones Realizadas)</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";





///////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<br />';
$TOTAL =0;


$sql ="SELECT COUNT(fichas.correlativo) AS total, CONCAT(personal.nombre1,' ',personal.apellidos) as descripcion
FROM fichas
LEFT JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
AND CONCAT(cod_plan,tipo_plan)='W712'
GROUP BY fichas.medico";

//echo $sql;

$query = mysql_query($sql);


echo '<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Medico y Codigo Convenio Medimel (Atenciones Realizadas)</div>';
echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";







///////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<br />';
$TOTAL =0;


$sql ="SELECT COUNT(fichas.correlativo) AS total, CONCAT(personal.nombre1,' ',personal.apellidos) as descripcion
FROM fichas
LEFT JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
AND CONCAT(cod_plan,tipo_plan)!='W712'
GROUP BY fichas.medico";

//echo $sql;

$query = mysql_query($sql);

echo'<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Médico REMM (Atenciones Realizadas)</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";

























///////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<br />';
$TOTAL =0;


$sql ="SELECT COUNT(fichas.correlativo) AS total, diagnostico.diagnostico as descripcion
FROM fichas
LEFT JOIN diagnostico ON diagnostico.cod = fichas.diagnostico
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY fichas.diagnostico";

//echo $sql;

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Diagnostico (Atenciones Realizadas)</div>';

echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";









echo '<br />';
$TOTAL =0;


$sql ="SELECT COUNT(sintomas.cod) AS total, sintomas.sintoma as descripcion
FROM fichas
INNER JOIN sintomas_reg ON sintomas_reg.correlativo= fichas.correlativo
INNER JOIN sintomas ON sintomas_reg.sintoma = sintomas.cod
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY sintomas.sintoma";

//echo $sql;

$query = mysql_query($sql);

echo '<div style="font-size:15px; font-weight:bold">Resumen de Llamados por Sintoma (Atenciones Realizadas)</div>';


echo "<table border=“1” style=“font-size:10px”>";

    while($salida = mysql_fetch_array($query)){
        echo "<tr><td>".$salida['descripcion']."</td><td>".$salida['total']."</td></tr>";   
        $TOTAL = $salida['total'] + $TOTAL;
    }
    
    
    echo "<tr><td><strong>TOTAL</strong></td><td><trong>".$TOTAL."</strong></td></tr>"; 
echo "</table>";













$TOTAL = 0;


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$hh = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0 AND  
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) > '02:00:00' AND CONCAT(cod_plan,tipo_plan)!='W712'";
$cc = mysql_query($hh);
$TRM2REMM = mysql_fetch_array($cc);

$TOTAL = $TOTAL + $TRM2REMM['t_respuesta'];

echo '<br />';
echo '<strong style="font-size:14px;">Tiempos de Respuesta</strong>';
echo '<table border=“1” style=“font-size:10px”>';
echo '<tr>';
echo '<td>Mayores a las 2 horas REMM</td><td>'.$TRM2REMM['t_respuesta'].'</td>';
echo '</tr>';


$hh2 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' 
AND TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) < '02:00:00' AND CONCAT(cod_plan,tipo_plan)!='W712'";
//echo $hh2;
$cc2 = mysql_query($hh2);
$TRM2REMM_M = mysql_fetch_array($cc2);

$TOTAL = $TOTAL + $TRM2REMM_M['t_respuesta'];

echo '<tr>';
echo '<td>Menores a las 2 horas REMM<td>'.$TRM2REMM_M['t_respuesta'].'</td>';
echo '</tr>';










$hh3 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0 AND  
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'
AND TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) > '02:00:00' AND CONCAT(cod_plan,tipo_plan)='W712'";
$cc3 = mysql_query($hh3);
$TRM3 = mysql_fetch_array($cc3);


$TOTAL = $TOTAL + $TRM3['t_respuesta'];
echo '<tr>';
echo '<td>Mayores a las 2 horas MEDIMEL</td><td>'.$TRM3['t_respuesta'].'</td>';
echo '</tr>';


$hh4 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' 
AND TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) < '02:00:00' AND CONCAT(cod_plan,tipo_plan)='W712'";
//echo $hh2;
$cc4 = mysql_query($hh4);
$TRM_M = mysql_fetch_array($cc4);

$TOTAL = $TOTAL + $TRM_M['t_respuesta'];

echo '<tr>';
echo '<td>Menores a las 2 horas MEDIMEL<td>'.$TRM_M['t_respuesta'].'</td>';
echo '</tr>';

echo '<tr>';
echo '<td><strong>TOTAL</strong><td>'.$TOTAL.'</td>';
echo '</tr>';


echo '</table>';






















echo '</table>';

?>
