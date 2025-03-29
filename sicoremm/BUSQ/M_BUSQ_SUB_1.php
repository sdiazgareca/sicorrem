<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax1 a:contains("Editar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

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
include_once('../CLA/Domicilio.php');



//DOMICILIOS LISTADO

if($_GET['domicilios']> 0){

$dom = new Domicilio();
$dom->Display( $_GET['CONTRATO'], $_GET['RUT'],'#cont1');


}
//PROCESA CAMBIO DOMICILIO

if($_POST['editar_direccion'] > 0){

    $query = "UPDATE domicilios SET ";
    $num = count($_POST) -4;
    $cont = 0;

    foreach($_POST AS $CAMPO=>$VALOR){

        if($CAMPO != 'nro_doc' && $CAMPO != 'num_solici' && $CAMPO != 'tipo_dom2' && $CAMPO != 'editar_direccion'){

            $query= $query.' '.$CAMPO.'="'.$VALOR.'" ';
            $cont ++;
        }

        if($cont < $num){
            $query = $query.' , ';

        }
    }

$query = $query.' WHERE nro_doc ="'.$_POST['nro_doc'].'" AND num_solici="'.$_POST['num_solici'].'" AND tipo_dom = "'.$_POST['tipo_dom2'].'"';

/* echo '<br />'.$query.'<br />'; */

if(mysql_query($query)){

    echo OK;
}
else{
    echo ERROR;
}

}

//PROCESA CAMBIO

if(isset($_POST['afi'])){


    $datos_contrato = explode("-",$_POST['afi']);

    $num_solici = $datos_contrato[4];
    $titular = $datos_contrato[2];
    $cod_plan = $datos_contrato[0];
    $tipo_plan = $datos_contrato[1];
    $rut_afiado = $datos_contrato[3];

    //CONTRUCTOR DE OBJETOS
    $transaccion = new Datos;
    $fecha = new Datos;
    $rut = new Datos;

    $fecha_nac = $fecha->cambiaf_a_mysql($_POST['fecha_nac']);
    $rut->Rut($_POST['nro_doc']);

    $sql ='SELECT * FROM afiliados WHERE afiliados.nro_doc="'.$rut->nro_doc.'" AND (cod_baja="00" || cod_baja="05")';
    $query = mysql_query($sql);
    $num = mysql_num_rows($query);


    if ($num > 0){
        ?>
            <div class="mensaje2">El afiliado existe como activo en otro contrato.</div>
        <?php
        exit;
    }

    $ingreso_afiliado['cambio_afiliado'] = "UPDATE afiliados SET cod_baja='02' WHERE nro_doc='".$rut_afiado."' AND num_solici='".$num_solici."'";

    $ingreso_afiliado['afiliados'] ="INSERT INTO afiliados (apellido,nombre1,nombre2,sexo,fecha_alta,fecha_act,fecha_ing,fecha_nac,nro_doc,pais,cod_parentesco,cod_baja,categoria,obra_numero,num_solici,titular,cod_plan,tipo_plan)
                        VALUES('".$_POST['apellido']."','".$_POST['nombre1']."','".$_POST['nombre2']."','".$_POST['sexo']."','".date('Y-m-d')."','".date('Y-m-d')."','".date('Y-m-d')."','".$fecha_nac."','".$rut->nro_doc."','600','".$_POST['cod_parentesco']."','00','2','".$_POST['obra_afi']."','".$num_solici."','".$titular."','".$cod_plan."','".$tipo_plan."')";

    //echo $ingreso_afiliado['afiliados'].'<br /><br />';
    //echo $ingreso_afiliado['cambio_afiliado'].'<br /><br />';

    $transaccion->Trans($ingreso_afiliado);

}


//FORMULARIO REMMPLAZAR AFILIADO
if($_GET['Rem_afiliado'] > 0){

    $afi = "SELECT cod_plan,tipo_plan,nombre1,nombre2,apellido,nro_doc, cod_baja, num_solici, titular from afiliados where num_solici='".$_GET['CONTRATO']."' AND categoria != 1";
    $query = mysql_query($afi);

    ?>

<form action="BUSQ/M_BUSQ_SUB_1.php" method="post" id="rem_afiliafo">

<table class="table2">
    <tr>
        <th>Afiliado</th>
        <td>
<select name="afi">
<?php
    while($afiliados = mysql_fetch_array($query)){
        ?>
    <option value="<?php echo $afiliados['cod_plan'].'-'.$afiliados['tipo_plan'].'-'.$afiliados['titular'].'-'.$afiliados['nro_doc'].'-'.$afiliados['num_solici']; ?>"><?php echo $afiliados['nro_doc'].'-'.$afiliados['nombre1'].'-'.$afiliados['nombre2'].'-'.$afiliados['apellido'];?></option>
    <?php
    }
    ?>
</select>
        </td>
    </tr>

</table>

<br />

	<table class="table">
	<tr>
	<td><strong>RUT</strong></td><td><input type="text" name="nro_doc" class="rut"/></td>
	<td><strong>NOMBRE 1</strong></td><td><input type="text" name="nombre1"/></td>
        <td style="display:none;"><input type="text" value="<?php echo $afiliados['num_solici']; ?>"</td>
	</tr>

	<tr>
	<td><strong>NOMBRE 2</strong></td><td><input type="text" name="nombre2"/></td>
	<td><strong>APELLIDOS</strong></td><td><input type="text" name="apellido"/></td>
	</tr>

	<tr>
	<td><strong>SEXO</strong></td><td><select name="sexo"><option value=""></option><option value="M">MASCULINO</option><option value="F">FEMENINO</option></select></td>

	<td><strong>P. DE SALUD</strong></td>
	<td>
	<?php
	$isa_sql = "SELECT nro_doc, descripcion FROM obras_soc";
	$isa_query = mysql_query($isa_sql);

	?>
	<select name="obra_afi">
	<option value=""></option>
	<?php
	while ($isa = mysql_fetch_array($isa_query)){
	?>
	<option value="<?php echo $isa['nro_doc']; ?>"><?php echo $isa['descripcion']; ?></option>
	<?php
	}
	?>
	</select>
	</td>

	</tr>

	<tr>
	<td><strong>F.NAC</strong></td><td><input type="text" name="fecha_nac" class="calendario"/></td>
	<td><strong>PARENTESCO</strong></td>

	<td>

	<?php
	$pare_sql = "SELECT cod_parentesco, glosa_parentesco FROM parentesco WHERE cod_parentesco != 500";
	$pare_query = mysql_query($pare_sql);

	?>
	<select name="cod_parentesco">
	<option value=""></option>
	<?php
	while ($pare = mysql_fetch_array($pare_query)){
	?>
	<option value="<?php echo $pare['cod_parentesco']; ?>"><?php echo $pare['glosa_parentesco']; ?></option>
	<?php
	}
	?>
	</select>

	</td>
	</tr>

	</table>

<div><input type="submit" value="Cambiar" class="boton" /></div>

</form>
    <?php
}

//PROCESA CAMBIO TITULAR
if ($_POST['cambiar_titu'] > 0){

   $sql = "DELETE FROM titulares WHERE titulares.nro_doc NOT IN (SELECT contratos.titular FROM contratos)";
   $query = mysql_query($sql);      
    
$cont = 3;
$num = count($_POST);
$_POST['fecha_nac2'] = $_POST['fecha_nac'];
$fecha_nac = new Datos;
$fecha = $fecha_nac->cambiaf_a_mysql($_POST['fecha_nac']);
$_POST['nro_doc2'] = $_POST['nro_doc'];
$rut = new Datos;

$rut->Rut($_POST['nro_doc']);

$_POST['nro_doc'] = $rut->nro_doc;
$_POST['fecha_nac'] = $fecha;


    foreach ($_POST AS $campo=>$valor){
        
        if($valor == ""){
            echo ERROR3;
            exit;
        }
        
        //echo $campo.'='.$valor.'<br />';

        if ($campo != 'cambiar_titu' && $campo != 'rut_original' && $campo != 'num_solici' && $campo != 'nro_doc2' && $campo != 'fecha_nac2'){

        $camm = $camm.' '.$campo.'="'.$valor.'"';

        $cont ++;

            if ($cont < $num){
                $camm = $camm.' , ';
            }

        }
    }

    $rut = new Datos();
    $rut->Rut($_POST['nro_doc2']);
    $sql ="SELECT nro_doc from titulares where nro_doc = '".$rut->nro_doc."'";
    
    //echo "<p><strong>".$sql."</strong></p>";
    
    $query = mysql_query($sql);

    $num = mysql_num_rows($query);

    if ($num > 0){
        $query2['titulares'] = 'UPDATE titulares SET'.$camm.' WHERE nro_doc="'.$rut->nro_doc.'"';
        
        //echo "<p><strong>".$query2['titulares']."</strong></p>";
        
        }
    else{    
        //$query2['titulares'] = 'UPDATE titulares SET'.$camm.' WHERE nro_doc="'.$_POST['rut_original'].'"';
        
        $fecha = new Datos();
        $fecha_nac = $fecha->cambiaf_a_mysql($_POST['fecha_nac2']);
        
        $query2['titulares'] = "INSERT INTO sicoremm2.titulares 
	(nro_doc,apellido,nombre1, nombre2, fecha_nac,sexo, email, profesion,civil, telefono_emergencia,lugar_de_trabajo,telefono_laboral,ciudad, l_trabajo, telefono_particular)
	VALUES ('".$rut->nro_doc."','".$_POST['apellido']."','".$_POST['nombre1']."','".$_POST['nombre2']."','".$fecha_nac."','".$_POST['sexo']."','".$_POST['email']."','".$_POST['profesion']."','".$_POST['civil']."','".$_POST['telefono_emergencia']."','".$_POST['l_trabajo']."','".$_POST['telefono_laboral']."','".$_POST['ciudad']."','".$_POST['l_trabajo']."','".$_POST['telefono_emergencia']."')";
        
    }

    $query2['contratos'] = 'UPDATE contratos SET titular="'.$_POST['nro_doc'].'" WHERE num_solici ="'.$_POST['num_solici'].'"';
    $query2['afiliados'] = 'UPDATE afiliados SET titular ="'.$_POST['nro_doc'].'" WHERE num_solici ="'.$_POST['num_solici'].'"';
    $query2['afiliados2'] = 'UPDATE afiliados SET categoria ="2" WHERE num_solici ="'.$_POST['num_solici'].'" AND nro_doc="'.$_POST['rut_original'].'"';

    //echo $query['afiliados2'];


    $query2['afiliados3'] = 'UPDATE afiliados SET categoria ="1" WHERE num_solici ="'.$_POST['num_solici'].'" AND nro_doc="'.$_POST['nro_doc'].'"';
    $query2['domicilios'] = 'UPDATE domicilios SET nro_doc="'.$_POST['nro_doc'].'"  WHERE num_solici ="'.$_POST['num_solici'].'" AND nro_doc="'.$_POST['rut_original'].'"';
    $query2['cta'] = 'UPDATE cta SET nro_doc="'.$_POST['nro_doc'].'"  WHERE num_solici ="'.$_POST['num_solici'].'" AND nro_doc="'.$_POST['rut_original'].'"';
    $query2['fichas'] = 'UPDATE fichas SET nro_doc="'.$_POST['nro_doc'].'"  WHERE num_solici ="'.$_POST['num_solici'].'" AND nro_doc="'.$_POST['rut_original'].'"';
    $query2['ventas_reg'] = 'UPDATE ventas_reg SET titular="'.$_POST['nro_doc'].'"  WHERE num_solici ="'.$_POST['num_solici'].'" AND titular="'.$_POST['rut_original'].'"';


    $tran = new Datos;
    $tran->Trans($query2);

   $sql = "DELETE FROM titulares WHERE titulares.nro_doc NOT IN (SELECT contratos.titular FROM contratos)";
   $query = mysql_query($sql);    

}

//FORMULARIO CAMBIO TITULAR

if ($_GET['Cambio_titular'] > 0){

?>
<h1>Titular Actual</h1>
<?php

	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_GET['CONTRATO'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);

        $RUT_TITULAR_ORIGINAL = $_GET['RUT'];

?>
<h1>Nuevo Titular</h1>
<?php

$datos = new Datos;

          echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

	$datos->Formulario($valores,'3',$rut,$calendario,$blok);
	$select = new Select;
?>
<form action="BUSQ/M_BUSQ_SUB_1.php" method="post" id="camfi" name="camfi">
<?php
        echo '<div style="padding:5px;">
            <input style="display:none;" type="text" name="num_solici" value="'.$_GET['CONTRATO'].'"/>
            <input style="display:none;" type="text" name="rut_original" value="'.$RUT_TITULAR_ORIGINAL.'"/>
            <input style="display:none;" type="text" name="cambiar_titu" value="1"/>
            <strong>RUT </strong> <input type="text" name="nro_doc" class="rut"/>
            <strong>APELLIDOS </strong> <input type="text" name="apellido" />
            <strong>P_NOMBRE</strong> <input type="text" name="nombre1" /><br /><br />
            <strong>S_NOMBRE</strong> <input type="text" name="nombre2" />
            <strong>F_NACIMIENTO</strong> <input type="text" name="fecha_nac" class="calendario" />
            <strong>EMAIL</strong> <input type="text" name="email" />

            </div>';


	echo '<div style="padding:5px;">';
	echo '<strong> ESTADO CIVIL  </strong>';
	echo $select->selectSimple('civil','descripcion,codigo','descripcion','codigo','civil','civil','NULL');

	echo '<strong> SEXO </strong>';
	echo '<select name="sexo"><option value="F">FEMENINO</option><option value="M">MASCULINO</option></select>';
	//echo '<strong>Forma de Pago   </strong>';
	//echo $select->selectSimple('civil','descripcion,codigo','descripcion','codigo','civil','civil','NULL');

	echo '<strong> PROFESION </strong>';
	echo $select->selectSimple('profesion','descripcion,codigo','descripcion','codigo','profesion','profesion','NULL');

	echo '<br /><br />';

	echo '<strong> FONO DE EMERGENCIA </strong> <input type="text" name="telefono_emergencia"/>';

	echo '<strong> LUGAR DE TRABAJO </strong>';
	$ciudad = new Select;
	$ciudad->selectSimple('l_trabajo','codigo,nombre','nombre','codigo','l_trabajo','l_trabajo','');

	echo '<br /><br /><strong> FONO LABORAL </strong> <input type="text" name="telefono_laboral"/>';

	echo '<strong> CIUDAD </strong>';
	$ciudad = new Select;
	$ciudad->selectSimple('ciudad','codigo,nombre','nombre','codigo','ciudad','ciudad','');

	echo '</div>';

  ?>
    <div align="right"><input type="submit" value="Cambiar" class="boton" /></div>

</form>
    <?php
}


//PROCESAR EDICION

if ($_POST['guardar_edicion'] > 0){

$num = count($_POST) - 2;
$fecha = new Datos;

$_POST['fecha_nac'] = $fecha->cambiaf_a_mysql($_POST['fecha_nac']);

foreach ($_POST AS $campo=>$valor){
    if ($campo != 'guardar_edicion' && $campo != 'nro_doc'){

        $consulta = $consulta. ' '.$campo.' = "'.$valor.'"';

        $cont = $cont + 1;

        if ($num > $cont){

            $consulta = $consulta. ' , ';

        }
    }
}

$rut = new Datos;
$rut->Rut($_POST['nro_doc']);

$com = "SELECT fecha_baja, cod_baja FROM afiliados WHERE afiliados.nro_doc ='".$rut->nro_doc."' AND num_solici='".$_POST['num_solici']."'";
$com_query = mysql_query($com);

$esta = mysql_fetch_array($com_query);

//01, 02, 03, 09
if ($_POST['cod_baja'] == '01' || $_POST['cod_baja'] == '02' || $_POST['cod_baja'] == '03' || $_POST['cod_baja'] == '09' ||
        $esta['cod_baja'] == '01' || $esta['cod_baja'] == '02' || $esta['cod_baja'] == '03' || $esta['cod_baja'] == '09'){

    $consulta = $consulta.' , fecha_baja="'.date('Y-m-d').'"';
}

$sql = 'UPDATE afiliados SET '.$consulta.' WHERE num_solici="'.$_POST['num_solici'].'" AND nro_doc="'.$rut->nro_doc.'"';

if (mysql_query($sql)){
        $sql2 = 'UPDATE afiliados SET obra_numero="'.$_POST['obra_afi'].'" WHERE num_solici="'.$_POST['num_solici'].'" AND nro_doc="'.$rut->nro_doc.'"';
        mysql_query($sql2);
        echo OK;

        $sec = new Afiliados;
        $sec->Secuencia($_POST['num_solici']);

    }
}


//DATOS DEL CONTRATO
if ($_GET['Contratante'] > 0){

    echo '<h1>DATOS DEL CONTRATO</h1>';


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

//DATOS DEL TITULAR DEL CONTRATO
if ($_GET['Antenciones'] > 0){
    $aten = new Atenciones;
    $aten->MuestraAtenciones($_GET['CONTRATO']);

}

if ($_GET['Mensualidad'] > 0){
$cta = new Cta();
$cta->MuestraCta($_GET['CONTRATO'],$_GET['RUT']);

}
//MUESTRA LOS AFILIADOS DEL CONTRATO
if ($_GET['Afiliados'] > 0 && isset($_GET['CONTRATO'])){

    $afi = new Afiliados;
    $afi->VerAfiliados($_GET['CONTRATO'],'BUSQ/M_BUSQ_SUB_1.php?editar_afi=1','1');

}

if ( $_GET['editar_afi'] > 0 ){
    $editar = new Afiliados;
    $editar->EditarAfiliado_form($_GET['num_solici'],$_GET['titular'],$_GET['nro_doc']);

}

?>
