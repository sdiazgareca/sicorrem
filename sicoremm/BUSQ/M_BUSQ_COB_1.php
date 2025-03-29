<script type="text/javascript">
$(document).ready(function() {


 $('#ajax1 a:contains("Modificar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });


$('#camfi').submit(function(){

 if(!confirm(" Esta seguro de continuar?")) {
	  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

$('#Afiliados_editar').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});

$('#rem_afiliafo').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});

 $('#ajax1 a:contains("Editar")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

  $('#ajax1 a:contains("Intereses y Gastos de Cob")').click(function() {
	var ruta = $(this).attr('href');
 	$('#g_pago').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

   $('#ajax1 a:contains("Remplazos")').click(function() {
	var ruta = $(this).attr('href');
 	$('#g_pago').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });


 $('#ajax1 a:contains("N_Credito")').click(function() {
	var ruta = $(this).attr('href');
 	$('#g_pago').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });


  $('#ajax1 a:contains("Mensualidades")').click(function() {
	var ruta = $(this).attr('href');
 	$('#g_pago').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$(function() {$(".calendario22").datepicker({ dateFormat: 'dd-mm-yy' });});





$('#pago_ant').submit(function(){

	 if(!confirm("Desea ingresar el pago?")) {
		  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

$('#cambia_contrato').submit(function(){

	 if(!confirm(" Esta seguro de continuar?")) {
		  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

$('#pago_men').submit(function(){

	 if(!confirm(" Esta seguro de efectuar el pago?")) {
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
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Afiliados.php');
include_once('../CLA/Titular.php');
include_once('../CLA/Contrato.php');
include_once('../CLA/Atenciones.php');
include_once('../CLA/Cta.php');


function fecha_normal_a_mysql($fecha){
  
    $cambio = explode('-',$fecha);
    
    $fecha_final = $cambio[2].'-'.$cambio[1].'-'.$cambio[0];
    
    return $fecha_final;
    
}

function pago_cta($serie,$nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion){

    $rendicion = is_string($rendicion)? 0 : $rendicion;

    $fecha_mov1 = fecha_normal_a_mysql($fecha_mov);
    $fecha_vto2 = fecha_normal_a_mysql($fecha_vto);
    $fecha3 = fecha_normal_a_mysql($fecha);

    $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'".$nro_doc."','".$tipo_comp."','".$serie."','".$comprovante."','".$cod_mov."','".$afectacion."','".$fecha_mov1."','".$fecha_vto2."','".$importe."','".$cobrador."','".$num_solici."','".$fecha3."','".$debe."','".$haber."','".$rendicion."')";
    return $insert_sql;

}




//PAGO ANTICIPADO
if ($_GET['Panticipa'] > 0){

    $num_solici = $_GET['Panticipa'];
    ?>

<form method="post" action="BUSQ/M_BUSQ_COB_2.php" name="pago_ant" id="pago_ant">

    <?php
 $info_sql = "
     SELECT contratos.factu, cobrador.nombre1, cobrador.codigo, cobrador.apellidos
FROM contratos
INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.MA = contratos.MA AND ZOSEMA.SE = contratos.SE
INNER JOIN cobrador ON ZOSEMA.cobrador = cobrador.nro_doc
WHERE contratos.num_solici = '".$_GET['CONTRATO']."' AND contratos.titular='".$_GET['RUT']."'";

$info_query = mysql_query($info_sql);

$info = mysql_fetch_array($info_query);
    ?>


<table class="table">

    <tr>
        <th>Rendicion</th>
        <th><input type="text" name="rendicion" /></th>
        <th><input style="display:none;" type="text" name="nro_doc" value="<?php echo $_GET['RUT'];?>" />&zwnj;</th>
        <th><input style="display:none;" type="text" name="num_solici" value="<?php echo $_GET['CONTRATO']; ?>" />&zwnj;</th>
    </tr>

    <tr>
        <td><strong>Importe</strong> </td> <td> <input type="text" name="importe" name="documento" maxlength="10" size="10" /> </td>
        <td><strong>Periodo Inicial </strong></td> <td> <input type="text" name="pinicial" class="calendario" /> </td>
        <td><strong>Fecha</strong></td><td><input type="text" name="fecha" class="calendario22" /></td>
        <td><strong>Documento</strong> <td> <?php echo '<select name="tipo"><option value="'.$info['factu'].'">'.$info['factu'].'</option>'; $sql1 = "SELECT codigo, descripcion, tipo_doc FROM t_documento WHERE t_documento.codigo != 150 AND t_documento.codigo != 400 AND t_documento.codigo != 500 AND t_documento.codigo != 600 AND tipo_doc != '".$info['factu']."' ORDER BY tipo_doc"; $query1 = mysql_query($sql1); while ($cob1 = mysql_fetch_array($query1) ){echo '<option value="'.$cob1['tipo_doc'].'">'.$cob1['tipo_doc'].'</option>';} echo '</select>';?> </td>
        <td><strong>Cobrador</strong></td><td><?php echo '<select name="cobrador"><option value="'.$info['codigo'].'">'.$info['codigo'].' '.$info['nombre1'].' '.$info['apellidos'].'</option>'; $sql = "SELECT codigo, nombre1, nombre2, apellidos FROM cobrador WHERE cobrador.codigo != '".$info['codigo']."'"; $query = mysql_query($sql); while ($cob = mysql_fetch_array($query) ){echo '<option value="'.$cob['codigo'].'">'.$cob['codigo'].' '.$cob['nombre1'].' '.$cob['nombre2'].' '.$cob['apellidos'].'</option>';} echo '</select>';?></td>

    </tr>

    <tr>
        <td><strong>N Documento</strong></td><td><input type="text" name="documento" maxlength="10" size="10" /></td>
        <td><strong>C Periodos</strong></td><td><input type="text" name="periodo"  size="4" maxlength="3" /></td>

                <td><strong>Tipo</strong></td>
<td>
    <select name="tipo_comp">

<?php

$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov WHERE operador ='H' AND codigo != '53' AND codigo != '60' AND codigo != '88' AND codigo != '91' AND codigo != '97' ";
$tipo_query = mysql_query($tipo_sql);

 while($tip = mysql_fetch_array($tipo_query)){
 ?>
    <option value="<?php echo $tip['codigo']; ?>"><?php echo $tip['corta'].'-'.$tip['larga']; ?></option>

<?php
}
?>

    </select>
</td>

    </tr>

</table>

<div align="right"><input type="submit" value="Cargar" class="boton" /></div>
</form>

<div id="ppant"></div>


<?php
}


//DATOS DEL CONTRATO

if ($_GET['Contratante'] > 0 || $_POST['Contratante'] > 0){

    if ($_GET['Contratante'] > 0){
        
        $num_solici = $_GET['CONTRATO'];
        
}
    
    if ($_POST['Contratante'] > 0){
        
    $num_solici = $_POST['num_solici'];

    if($_POST['estado_contrato'] != 0){

    $baja = explode('-',$_POST['estado_contrato']);

    //RENUNCIA
    //AND afiliados.cod_baja != 'MO'
    if ($baja[0] == 700 || $baja[0] == 1200){

    $query12="UPDATE afiliados SET afiliados.cod_baja ='".$baja[1]."', afiliados.fecha_baja='".date('Y-m-d')."' WHERE num_solici = '".$num_solici."' AND afiliados.cod_baja != '01' AND afiliados.cod_baja != '09' AND afiliados.cod_baja != '03'";
    $query22="UPDATE contratos SET estado='".$baja[0]."', f_baja='".date('Y-m-d')."' WHERE num_solici='".$num_solici."'";


    //echo '<br />'.$query12.'<br />';
    //echo '<br />'.$query22.'<br />';

    $query = mysql_query($query12);
    $query = mysql_query($query22);

    }
    //ACTIVO
    if ($baja[0] == 3500 || $baja[0] == 400 || $baja[0] == 500 || $baja[0] == 1000 ){

    $query12="UPDATE afiliados SET afiliados.cod_baja ='".$baja[1]."', afiliados.fecha_baja='".date('Y-m-d')."' WHERE num_solici = '".$num_solici."' AND afiliados.cod_baja != '01' AND afiliados.cod_baja != '05' AND afiliados.cod_baja != 'MO' AND afiliados.cod_baja != '09' AND afiliados.cod_baja != '03' AND afiliados.cod_baja != 'DV'";
    $query22="UPDATE contratos SET estado='".$baja[0]."', f_baja='".date('Y-m-d')."' WHERE num_solici='".$num_solici."'";
    $query33="UPDATE afiliados SET afiliados.cod_baja ='05', afiliados.fecha_baja='".date('Y-m-d')."' WHERE num_solici = '".$num_solici."' AND (afiliados.cod_baja = '05' || afiliados.cod_baja = 'MO')";

    $query = mysql_query($query12);
    $query = mysql_query($query22);
    $query = mysql_query($query33);

    }

    //FALTA DE PAGO CLIENTE MOROSO DICOM
    if ($baja[0] == 900 || $baja[0] == 3100 || $baja[0] == 3600){

    $query12="UPDATE afiliados SET afiliados.cod_baja ='".$baja[1]."', afiliados.fecha_baja='".date('Y-m-d')."' WHERE num_solici = '".$num_solici."' AND afiliados.cod_baja != '01' AND afiliados.cod_baja != '05' AND afiliados.cod_baja != 'MO' AND afiliados.cod_baja != '09' AND afiliados.cod_baja != '03'";
    $query22="UPDATE contratos SET estado='".$baja[0]."', f_baja='".date('Y-m-d')."' WHERE num_solici='".$num_solici."'";
    $query33="UPDATE afiliados SET afiliados.cod_baja ='MO', afiliados.fecha_baja='".date('Y-m-d')."' WHERE num_solici = '".$num_solici."' AND (afiliados.cod_baja = '05' || afiliados.cod_baja = 'MO' || AND afiliados.cod_baja != '09' AND afiliados.cod_baja != '03')";

    $query = mysql_query($query12);
    $query = mysql_query($query22);
    $query = mysql_query($query33);

    }

    }

}



    $e_contrato_sql ="SELECT descripcion
                      FROM contratos
                      INNER JOIN e_contrato ON contratos.estado = e_contrato.cod
                      WHERE num_solici ='".$num_solici."'";


    $estado_q = mysql_query($e_contrato_sql);

    $e_con = mysql_fetch_array($estado_q);


    echo '<h1>CONTRATO '.strtoupper($e_con['descripcion']).'</h1>';

    echo '</br>';
?>

<form action="BUSQ/M_BUSQ_COB_1.php" method="post" id="cambia_contrato">

    <table class="table2">
        <tr>
            <td>
                <strong>Estado del Contrato</strong>
                <input style="display:none;"  type="text" name="Contratante" value="1" />
                <input style="display:none;"  type="text" name="num_solici" value="<?php echo $num_solici;?>" />
            </td>
            <td>

<select name="estado_contrato">
    
    <?php 
    
    $sql = "SELECT `cod`, `descripcion`, `int`
            FROM `e_contrato`
            WHERE `cod` != '800' AND `cod` != '600' AND `cod` !='1100' AND `cod` !='3300' AND `cod` !='3500' AND `cod` !='100' AND `cod` !='200'  AND `cod` !='300' AND `cod` !='400'";

    $query = mysql_query($sql);
    ?>
    <option value="0"></option>
    <?php
    while ($estado = mysql_fetch_array($query)){
    
    ?>
    <option value="<?php echo $estado['cod'].'-'.$estado['int']; ?>"><?php echo $estado['descripcion']; ?></option>
    <?php
    }
    ?>
</select>
            </td>
            <td><input value="Cambiar" type="submit" class="boton"/></td>
        </tr>
    </table>

    

</form>
<?

        //DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO
        $datosRespo = new Titular;
        $datosRespo->DatosContratante($_GET['CONTRATO'],1);

        //ZONA DE COBRO
        $valorMensual = new Contrato;
        $valorMensual->MuestraZOSEMA($_GET['CONTRATO'],1);

        //VALOR MENSUAL DE LOS SERVICIOS
        $valorMensual = new Contrato;
        $valorMensual->ValorMensual($_GET['CONTRATO'],1);

        //OBTIENE LA FORMA DE PAGO
	$pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
	$pago_sql = mysql_query($pago);
	$tipo_pago = mysql_fetch_array($pago_sql);
        //FORMA DE PAGO MENSUAL
        $valorMensual->FormaPago($_GET['CONTRATO'], $tipo_pago['cod_f_pago'],1);


}


//CAMBIA EL STADO DEL COPAGO
if($_POST['copago_cam'] > 0){


    $tipo_pago ='tipo_pago'.$_POST['i'];
    $protocolo ='protocolo'.$_POST['i'];
    $cobrador = 'cobrador'.$_POST['i'];

    if($_POST['f_pago'] != '--'){
    $f_pago = new Datos();
    $f_pago_mysql = $f_pago->cambiaf_a_mysql($_POST['f_pago']);
    }
    else{
        $f_pago_mysql= NULL;
    }
    $sql = "UPDATE `copago` SET `copago`.`cobrador`='".$_POST[$cobrador]."', `tipo_pago`='".$_POST[$tipo_pago]."', `rendicion`='".$_POST['rendicion']."' , `f_pago`='".$f_pago_mysql."' WHERE `protocolo`='".$_POST[$protocolo]."'";
    //echo '<br />'.$sql.'<br />';
    if ($query = mysql_query($sql)){
        echo OK;
    }
    else{
        echo ERROR;
    }
exit;

}


//ATENCIONES
if ($_GET['Antenciones'] > 0){
    $aten = new Atenciones();
    $aten->MuestraAtencionesEditaPago($_GET['CONTRATO']);
}

?>


<?php

//CTACTE
if ($_GET['Mensualidad'] > 0  || $_POST['Mensualidad']){

if ( $_POST['Mensualidad'] > 0 && isset($_POST['CONTRATO']) && isset($_POST['RUT'])){

    $_GET['RUT'] = $_POST['RUT'];

    $_GET['CONTRATO'] = $_POST['CONTRATO'];



    foreach($_POST as $campo=>$valor){

        if ($valor == ""){
            echo '<div class="mensaje2">Debe llenar todos los campos</div>';
            exit;
        }
    }

    $var = explode('/',$_POST['n_documento']);

    $n_comprobante = $var[0];

    $fecha_mov = $var[1];

    $fecha_vto = $var[2];

    $cod_mov_afectada = $var[3];


    $consul = 'SELECT cta.debe, cta.serie from cta WHERE comprovante="'.$n_comprobante.'"  AND num_solici="'.$_GET['CONTRATO'].'" AND nro_doc="'.$_GET['RUT'].'" AND cod_mov ="'.$cod_mov_afectada.'"';
    $consul_query = mysql_query($consul);
    $valor_boleta = mysql_fetch_array($consul_query);

   /*pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion)*/
    $in = pago_cta($valor_boleta['serie'],$_POST['RUT'],$_POST['t_comprobante'],$n_comprobante,$_POST['tipo_comp'],$n_comprobante,$fecha_mov,$fecha_vto,$_POST['monto'],$_POST['cobrador'],$_GET['CONTRATO'],$_POST['fecha'],'0',$_POST['monto'],$_POST['rendicion']);
    $up = 'UPDATE cta SET afectacion ="'.$n_comprobante.'", cobrador="'.$_POST['cobrador'].'", tipo_comp="'.$_POST['t_comprobante'].'", rendicion="'.$_POST['rendicion'].'" WHERE comprovante="'.$n_comprobante.'"  AND num_solici="'.$_GET['CONTRATO'].'" AND nro_doc="'.$_GET['RUT'].'" AND cod_mov ="'.$cod_mov_afectada.'"';

    //echo 'monto='.$_POST['monto'].' debe='.$valor_boleta['debe'].'<br />';

    if($_POST['monto'] < $valor_boleta['debe']){

        $_POST['monto'] = $valor_boleta['debe'] - $_POST['monto'];

        $in3 = pago_cta('60',$_POST['RUT'],$_POST['t_comprobante'],$n_comprobante,'101',0,$fecha_mov,$fecha_vto,$_POST['monto'],$_POST['cobrador'],$_GET['CONTRATO'],$_POST['fecha'],$_POST['monto'],'0','');
        
//echo $in3;
    }

    if (mysql_query($up) && mysql_query($in)){
        $Q =@mysql_query($in3);
        echo OK;
    }/*
    else{
        echo '<div class="mensaje2">ERROR<br />'.$in.'<br />'.$up.'</div>';
    }*/
}

?>
<h1>Gestor de Pagos</h1>


<div id="g_pago">

<?php

$cta_sql = "SELECT cta.cod_mov as cod_mov_afectada,contratos.factu,contratos.ZO, contratos.SE, contratos.MA,cobrador,cta.tipo_comp, serie, comprovante, DATE_FORMAT(fecha_mov,'%d-%m-%Y') AS fecha_mov,DATE_FORMAT(fecha_vto,'%d-%m-%Y') AS fecha_vto ,debe, haber, t_mov.corta, afectacion, importe
    FROM cta
        LEFT JOIN  t_mov ON t_mov.codigo = cta.cod_mov
        LEFT JOIN contratos ON contratos.num_solici ='".$_GET['CONTRATO']."' AND contratos.titular = '".$_GET['RUT']."'
        LEFT JOIN f_pago ON f_pago.codigo = contratos.estado
        
        WHERE cta.num_solici = '".$_GET['CONTRATO']."' AND cta.nro_doc='".$_GET['RUT']."' AND cta.num_solici='".$_GET['CONTRATO']."'

        AND (cod_mov = '1' || cod_mov = '98' || cod_mov = '99' || cod_mov = '100' || cod_mov = '101' )

        AND afectacion = 0 ORDER BY fecha_mov DESC";

//echo '<br />'.$cta_sql.'<br />';

 $cta_query = mysql_query($cta_sql);

 ?>
    
<form action="BUSQ/M_BUSQ_COB_1.php" method="post" id="pago_men">

<table class="table2">

<tr>
<th>Rendicion</th>
<th><input type="text" name="rendicion"  /></th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
</tr>

<tr>
<td><strong>CUOTA</strong></td><td>
<select name="n_documento">
<?php
 while($cta = mysql_fetch_array($cta_query)){
 ?>
    <option value="<?php echo $cta['comprovante'].'/'.$cta['fecha_mov'].'/'.$cta['fecha_vto'].'/'.$cta['cod_mov_afectada']; ?>"><?php echo $cta['comprovante'].' - '.$cta['fecha_mov'].' - $ '.$cta['importe']; ?></option>
    
<?php

$importe = $cta['importe'];
$factu = $cta['factu'];
$fecha_mov = $cta['fecha_mov'];

}

$cob_asignado_sql = "SELECT cobrador.nro_doc, cobrador.codigo, cobrador.nombre1, cobrador.apellidos FROM
                    contratos
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO =  contratos.ZO AND ZOSEMA.SE =  contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador AND num_solici ='".$_GET['CONTRATO']."'";

$cob_asignado_query = mysql_query($cob_asignado_sql);

$cob_asignado = mysql_fetch_array($cob_asignado_query);

?>
</select>
</td>
<td><strong>COBRADOR</strong></td><td>
<select name="cobrador">
<?php

$cob_sql ="SELECT cobrador.nombre1, cobrador.apellidos, cobrador.codigo, cobrador.nro_doc FROM cobrador WHERE cobrador.nro_doc != '".$cob_asignado['nro_doc']."' ORDER BY codigo";
$cob_query = mysql_query($cob_sql);
?>

    <option value="<?php echo $cob_asignado['codigo']; ?>"><?php echo $cob_asignado['codigo'].' '.$cob_asignado['apellidos'].' '.$cob_asignado['nombre1']; ?></option>
 
 <?php
 while($cob = mysql_fetch_array($cob_query)){
 ?>
    <option value="<?php echo $cob['codigo']; ?>"><?php echo $cob['codigo'].' '.$cob['apellidos'].' '.$cob['nombre1']; ?></option>

<?php
}
?>
</select>

    <input style="display:none;" type="text" value="1" name="Mensualidad" />
    <input style="display:none;" type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="CONTRATO" />
    <input style="display:none;" type="text" value="<?php echo $_GET['RUT']; ?>" name="RUT" />

</td>
<td><strong>Monto</strong></td>
<td><input type="text" name="monto" size="6" value="<?php echo $importe; ?>" /></td>
</tr>

<tr>
<td><strong>Tipo</strong></td>
<td>
    <select name="tipo_comp">

<?php

$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov WHERE operador ='H' AND codigo != '53' AND codigo != '60' AND codigo != '88' AND codigo != '91' AND codigo != '97' ";
$tipo_query = mysql_query($tipo_sql);

 while($tip = mysql_fetch_array($tipo_query)){
 ?>
    <option value="<?php echo $tip['codigo']; ?>"><?php echo $tip['corta'].'-'.$tip['larga']; ?></option>

<?php
}
?>

    </select>
</td>
<td><strong>Fecha</strong></td>
<td><input class="calendario22" name="fecha" type="text" value="<?php echo date('d-m-Y'); ?>" size="10" /></td>
<td><strong>Comprobante</strong></td>
<td>
<select name="t_comprobante">


<?php

$t_doc_sql ="SELECT codigo, descripcion, tipo_doc FROM t_documento WHERE t_documento.codigo != 150 AND t_documento.codigo != 400 AND t_documento.codigo != 500 AND t_documento.codigo != 600 AND tipo_doc != '".$factu."' ORDER BY tipo_doc";



$t_doc_query = mysql_query($t_doc_sql);
?>

    <option value="<?php echo $factu; ?>"><?php echo $factu; ?></option>
    <?php
 while($t_doc = mysql_fetch_array($t_doc_query)){
 ?>
    <option value="<?php echo $t_doc['tipo_doc']; ?>"><?php echo $t_doc['tipo_doc']; ?></option>

<?php
}
?>
</select>

</td>
</tr>
</table>
    <div align="right"> <input type="submit" value="Guardar" class="boton" /> </div>
</form>

</div>

<br />
<?php
$cta = new Cta();
$cta->MuestraCta($_GET['CONTRATO'], $_GET['RUT']);

}


if ($_GET['Afiliados'] > 0 && isset($_GET['CONTRATO'])){

    $afi = new Afiliados;
    $afi->VerAfiliados($_GET['CONTRATO'],'BUSQ/M_BUSQ_SUB_1.php?editar_afi=1','0');

}

?>
