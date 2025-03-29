<script type="text/javascript">
$(document).ready(function() {

$('td:contains("Honorario")').parent().addClass('verde');
$('td:contains("Activo")').parent().addClass('verde');
$('td:contains("Renuncia")').parent().addClass('azul');
$('td:contains("Fallecimiento")').parent().addClass('azul');
$('td:contains("CM - Cliente Moroso")').parent().addClass('rojo');
$('td:contains("Baja Autom�tica")').parent().addClass('rojo');
$('td:contains("Falta de Pago")').parent().addClass('rojo');
$('td:contains("Dicom")').parent().addClass('rojo');
$('td:contains("DICOM")').parent().addClass('rojo');
$('td:contains("Otras Causas")').parent().addClass('rojo');
$('td:contains("HONORARIO MOROSO")').parent().addClass('rojo');

});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/funciones_fact.php');


$fecha = new Datos();
$periodo = $fecha->cambiaf_a_mysql($_POST['periodo']);
$fepago = $fecha->cambiaf_a_mysql($_POST['fecha']);



if($_POST['nro_doc']!= "" && $_POST['num_solici'] != "" && $_POST['opcion'] > 0 && $_POST['cobrador'] != "" && $_POST['monto'] > 0){

if($_POST['opcion'] < 2 && $_POST['opcion'] > 0){

     $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion)
                              VALUES(1,'".$_POST['nro_doc']."','C','50','".$_POST['comprovante']."','1','0','".$periodo."','".$periodo."','".$_POST['monto']."','".$_POST['cobrador']."','".$_POST['num_solici']."','".$periodo."','".$_POST['monto']."','0','NULL')";

     $query = mysql_query($insert_sql);

}

if($_POST['opcion'] < 3 && $_POST['opcion'] > 1 ){



   if($_POST['m_pago'] > 0 && $_POST['rendicion'] > 0 && $_POST['fecha'] != ""){

 $insert_sql1 = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion)
                              VALUES(1,'".$_POST['nro_doc']."','C','50','".$_POST['comprovante']."','1','".$_POST['comprovante']."','".$periodo."','".$periodo."','".$_POST['monto']."','".$_POST['cobrador']."','".$_POST['num_solici']."','".$periodo."','".$_POST['monto']."','0','NULL')";

 $insert_sql2 = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion)
                              VALUES(1,'".$_POST['nro_doc']."','C','50','".$_POST['comprovante']."','".$_POST['m_pago']."','".$_POST['comprovante']."','".$periodo."','".$periodo."','".$_POST['monto']."','".$_POST['cobrador']."','".$_POST['num_solici']."','".$fepago."','0','".$_POST['monto']."','".$_POST['rendicion']."')";


echo '<br />'.$insert_sql1.'<br />';
echo '<br />'.$insert_sql2.'<br />';

         $query1 = mysql_query($insert_sql1);
         $query2 = mysql_query($insert_sql2);

    }



}

}




//echo $periodo;

$sql ="SELECT cta.afectacion,cta.debe, e_contrato.descripcion AS estado,DATE_FORMAT(cta.fecha,'%d-%m-%Y') AS fecha, cta.cobrador, cta.comprovante,DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso,contratos.num_solici, contratos.titular, CONCAT(titulares.apellido,' ',titulares.nombre1,' ',titulares.nombre2) AS nom,planes.desc_plan, valor_plan.valor
FROM contratos
INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
INNER JOIN planes ON planes.cod_plan = contratos.cod_plan AND planes.tipo_plan = contratos.tipo_plan
INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan AND valor_plan.secuencia = contratos.secuencia
LEFT JOIN cta ON cta.num_solici = contratos.num_solici AND cta.nro_doc = contratos.titular AND cta.fecha_mov ='".$periodo."' AND cta.cod_mov='1'

WHERE contratos.f_ingreso <='".$periodo."' AND (f_baja >='".$periodo."' || f_baja ='0000-00-00') AND contratos.factu = 'C' AND contratos.tipo_plan !=3 AND contratos.empresa IS NULL && f_pago !=400 ORDER BY titulares.apellido";

$query = mysql_query($sql);




$rut = new Datos();



while ($planes = mysql_fetch_array($query)){
?>
<script type="text/javascript">
$(document).ready(function() {

$('#<?php echo $planes['num_solici']; ?>').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#factu_1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

});
</script>
<?

    $rut->validar_rut($planes['titular']);
    echo '<form action="BUSQ/FACT_EFA_PAR.php" method="post" id="'.$planes['num_solici'].'">';
    echo '<h1>CONTRATO N '.$planes['num_solici'].'</h1>';
    echo '<table class="table99">';
    echo '<tr>';

    echo '<td style="display:none;"><input type="text" value="'.$planes['num_solici'].'" name="num_solici" /></td>';
    echo '<td style="display:none;"><input type="text" value="'.$_POST['periodo'].'" name="periodo" /></td>';
    echo '<td style="width: 150px;">'.$rut->nro_doc.' '.$planes['nom'].'</td>';
    echo '<td style="display:none;"><input type="text" value="'.$planes['titular'].'" name="nro_doc" /></td>';
    echo '<td style="width: 25px;">'.$planes['f_ingreso'].'</td>';
    echo '<td style="width: 25px;">'.$planes['f_baja'].'</td>';
    echo '<td>'.$planes['estado'].'</td>';
    echo '<td>&zwnj;</td>';
    echo '<td>&zwnj;</td>';



    if($planes['afectacion'] > 0){

        $pagada ='PAGADA';

    }
    if ($planes['afectacion'] == 0){
        $pagada ='PENDIENTE';

    }

echo '</tr>';

echo '<tr>';
    if ($planes['comprovante'] > 0){
    echo '<td><strong>COMP</strong> '.$planes['comprovante'].'</td>';
    echo '<td><strong>VALOR </strong> $ '.number_format($planes['debe'],0,',','.').'</td>';
    echo '<td><strong>COBRADOR </strong> '.$planes['cobrador'].'</td>';
    echo '<td style="width: 25px;"><strong>FECHA DE PAGO </strong> '.$planes['fecha'].'</td>';
    echo '<td style="width: 100px;"><strong>ESTADO </strong> '.$pagada.'</td>';
    echo '<td>&zwnj;</td>';

    }
    else{
    echo '<td><strong>COMP</strong> <input type="text" value="'.$planes['comprovante'].'" name="comprovante"  /></td>';
    echo '<td><strong>VALOR </strong> <input type="text" value="'.$planes['valor'].'" name="monto" size="6" /></td>';
    echo '<td><strong>COBRADOR </strong> <input type=="text" value="'.$planes['cobrador'].'" name="cobrador" size="3" /></td>';
    echo '<td>

<table>

<tr>
<td><strong>FECHA PAGO </strong></td><td><input type="text" value="'.$planes['fecha'].'" name="fecha" size="6" /></td>
</tr>

<tr>
<td><strong>RENDICION</strong></td><td><input type="text" name="rendicion" /></td>
</tr>

<tr>
<td><strong>MEDIO DE PAGO</strong></td><td>';

    $sql2 = "SELECT codigo, larga FROM t_mov WHERE operador = 'H' AND codigo != '53' AND codigo !='88' AND codigo !='90' AND codigo !='97' AND codigo !='60'";
    $query2 = mysql_query($sql2);
    echo'<select name="m_pago" >';
        while($m_pago = mysql_fetch_array($query2)){
            echo '<option value="'.$m_pago['codigo'].'">'.$m_pago['larga'].'</option>';
        }
    echo '</select>';
    echo '</td>
</tr>


</table>

</td>';
    echo '<td style="width: 100px;"><table style="width: 90px;">
        <tr>
        <td><strong>MENSUALIDAD<Strong></td><td><input type="radio" name="opcion" value="1" /></td>
        </tr>
        <tr><td><strong>REBAJAR</strong></td><td><input type="radio"  name="opcion" value="2" /></td>
        </tr></table></td>';
    echo '<td><input type="submit" value="FACT" class="boton" /></td>';


    }

    echo '</tr>';
    echo '</table>';
    echo '</form>';
}
?>
