<script type="text/javascript">
$(document).ready(function() {

$('.link3').click(function() {
	var ruta = $(this).attr('href');
 	$('#SUB1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
	});

$(function() {$(".calen2").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


/* FORMA DE PAGO INCORPORACION*/
if ( isset($_GET['fpago'])){


	if (date('d') <= 19){
		$mes = date('m');
		$fecha_q = date('Y').'-'.$mes.'-'.date('d');
	}
	else{
		$mes = (date('m')) + 1;
			if ($mes > 12){
				$mes=1;
				$fecha_q = (date('Y')+1).'-'.$mes.'-'.date('d');
			}
	}

	echo '<br />';

	echo '<strong style="font-size:12px;"> Monto $ '.$_GET['monto'].' <br />Mes Inicial Cuota Mes '.$mes.'</strong>
	<input style="display:none" type="text" name="monto" value="'.$_GET['monto'].'" />
	<input type="text" name="ff_m_pago_i" style="display:none" value="'.$fecha_q.'" />
	<br /><br />';

	/*EFECTIVO */
	if ($_GET['fpago'] == 40){
		echo '<input type="text" value="'.$_GET['fpago'].'" name="ff_fpago" style="display:none"';
		echo '<input type="text" name="fecha" value="'.date('d-m-Y').'" class="calen" style="display:none" />';
	}

	/*DESCUENTO POR PLANILLA */
	if ($_GET['fpago'] == 50){
		echo '<input type="text" value="'.$_GET['fpago'].'" name="ff_fpago" style="display:none"';
		echo '<input type="text" name="fecha" value="'.date('d-m-Y').'" class="calen" style="display:none" />';
	}


	/*CHEQUE A FECHA */
	if ($_GET['fpago'] == 10){
		echo '<strong> Fecha del Cheque </strong><input type="text" name="fecha_documento" class="calen2" />';
		echo '<input type="text" name="fecha" value="'.date('d-m-Y').'" class="calen" style="display:none" />';
		echo '<strong> Numero Cheque </strong><input type="text" name="n_che_tar" />';
		echo '<br /><br />';
		echo '<strong>Banco </strong>';
		$bancos = new Select;
		$bancos->selectSimple('bancos','codigo,descripcion','descripcion','codigo','ff_banco','ff_banco','');
	}
	/* CHEQUE AL DIA */
	if ($_GET['fpago'] == 20){
		echo '<input type="text" name="fecha" value="'.date('d-m-Y').'" class="calen2" style="display:none" />';

		echo '<strong> Numero Cheque </strong><input type="text" name="n_che_tar" />';
		echo '<br /><br />';
		echo '<strong>Banco </strong>';
		$bancos = new Select;
		$bancos->selectSimple('bancos','codigo,descripcion','descripcion','codigo','ff_banco','ff_banco','');

	}

	/* TARJETA */
	if ($_GET['fpago'] == 30){
		echo '<input type="text" name="ff_fecha" value="'.date('d-m-Y').'" class="calen" style="display:none" /><strong> N Tarjeta </strong><input type="text" name="n_tarjeta"/>';
		echo '<strong> Tarjeta </strong>';
		$bancos = new Select;
		$bancos->selectSimple('t_credito','codigo,descripcion','descripcion','codigo','ff_t_credito','ff_t_credito','');
	}

	echo '<input type="text" value="'.$_GET['fpago'].'" name="ff_fpago" style="display:none" />';


	echo '<input type="text" name="ff_t_doc" value="150" style="display:none" />';

	echo '<input type="text" name="n_documento" style="display:none" value="0" />';
	exit;
}
?>