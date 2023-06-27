<?php 
session_start('conf_plan'); 
if (isset($_GET['plan'])){ 
   	$_SESSION["tt_pl"] = $_GET['plan']; 
} 
?>

<script type="text/javascript">
$(document).ready(function() {

$('a').click(function() {
	var ruta = $(this).attr('href');	
 	$('#SUB1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
	});	
	
$(function() {$(".calen").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#comprobar').click(function() {
	var valor = $('#ff_secuencia').get(0).value;
	var tipo_plan ='<?php echo 	$_SESSION["tt_pl"]?>';
	var plan = $('.plan').val();
	$.get('INT/SUB_M_AUDI_F_PAGO_2.php?secuencia='+valor+'&tipo_plan='+tipo_plan+'&plan2='+plan, function(data){$('#sec').html(data);
	}); 
});

$('.rut').Rut({
	  on_error: function(){ alert('Rut incorrecto'); }
	});

});
</script>

<?php 
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

/* PLAN */
if ( isset($_GET['plan'])){
	
	$sql= "SELECT planes.cod_plan,planes.tipo_plan,desc_plan FROM planes WHERE planes.tipo_plan='".$_GET['plan']."' AND planes.estado='ACTIVO'";
	$query = mysql_query($sql);
		
	echo '<p><strong>PLAN </strong>';
	
	/* ff_tipo_plan */
	echo '<input type="text" name="ff_tipo_plan" value="'.$_GET['plan'].'" style="display:none;"/>';
	echo '<select id="plan" class="plan" name="ff_plan">';
	
	while ($planes_2 = mysql_fetch_array($query)){
		echo '<option value="'.$planes_2['cod_plan'].'">'.$planes_2['tipo_plan'].' -- '.$planes_2['cod_plan'].' -- '.$planes_2['desc_plan'].'</option>';
	}
	echo '</select>';
	
	
		echo '<strong> Secuencia </strong><input type="text" name="ff_secuencia" id="ff_secuencia" size="2" maxlength="2" value="1" /> <input type="button" id="comprobar" value="Comprobar" />';
		echo '<br /><br />';
		echo '<div id="sec"></div>';
	
	if ($_GET['plan']==3){
	
	echo '<h1>DIRECCION DE AREA PROTEGUIDA</h1>';
	
	echo '<strong> CALLE/PASAJE </strong> <input type="text" name="ff_a_pasaje" size="10" />';
	echo '<strong>VILLA/POBLACION </string><input type="text" name="ff_a_poblacion"';
	
	echo '<strong> NUMERO </strong> <input type="text" name="ff_a_numero" size="2" />';
	echo '<br /><br />';
	echo '<strong> DEPARTAMENTO </strong><input type="text" name="ff_a_departamento" />';
	echo '<strong> PISO </strong><input type="text" name="ff_a_piso" size="2" />';
	echo '<strong> LOCALIDAD </strong><input type="text" name="ff_a_localidad" size="10" />';
	echo '<strong> TELEFONO </strong><input type="text" name="ff_a_telefono" size="6" />';
	echo '<br /><br />';
	
	$provincia = new Select;
	echo '<strong> PROVINCIA </strong>';
	
	$provincia->selectSimple('provincia','codigo,provincia','provincia','codigo','ff_a_provincia','ff_a_provincia','');
	echo '<input type="text" name="MA" size="10" value="1" style="display:none;"/>';
	}
	echo '</p>';
	exit;
}

/* FORMA DE PAGO MENSUALIDAD */

if ( isset($_GET['fpago_M']) ){			
				
		/* PAC */	
		if ($_GET['fpago_M'] == 100){
			$pac_sql = "SELECT codigo,folio FROM doc WHERE categoria='103' AND vendedor='".$_GET['vendedor']."'  AND estado < 500";
			$pac_query = mysql_query($pac_sql);

					echo '<h1>DATOS DE PAC</h1>';
					echo '<input type="text" value="'.$_GET['fpago_M'].'" name="ff_pago" style="display:none" />';
	
					echo '<strong>N DE PAC </strong><select name="ff_pac">';
	
					while($pac = mysql_fetch_array($pac_query)){
					echo '<option value="'.$pac['codigo'].'">'.$pac['folio'].'</option>';
					}		
					echo '</select>';
					
					echo '<input type="text" value="'.$pac['codigo'].'" name="ff_cod_pag" style="display:none" />';
					
					echo '<strong> Banco </strong>';
					
					$bancos = new Select;
					$bancos->selectSimple('bancos','codigo,descripcion','descripcion','codigo','ff_banco','ff_banco','');
					
					echo '<br /><br />';

                                        echo '<strong> RUT TITULAR DE LA CUENTA </strong> <input type="text" name="ff_rut_titular_cta" class="rut" />';
					echo '<strong> NOMBRE TITULAR DE LA CUENTA </strong> <input type="text" name="ff_titular_cta" />';
                                        echo '<br /><br />';
                                        echo '<strong> NOMBRE 2 TITULAR DE LA CUENTA </strong> <input type="text" name="ff_nombre2" />';
                                        echo '<strong> APELLIDOS </strong> <input type="text" name="ff_apellidos" />';
					
					echo '<br /><br />';
					echo '<strong> NUMERO DE CTA </strong><input type="text" name="ff_cuenta1" /><strong> REPITA NUMERO DE CTA </strong><input type="text" name="ff_cuenta2" />';
					echo '<strong> Dia de pago</strong>  <select name="ff_d_pago"><option value="1">1</option><option value="5">5</option><option value="10">10</option></select>';

                                        echo '<br /><br /><strong>Facturacion</strong> <select name="ff_factu"><option value="A">Factura</option><option value="B">Boleta</option><option value="C">Factura Elec</option></select>';


				}
				
				/*Tarjeta de Credito */
				if ($_GET['fpago_M'] == 200){
					echo '<input name="ff_pago" value="'.$_GET['fpago_M'].'" style="display:none" />';
					echo '<h1>DATOS DE TARJETA</h1>';			
					$bancos = new Select;
					echo '<strong> TARJETA </strong>';
					$bancos->selectSimple('t_credito','codigo,descripcion','descripcion','codigo','ff_t_credito','ff_t_credito','');	
					echo '<br /><br />';
                                        echo '<strong> RUT TITULAR DE LA TARJETA </strong> <input type="text" name="ff_rut_titular_cta" class="rut" />';
					echo '<strong> NOMBRE TITULAR DE LA TARJETA </strong> <input type="text" name="ff_titular_cta" />';
					 echo '<br /><br />';
                                        echo '<strong> NOMBRE 2 TITULAR DE LA CUENTA </strong> <input type="text" name="ff_nombre2" />';
                                        echo '<strong> APELLIDOS </strong> <input type="text" name="ff_apellidos" />';

					echo '<br /><br />';
					echo '<strong> NUMERO DE CTA </strong><input type="text" name="ff_cuenta1"/><strong> REPITA NUMERO DE CTA </strong><input type="text" name="ff_cuenta2" />';
					echo '<strong> Dia de pago</strong>  <select name="ff_d_pago"><option value="1">1</option><option value="5">5</option><option value="10">10</option></select>';
                                        echo '<br /><br /><strong>Facturacion</strong> <select name="ff_factu"><option value="A">Factura</option><option value="B">Boleta<option></option value="C">Factura Elec</option></select>';
				}
				/* Cobro domiciliario */
				if ($_GET['fpago_M'] == 300){
					echo '<input name="ff_pago" value="'.$_GET['fpago_M'].'" style="display:none" />';
					echo '<h1>DIRECCION DE COBRO</h1>';
					echo '<strong> CALLE/PASAJE </strong> <input type="text" name="ff_pasaje" size="10" />';					
					echo '<strong>VILLA/POBLACION </string><input type="text" name="poblacion"';

					echo '<strong> NUMERO </strong> <input type="text" name="ff_numero" size="2" />';
					echo '<br /><br />';
					echo '<strong> ENTRE </strong><input type="text" name="entre" />';
					echo '<strong> DEPARTAMENTO </strong><input type="text" name="departamento" />';
					echo '<strong> PISO </strong><input type="text" name="piso" size="2" />';
					echo '<br /><br />';
					echo '<strong> LOCALIDAD </strong><input type="text" name="localidad" size="10" />';
					echo '<strong> TELEFONO </strong><input type="text" name="telefono" size="6" />';

                                       
					$zosema = "SELECT ZO, SE, MA, descripcion, cobrador.apellidos, cobrador.nombre1
                                                   FROM ZOSEMA
                                                   INNER JOIN cobrador ON ZOSEMA.cobrador = cobrador.nro_doc
                                                   WHERE ZOSEMA.estado = 1 AND ZO != '777' AND ZO != '888' AND ZO != '0' AND ZO != '111' AND cobrador.nro_doc != 1 GROUP BY ZO,SE,cobrador.nombre1";
					$zo_query = mysql_query($zosema);
					
					echo '<strong>ZO-SE-MA</strong> ';
					echo '<select name="ff_sozema">';
					
					while ($numm = mysql_fetch_array($zo_query)){
						echo '<option value="'.$numm["ZO"].'-'.$numm["SE"].'-'.$numm["MA"].'">'.$numm["ZO"].'-'.$numm["SE"].'-'.$numm["MA"].' '.$numm['nombre1'].' '.$numm['apellidos'].'</option>';
					}
					echo '</select><br /><br />';
					
					$provincia = new Select;
					echo '<strong> PROVINCIA </strong>';
					$provincia->selectSimple('provincia','codigo,provincia','provincia','codigo','provincia','provincia','');
					
					
					echo '<input type="text" name="MA" size="10" value="1" style="display:none;" />';
					echo '<strong> Dia de pago</strong>  <select name="ff_d_pago"><option value="1">1</option><option value="5">5</option><option value="10">10</option></select>';
                                        echo '<br /><br /><strong>Facturacion</strong> <select name="ff_factu"><option value="A">Factura</option><option value="B">Boleta</option><option value="C">Factura Elec</option></select>';
				}	

				/* Descuento por planilla */
				
				if ($_GET['fpago_M'] == 400){
					
					echo '<input name="ff_pago" value="'.$_GET['fpago_M'].'" style="display:none" />';
					echo '<h1>EMPRESA</h1>';
					$empresa = new Select;
					echo '<strong> Empresa </strong>';
					$empresa->selectSimple('empresa','nro_doc,empresa','empresa','nro_doc','empresa','empresa','');
					echo '<select style="display:none;" name="ff_d_pago"><option value="1">1</option><option value="5">5</option><option value="10">10</option></select>';
                                        echo '<select style="display:none;" name="ff_factu"><option value="A">Factura</option><option value="B">Boleta</option><option value="C">Factura Elec</option></select>';
				}	

				if ($_GET['fpago_M'] == 500){
					echo '<input name="ff_pago" value="'.$_GET['fpago_M'].'" style="display:none" />';
					echo '<h1>TRANFERECNIA ELECTRONICA</h1>';
					echo '<strong> Dia de pago</strong>  <select name="ff_d_pago"><option value="1">1</option><option value="5">5</option><option value="10">10</option></select>';
                                        echo '<br /><br /><strong>Facturacion</strong> <select name="ff_factu"><option value="A">Factura</option><option value="B">Boleta</option><option value="C">Factura Elec</option></select>';
				}	
				
			echo'</p>';		
			exit;
}

?>