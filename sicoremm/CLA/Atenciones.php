<?php
class Atenciones {

    function MuestraAtencionesEditaPago($num_solici){

$i =0;

$aten_sql ="SELECT copago.rendicion,DATE_FORMAT(f_pago,'%d-%m-%Y') AS f_pago,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y  %H:%m') AS h_aten, correlativo,num_solici,
            paciente, destino.destino, tipo_pago.tipo_pago, copago.tipo_pago as cod_tipo_pago,boleta,copago.cobrador
            FROM fichas
            INNER JOIN copago ON copago.protocolo = fichas.correlativo
            INNER JOIN tipo_pago ON tipo_pago.cod = copago.tipo_pago
            INNER JOIN destino ON destino.cod = fichas.obser_man
            WHERE fichas.num_solici='".$num_solici."' AND copago.numero_socio='".$num_solici."' AND (destino.cod='24' || destino.cod='42') GROUP BY fichas.correlativo";

$query2 = mysql_query($aten_sql);

$cont = 1;
while ($aten = mysql_fetch_array($query2)){

    echo '<div class="mensaje1">';
    echo '<table class="table2">';
    echo '<tr>';
    echo '<th><strong>PROT</strong></th>';
    echo '<th><strong>BOLE</strong></th>';
    echo '<th><strong>FECHA ATEN</strong></th>';
    echo '<th><strong>PACIENTE</strong></th>';
    echo '<th><strong>DESC</strong></th>';
    echo '<th><strong>TIPO_PAGO</strong></th>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>'.$aten['correlativo'].'</td>';
    echo '<td>'.$aten['boleta'].'</td>';
    echo '<td>'.$aten['h_aten'].'</td>';
    echo '<td>'.$aten['paciente'].'</td>';
    echo '<td>'.$aten['destino'].'</td>';
    echo '<td>'.$aten['tipo_pago'].'</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '<br />';
    ?>

    <script type="text/javascript">
$(document).ready(function() {


$('#form<?php echo $i; ?>').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

});

</script>

    <?php

    echo '<form action="BUSQ/M_BUSQ_COB_1.php" method="post" id=form'.$i.'>';

    echo '<input style="display:none;" type="text" value="1" name="copago_cam"/>';
    echo '<input style="display:none;" type="text" value="'.$i.'" name="i"/>';
    echo '<input style="display:none;" type="text" value="'.$aten['correlativo'].'" name="protocolo'.$i.'"/>';
    echo '<input style="display:none;" type="text" value="'.$_GET['CONTRATO'].'" name="CONT'.$i.'"/>';

    echo '<table class="table2">';
    echo '<tr>';
    echo '<td><strong>FORMA DE PAGO </strong>';

    $select_sql = "SELECT cod, tipo_pago FROM tipo_pago WHERE cod != '".$aten['cod_tipo_pago']."' && cod!=4 && cod!=5 && cod!=6 && cod!=7 && cod!=8 && cod!=9";

    $select_query = mysql_query($select_sql);

    echo '<select name="tipo_pago'.$i.'">';
    echo '<option value="'.$aten['cod_tipo_pago'].'">'.$aten['tipo_pago'].'</option>';

    while($tipo_pago = mysql_fetch_array($select_query)){
        echo '<option value="'.$tipo_pago['cod'].'">'.$tipo_pago['tipo_pago'].'</option>';

    }

    echo '</select>';
    $cob_sql ="SELECT cobrador.codigo, cobrador.nombre1, cobrador.apellidos, cobrador.nro_doc FROM cobrador WHERE nro_doc != '".$aten['cobrador']."'";
    $cob_query = mysql_query($cob_sql);

    $cob_sql2 ="SELECT cobrador.codigo, cobrador.nombre1, cobrador.apellidos, cobrador.nro_doc FROM cobrador WHERE nro_doc = '".$aten['cobrador']."'";
    $cob_query2 = mysql_query($cob_sql2);
    $cobb2 = mysql_fetch_array($cob_query2);

    echo ' <strong>COBRADOR </strong><select name="cobrador'.$i.'">';

    echo '<option value=""></option>';
    echo '<option value="'.$cobb2['cobrador'].'">'.$cobb2['codigo'].' '.$cobb2['apellidos'].' '.$cobb2['nombre1'].'</option>';

    while($cob = mysql_fetch_array($cob_query)){

        echo '<option value="'.$cob['nro_doc'].'">'.$cob['codigo'].' '.$cob['apellidos'].' '.$cob['nombre1'].'</option>';


    }
    echo '</select>';
    echo ' <strong>RENDICION </strong><input type="text" value="'.$aten['rendicion'].'" name="rendicion" size="6" /> ';
    echo ' <strong>FECHA DE PAGO </strong><input type="text" value="'.$aten['f_pago'].'" name="f_pago" class="calendario" sizze="6"/>';
    echo '</td>';
    echo '<td><input type="submit" value="Cambiar" class="boton" /></td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';
    echo '<br />';
    $i ++;
}

    }

    function MuestraAtenciones($num_solici){
    $aten_sql ="SELECT DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y  %H:%m') AS h_aten, correlativo,num_solici, paciente, destino.destino, tipo_pago.tipo_pago
                FROM fichas
                LEFT JOIN destino ON destino.cod = fichas.obser_man
                INNER JOIN copago ON copago.protocolo = fichas.correlativo
                LEFT JOIN tipo_pago ON tipo_pago.cod = copago.tipo_pago
                WHERE fichas.num_solici='".$num_solici."' AND copago.numero_socio='".$num_solici."'
                GROUP BY correlativo DESC";

    $query = mysql_query($aten_sql);

    echo '<table class="table2">';

    echo '<tr>';
    echo '<th><strong>PROT</strong></th>';
    echo '<th><strong>FECHA ATEN</strong></th>';
    echo '<th><strong>PACIENTE</strong></th>';
    echo '<th><strong>DESC</strong></th>';
    echo '<th><strong>TIPO_PAGO</strong></th>';
    echo '</tr>';


    while ($aten = mysql_fetch_array($query)){
        echo '<tr>';
        echo '<td>'.$aten['correlativo'].'</td>';
        echo '<td>'.$aten['h_aten'].'</td>';
        echo '<td>'.$aten['paciente'].'</td>';
        echo '<td>'.$aten['destino'].'</td>';
        echo '<td>'.$aten['tipo_pago'].'</td>';
        echo '</tr>';
    }

echo '</table>';
}
}
?>
