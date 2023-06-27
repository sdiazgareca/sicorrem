<table style=" width:480px; background-color:#FFCC00; border-bottom:none;">
<tr>
<td class="celda3" style="background-color:#FFCC00;">
<?php

echo 'Atenciones Anuales: '.$atencion_mat['cantidad'];
?>
</td>
<td class="celda3" style="background-color:#FFCC00;">
<?php
echo 'Atenciones en este mes: '.$atencion_mat_m['cantidad'];
?>
</td>
<td class="celda3" style="background-color:#FFCC00;">
<?php

echo 'Copagos pendientes: '.$deuda_query_m['cantidad'];

?>
</td>
</tr>
</table>
<br />
<?php



if( $matriz_resultados['cod_plan'] != 'PA' && $matriz_resultados['cod_plan'] != 'TRA_PAR' && $matriz_resultados['cod_plan'] != 'TRA_CONV' && $matriz_resultados['cod_plan'] != 'TRA_ME' ){
echo '<br />';
echo'<table style=" width: 450px;">';
echo '<tr>';
echo '<td>CASA PROTEGIDA</td><td>'.$matriz_resultados['casa_p'].'</td>';

if($matriz_resultados['tiempo'] != 'NO'){
    $tiempo = $matriz_resultados['tiempo'];
}
else{
    $tiempo ="";
}


echo '<td>ATENCIONES SIN COPAGO</td><td>'.$matriz_resultados['cm_gratis'].' '.$tiempo.'</td>';
echo '<td>VALOR</td><td>'.number_format($matriz_resultados['copago'],0,',','.').'</td>';
echo '</tr>';
echo '</table>';
echo '<br />';
}
?>