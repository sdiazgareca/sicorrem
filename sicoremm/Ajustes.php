<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include('DAT/conf.php');
include('DAT/bd.php');

$sql ="SELECT contratos.titular, contratos.num_solici, cta.importe, contratos.f_ingreso, valor_plan.valor, ( cta.importe - valor_plan.valor) AS Ajuste
FROM contratos
INNER JOIN cta ON cta.num_solici = contratos.num_solici AND cta.nro_doc = contratos.titular
INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND contratos.secuencia = valor_plan.secuencia
WHERE cta.fecha_mov='2011-04-01' GROUP BY num_solici, titular";

$query = mysql_query($sql);

echo '<table>';

    echo '<tr>';
    echo '<th>TITULAR</th>';
    echo '<th>CONTRATO</th>';
    echo '<th>CTA</th>';
    echo '<th>F_INGRESO</th>';
    echo '<th>V PLAN</th>';
    echo '<th>AJUSTE</th>';
    echo '<th>ESTADO</th>';
    echo '<th>N AJUSTE</th>';
    echo '</tr>';

while ($sec = mysql_fetch_array($query)){
    echo '<tr>';
    echo '<td>'.$sec['titular'].'</td>';
    echo '<td>'.$sec['num_solici'].'</td>';
    echo '<td>'.$sec['importe'].'</td>';
    echo '<td>'.$sec['f_ingreso'].'</td>';
    echo '<td>'.$sec['valor'].'</td>';
    echo '<td>'.$sec['Ajuste'].'</td>';

    $ajuste_c = round( ($sec['valor'] * 10 /100),-2);

    if (  ($ajuste_c == $sec['Ajuste'])  || ($sec['Ajuste'] < 1)  ){
        echo '<td>OK</td>';

        $corr ="UPDATE contratos SET ajuste='".$sec['Ajuste']."' WHERE num_solici='".$sec['num_solici']."' AND titular='".$sec['titular']."'";
        $corr_q = mysql_query($corr);
    }

    else{
        echo '<td>:(</td>';
    }

    echo '<td>'.$ajuste_c.'</td>';

    echo '</tr>';



}
echo '</table>';
?>
