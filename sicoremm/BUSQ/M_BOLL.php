
<script type="text/javascript">
$(document).ready(function() {

$('#inco2 a').click(function() {
	var ruta = $(this).attr('href');
 	$('#inco2').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });


});
</script>


<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');


$cont = 0;
$condicion = "WHERE";


    if($_POST['fecha1'] !="" && $_POST['fecha2']){

        $condicion = $condicion.' fecha BETWEEN "'.$_POST['fecha1'].'" AND "'.$_POST['fecha2'].'" AND';
    }


foreach($_POST AS $campo=>$valor){


    if($valor != "" && $campo !='fecha1' && $campo !='fecha2' ){

       //echo $campo.' '.$valor.'<br />';
       $condicion = $condicion.' '.$campo.'="'.$valor.'" AND ';
       $cont ++;
    }

}

$condicion = substr($condicion, 0, -4);

if($cont > 0){
    
    $cond = $condicion;
}


$sql ="SELECT ventas_reg.titular,ventas_reg.mes_pago_inicial,ff_factu,ventas_reg.codigo AS cod,vendedor.nro_doc AS vemd,rendicion,cat_venta.descripcion AS cat_venta,
num_solici, DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha, vendedor.apellidos, vendedor.nombre1, vendedor.nro_doc AS nro_doc_vend, monto, sec, ventas_reg.n_documento,monto
FROM ventas_reg

INNER JOIN pago_venta ON ventas_reg.pago_venta = pago_venta.codigo
INNER JOIN cat_venta ON ventas_reg.cat_venta = cat_venta.codigo
INNER JOIN vendedor ON vendedor.nro_doc= ventas_reg.vendedor ".$cond;

//echo '<br />'.$sql.'<br />';

$query = mysql_query($sql);


$id =1;

while($bol = mysql_fetch_array($query)){


echo '<script type="text/javascript">
$(document).ready(function() {

$("#ajax #'.$id.'").submit(function(){

	var url_ajax = $(this).attr("action");
	var data_ajax = $(this).serialize();

	$.ajax({type: "POST",url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$("#inco2").html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});
});
</script>';



echo '<form action="BUSQ/M_BOLL_PROCESA.php" method="post" id ="'.$id.'" >';
echo '<table class="table2">';

$TOTAL = $TOTAL+$bol['monto'];

    echo '<tr>
<th>Contrato</th>
<th>Fecha</th>
<th>Vendedor</th>
<th>Pers.</th>
<th>DES</th>
<th>TIPO</th>
<th>N DOCUMENTO</th>
<th>N MONTO</th>
<th>RENDICION</th>
<th>PERIODO</th>
</tr>';

    echo '<tr>
        <td>'.$bol['num_solici'].'</td>
        <td><input type="text" value="'.$bol['fecha'].'" size="10" name="fecha" /></td>
            <td style="display:none;"><input type="text" value="'.$bol['cod'].'" size="10" name="codigo" /></td>';



            echo '<td>
            <select name="vendedor">';
                $sql2 = "SELECT vendedor.nro_doc, vendedor.nombre1, vendedor.apellidos FROM vendedor WHERE nro_doc !=".$bol['nro_doc_vend'];
                $query2 = mysql_query($sql2);

                 echo '<option value="'.$bol['nro_doc_vend'].'">'.$bol['apellidos'].' '.$bol['nombre1'].'</option>';

                while($vendedor = mysql_fetch_array($query2)){
                 echo '<option value="'.$vendedor['nro_doc'].'">'.$vendedor['apellidos'].' '.$vendedor['nombre1'].'</option>';
                }
                echo '</select></td>';
$mes_pago = new Datos();
$mes = $mes_pago->cambiaf_a_mysql($bol['mes_pago_inicial']);

        echo ' <td>'.$bol['sec'].'</td>
            <td>'.$bol['cat_venta'].'</td>

        <td><input type="text" value="'.$bol['ff_factu'].'" name="ff_factu" size="5"/></td>
        <td><input type="text" value="'.$bol['n_documento'].'" name="n_documento" size="5"/></td>
        
        <td><input type="text" value="'.$bol['monto'].'" name="monto" size="5" /></td>
<td><input type="text" value="'.$bol['rendicion'].'"  size="5" name="rendicion"/></td>

<td><input type="text" value="'.$mes.'" name="mes_pago_inicial" size="8" class="calendario" /></td>


<td><input type="submit" value="Editar" class="boton" /><br />
<a href="BUSQ/M_BOLL_PROCESA.php?imprimir=1&titular='.$bol['titular'].'&contrato='.$bol['num_solici'].'&comprovante='.$bol['n_documento'].'">Enviar a Mascom</a></td>
</tr>';
echo '</table>';
echo '</form>';

echo '<br />';
$id ++;
}


echo '<br /><h1> TOTAL '.$TOTAL.'</h1>';
?>
