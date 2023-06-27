<script type="text/javascript">
$(document).ready(function() {

$('.link2').click(function() {
	var ruta = $(this).attr('href');	
 	$('#SUB1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
	});	

$(function() {$(".calen").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php 
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

/* SECUENCIA */
if($_GET['secuencia']){
	$valor_sql = "SELECT valor FROM valor_plan WHERE secuencia ='".$_GET['secuencia']."' AND cod_plan='".$_GET['plan2']."' AND tipo_plan='".$_GET['tipo_plan']."'";
	$valor_query = mysql_query($valor_sql);
	$valor = mysql_fetch_array($valor_query);

        //echo $valor_sql.'<br />';

	if ($valor['valor'] != ''){
		echo '<strong style="font-size:15px;"> VALOR $ '.number_format($valor["valor"],"0",",",".").'</strong>';
		echo '<input style="display:none;" type="text" value="'.$valor["valor"].'" name="monto"/>';
                echo '<input style="display:none;" type="text" value="'.$_GET['secuencia'].'" name="secuencia_PP"/>';
                echo '<input style="display:none;" type="text" value="'.$_GET['plan2'].'" name="ff_cod_plan"/>';
                echo '<input style="display:none;" type="text" value="'.$_GET['tipo_plan'].'" name="ff_tipo_plan"/>';
		/*FORMA DE PAGO INCORPORACION CONTRATO*/
		echo '<h2><strong>FORMA DE PAGO INCORPORACION</strong></h2>';
		
		$query_sql ="SELECT codigo,descripcion FROM pago_venta";
		$query = mysql_query($query_sql);
		echo '<div id="forma_pago" class="sub_menu">';
		
			while ($f_pago = mysql_fetch_array($query)){
				echo '<a class="link2" href="INT/SUB_M_AUDI_F_PAGO_3.php?fpago='.$f_pago['codigo'].'&monto='.number_format($valor["valor"],"0",",",".").'">'.strtoupper($f_pago['descripcion']).'</a>&nbsp;&nbsp;';
			}		
		echo '</div>';
		echo '<div id="SUB1"></div>';				
	}
	
	else{
		echo '<div class="mensaje2"><strong>La Secuencia no existe</strong></div>';
	}
	
	exit;
}



?>