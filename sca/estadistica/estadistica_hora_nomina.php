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


$sql ="SELECT fichas.correlativo,fichas.num_solici,destino.destino,color.color,sector.sector,copago.importe,
     planes.desc_plan, fichas.tipo_plan,planes_traslados.desc_plan AS tras,diagnostico.diagnostico,
     CONCAT(personal.nombre1,' ',personal.apellidos) as medico,TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) AS t_respuesta,time(hora_llamado) as hora_llamado, DATE(hora_llamado) AS fecha_llamado,
     TIME(hora_llegada_domicilio) as hora_llegada_domicilio, DATE(hora_llegada_domicilio) as fecha_llega
FROM fichas
LEFT JOIN destino ON destino.cod=fichas.obser_man
LEFT JOIN color ON color.cod = fichas.color
LEFT JOIN sector ON sector.cod = fichas.sector
LEFT JOIN copago ON copago.protocolo = fichas.correlativo
LEFT JOIN planes ON planes.cod_plan = fichas.cod_plan AND fichas.tipo_plan = planes.tipo_plan


LEFT JOIN traslados ON traslados.cod = fichas.traslado
LEFT JOIN traslado_tipo ON traslado_tipo.cod = traslados.tipo_traslado
LEFT JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio


LEFT JOIN personal ON personal.rut = fichas.medico

LEFT JOIN diagnostico ON diagnostico.cod = fichas.diagnostico


WHERE fichas.estado =0 AND 
DATE(fichas.hora_llamado) BETWEEN '".$fecha_del."' AND '".$fecha_al."' AND 
TIME(fichas.hora_llamado) BETWEEN '".$horaentre."' AND '".$horaenlas."'";



//echo $sql;



$query = mysql_query($sql);

echo '<table border="1" style="font-size:10px">';

    echo '<tr>
        <th>N</th>
        <th>PROTOCOLO</th>
        <th>CONTRATO</th>
        <th>DESTINO</th>
        <th>CODIGO</th>
        <th>SECTOR</th>
        <th>PLAN</th>
        <th>TIPO_PLAN</th>
        <th>DIAGNOSTICO</th>
        <th>MEDICO</th>
        <th>FECHA LLAMADO</th> 
        <th>HORA LLAMADO</th>
 
        <th>FECHA LLEGA A DOMI</th>            
        <th>HORA LLEGA A DOMI</th> 
            
        <th>T RESPUESTA</th>
        <th>COPAGO</th></tr>';


$N=1;

while ($q = mysql_fetch_array($query)){   

      if($q['desc_plan'] == ""){
            @$salida['desc_plan'] = $salida['tras'];
        }
    
    
    echo '<tr>
        <td>'.$N.'</td>
        <td>'.$q['correlativo'].'</td>
        <td>'.$q['num_solici'].'</td>
        <td>'.$q['destino'].'</td>
        <td>'.$q['color'].'</td>
        <td>'.$q['sector'].'</td>
        <td>'.$q['desc_plan'].'</td>
        <td>'.$q['tipo_plan'].'</td>
        <td>'.$q['diagnostico'].'</td>
        <td>'.$q['medico'].'</td>
        <td>'.$q['fecha_llamado'].'</td> 
        <td>'.$q['hora_llamado'].'</td>

        <td>'.$q['fecha_llega'].'</td>            
        <td>'.$q['hora_llegada_domicilio'].'</td> 
              
        <td>'.$q['t_respuesta'].'</td>
        <td>'.$q['importe'].'</td></tr>';
    
        $N ++;
    
}
echo '</table>';
?>
