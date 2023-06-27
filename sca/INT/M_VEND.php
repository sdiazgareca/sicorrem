<script type="text/javascript">
$(document).ready(function() {

$('#ff_edit_free1').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;} 
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	url_ajax ="";
	data_ajax="";
	return false;});

	
$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax3 a:contains("ELIMINAR")').click(function() {

 if(!confirm(" Esta seguro de eliminar el vendedor?")) {
	  return false;} 
  else {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
}  
});

$('#ajax3 a:contains("VER")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Volver")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});



$('#ajax3 a:contains("Editar")').click(function() {

	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Doc")').click(function() {

	var ruta = $(this).attr('href');	
 	$('#sub_1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Vent")').click(function() {

	var ruta = $(this).attr('href');	
 	$('#sub_1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ingVenCon').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;} 
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
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

/* ELIMINAR */
	if ( isset($_GET['ELIMINAR']) ){

		$query_sql = "DELETE FROM sicoremm.vendedor WHERE nro_doc='".$_GET['RUT']."'";
		$query = mysql_query($query_sql);
			if($query){
				echo BORRADO;
			}
			else{
				echo ERROR;
			}
}

/* PROCESA EDIT */
if ($_POST['ff_freelance_edit1']){

foreach ($_POST as $campo => $valor){
	
	if($campo != 'ff_freelance_edit1' || $campo != 'ff_freelance_edit1' ){
	
		if($campo == 'f_nac' || $campo == 'f_renov_contr' || $campo == 'f_inicio_cont'){
			$fecha = new Datos;
			$edicion = $edicion." ".$campo." = '".$fecha->cambiaf_a_mysql($_POST['f_nac'])."',";
		}
		else{
		
		$edicion = $edicion." ".$campo." = '".$valor."', ";
	}
}
}

$cad = substr($edicion,0,strlen($edicion)-2);

$sql = "UPDATE vendedor SET ".$cad." WHERE nro_doc='".$_POST['nro_doc']."'";


if ($query = mysql_query($sql)){
	$_GET['VER']= 1;
	$_GET['COD_CAT'] = $_POST['ff_freelance_edit1'];
	$_GET['RUT'] = $_POST['nro_doc'];
}

else{
	echo ERROR;
}
}

/* EDITAR CONTRATADO */

if ($_GET['EDITAR'] && $_GET['CAT'] == 200){

$sql = "SELECT nombre1,nombre2,apellidos, f_nac,domicilio,fono,celular,email,nro_doc,
AFP,afp_cod,cod_civil, desc_civil,codigo_cargo,vendedor_cargo,isapre,isapre_cod,lnacimiento,
f_inicio_cont,domicilio,fono,celular,email,emer_nombre,emer_fono,emer_celular,alerg,g_san,obser,
f_renov_contr,emer_nombre,emer_fono,emer_celular,s_base,otros,alerg,g_san,obser
FROM vend 
WHERE vend.nro_doc='".$_GET['RUT']."'";

$query = mysql_query($sql);
$vend = mysql_fetch_array($query);
?>
<h1>GESTION VENDEDORES CONTRATADOS</h1>

<form action="INT/M_VEND.php" method="post" id="ingVenCon" name="ingVenCon" >
<div class="caja_cabezera">


<input type="text" name="ff_freelance_edit1" value="200" class="rut" style="display:none"/>

<input type="text" name="nro_doc" value="<?php echo $vend['nro_doc'];?>" size="10" class="rut" style="display:none"/>

&nbsp;Antecedentes Personales

</div> 

<div class="caja">
 <table>
 <tr> 
 <td>
 <label for="ContactName">Nombre</label> <input type="text" name="nombre1" value="<?php echo $vend['nombre1'];?>"/>
 </td>
 <td>
 <label for="ContactName">Nombre 2</label> <input type="text" name="nombre2" value="<?php echo $vend['nombre2'];?>"/>
 </td>
 <td>
 <label for="ContactName">Apellidos</label> <input type="text" name="apellidos" value="<?php echo $vend['apellidos'];?>"/>
 </td>
 </tr>
 
 <tr>
 <td>
 <label for="ContactName">F. Nacimiento</label> <input type="text" name="f_nac" value="<?php echo $vend['f_nac'];?>" class="calendario" maxlength="10" size="10" />
 </td>
 <td>
  <label for="ContactName">L.D.N</label> <input type="text" name="lnacimiento" value="<?php echo $vend['lnacimiento'];?>" size="10"/>
 </td>
 <td> <label for="ContactName">F. Inicio Contrato</label><input name="f_inicio_cont" value="<?php echo $vend['f_inicio_cont'];?>" type="text" class="calendario" maxlength="10" size="10" /></td>
 </tr>
 
 <tr>
 <td> <label for="ContactName">P. de Salud</label>
 
<?php 
$sql = "SELECT `desc`,`codigo` FROM `isapre`";
$query = mysql_query($sql);

echo '<select name="isapre">';
echo '<option value="'.$vend['isapre_cod'].'">'.$vend['isapre'].'</option>';
while ($afp = mysql_fetch_array($query)){
echo '<option value="'.$afp['codigo'].'">'.$afp['desc'].'</option>';
}
echo '</select>';
?>
 
 </td>
 <td><label for="ContactName">A.F.P</label>
<?php 
$sql = "SELECT `desc`,`codigo` FROM `AFP`";
$query = mysql_query($sql);

echo '<select name="AFP">';
echo '<option value="'.$vend['afp_cod'].'">'.$vend['AFP'].'</option>';
while ($afp = mysql_fetch_array($query)){
echo '<option value="'.$afp['codigo'].'">'.$afp['desc'].'</option>';
}
echo '</select>';
?>
 </td>
  <td><label for="ContactName">E. Civil</label> 
  <?php 
  	$sql = "SELECT `descripcion`,`codigo` FROM `civil`";
	$query = mysql_query($sql);
	
	echo '<select name="e_civil">';
	echo '<option value="'.$vend['cod_civil'].'">'.$vend['desc_civil'].'</option>';

	while ($afp = mysql_fetch_array($query)){
		echo '<option value="'.$afp['codigo'].'">'.$afp['descripcion'].'</option>';
	}
	echo '</select>';
  ?></td>  
 </tr>
 
 </table>
 
 <table>
 <tr>
 <td><label for="ContactName">Domicilio</label> <input value="<?php echo $vend['domicilio'];?>" type="text" size="50" name="domicilio"/></td>
 <td><label for="ContactName">Fono Fijo</label> <input value="<?php echo $vend['fono'];?>" type="text" name="fono" size="10" /></td>
 <td><label for="ContactName">Celular</label> <input type="text" name="celular"  value="<?php echo $vend['celular'];?>" size="10"/></td>
 <td><label for="ContactName">Email</label> <input type="text" name="email" value="<?php echo $vend['email'];?>" /></td>   
 </tr>
 </table>

</div>

<div class="caja_cabezera">&nbsp;Grupo Familiar</div>
<div class="caja">&nbsp;</div>

<div class="caja_cabezera">&nbsp;En caso de Emergencia avisar a:</div>
<div class="caja">

 <table>
 <tr>
 <td><label for="ContactName">Nombre</label> <input type="text" name="emer_nombre" value="<?php echo $vend['emer_nombre'];?>"/></td>
 <td><label for="ContactName">Fono</label> <input type="text" name="emer_fono" value="<?php echo $vend['emer_fono'];?>"/></td>
  <td><label for="ContactName">Celular</label> <input type="text" name="emer_celular" value="<?php echo $vend['emer_celular'];?>"/></td>
 </tr>
 </table> 

</div>


<div class="caja_cabezera">&nbsp;Antecedentes del Contrato</div> 
<div class="caja">

<table>
<tr>
<td><label for="ContactName">Cargo Seg&uacute;n Contrato</label></td><td>

  <?php 
    $sql = "SELECT `desc`,`codigo` FROM `cargo_vend`";
	$query = mysql_query($sql);
	
	echo '<select name="cargo">';
	echo '<option value="'.$vend['codigo_cargo'].'">'.$vend['vendedor_cargo'].'</option>';

	while ($afp = mysql_fetch_array($query)){
		echo '<option value="'.$afp['codigo'].'">'.$afp['desc'].'</option>';
	}
	
	echo '</select>';
  ?>

</td>
<td><label for="ContactName">Fecha Ultima Renovaci&oacute;n</label></td>

<td>
<input type="text" name="f_renov_contr" value="<?php echo $vend['f_renov_contr'];?>" class="calendario" maxlength="10" size="10" />
</td>
</tr>

</table>

<table>
<tr>
<td><label for="ContactName">Sueldo Base</label></td><td><input type="text" name="s_base" value="<?php echo $vend['s_base'];?>"/></td>
<td><label for="ContactName">Otros</label></td><td><input type="text" name="otros" value="<?php echo $vend['otros'];?>" /></td>
</tr>
</table>

</div>

<div class="caja_cabezera">&nbsp;Otros</div> 
<div class="caja">

<table>
<tr>
<td><label for="ContactName">Alergico a:&nbsp;</label></td><td><input type="text" name="alerg" value="<?php echo $vend['alerg'];?>" /></td>
<td><label for="ContactName">Grupo Sangu&iacute;neo</label></td><td><input type="text" name="g_san" value="<?php echo $vend['g_san'];?>" /></td>
<td><label for="ContactName">Obervaciones</label></td><td><input type="text" name="obser" value="<?php echo $vend['obser'];?>" /></td>
</tr>
</table>

</div>

<div class="caja_boton">

<a href="INT/M_VEND.php?VER=1&COD_CAT=100&RUT=<?php echo $_GET['RUT']; ?>" class="boton">Volver</a>
<input type="submit" value="Guardar" class="boton">

</div>
</form>

<?php

}


/* EDITAR  FREE LANCE */

if ($_GET['EDITAR'] && $_GET['CAT'] == 100){

$sql = "SELECT nombre1,nombre2,apellidos, f_nac,domicilio,fono,celular,email,
t_domicilio, t_email, t_fono, t_lugar,t_celular ,t_remm 
from vend WHERE vend.nro_doc='".$_GET['RUT']."'";

$query = mysql_query($sql);
$vend = mysql_fetch_array($query);
?>

<form action="INT/M_VEND.php" method="post" name="ff_edit_free1" id="ff_edit_free1">
<div class="caja">
<input type="text" value="<?php echo $_GET['RUT']; ?>" style="display:none" name="nro_doc" />

<table>
 <tr> 
 <td>
 <input type="text" name="ff_freelance_edit1" style="display:none" value="100"/>
 <label for="ContactName">Nombre</label> <input type="text" name="nombre1" value="<?php echo $vend['nombre1'];?>"/>
 </td>
 <td>
 <label for="ContactName">Nombre 2</label> <input type="text" name="nombre2" value="<?php echo $vend['nombre2'];?>"/>
 </td>
 <td>
 <label for="ContactName">Apellidos</label> <input type="text" name="apellidos" value="<?php echo $vend['apellidos'];?>"/>
 </td>
 </tr>
 
 <tr>
 <td><label for="ContactName">F. Nacimiento</label> <input type="text" class="calendario" name="f_nac" size="10" maxlength="10" value="<?php $fecha = new Datos; echo $fecha->cambiaf_a_mysql($vend['f_nac']);?>" /></td>
 
 <td>&nbsp;</td>
 
 </tr>
 </table>
 
 <table>
 <tr>
 <td><label for="ContactName">Domicilio</label> <input type="text" name="domicilio" size="50" value="<?php echo $vend['domicilio'];?>"/></td> 
 <td><label for="ContactName">Fono Fijo</label> <input type="text" name="fono" size="10" value="<?php echo $vend['fono'];?>"/></td>
 <td><label for="ContactName">Celular</label> <input type="text" name="celular" size="10" value="<?php echo $vend['celular'];?>"/></td> 
 <td><label for="ContactName">Email</label> <input type="text" name="email" size="10" value="<?php echo $vend['email'];?>"/></td>  
 </tr>
 </table>

</div>

<div class="caja_cabezera">&nbsp;Antecedentes Laborales</div>
 
<div class="caja">

<table>
<tr>
<td>Lugar de Trabajo</td><td><input type="text" name="t_lugar" value="<?php echo $vend['t_lugar'];?>" /></td>
<td>Domicilio de Trabajo</td><td><input type="text" name="t_domicilio" value="<?php echo $vend['t_domicilio'];?>" /></td>
</tr>

<tr>
<td>Fono Trabajo</td><td><input type="text" name="t_fono" value="<?php echo $vend['t_fono'];?>" /></td>
<td>Celular Trabajo</td><td><input type="text" name="t_celular" value="<?php echo $vend['t_celular'];?>" /></td>
<td>Email Trabajo</td><td><input type="text" name="t_email" value="<?php echo $vend['t_email'];?>" /></td>
</tr>

<?php 
$chek = "";

if ($vend['t_remm'] == '1'){
	$chek = 'checked="checked"';
}
?>

<tr>
<td>Funcionario ReMM <input type="checkbox" name="t_remm" value="1" <?php echo $chek;?>/></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>

</div>

<div class="caja_boton">
<a href="INT/M_VEND.php?VER=1&COD_CAT=100&RUT=<?php echo $_GET['RUT']; ?>" class="boton">Volver</a>
<input type="submit" value="Guardar" class="boton"></div>

</div>
</form>
<?php 
}


/* VISTA VENDEDOR */
if ($_GET['VER']){
	$ing = new Datos;	
	
	if ($_GET['COD_CAT'] > 99 && $_GET['COD_CAT'] < 101){	
		$personal = array("nro_doc AS RUT"=>"","nombre1 AS PRIMER_NOMBRE"=>"","nombre2 AS SEGUNDO_NOMBRE"=>"","apellidos AS APELLIDOS"=>"","f_nac AS F_NACIMIENTO"=>"","domicilio AS DOMICILIO"=>"","fono AS FONO"=>"","celular AS CELULAR"=>"","email AS EMAIL"=>"");		
		$laboral = array("t_lugar AS LUGAR_DE_TRABAJO"=>"","t_domicilio AS DOMICILIO_TRABAJO"=>"","t_fono AS FONO_TRABAJO"=>"","t_email AS EMAIL_TRABAJO"=>"","t_celular AS CELULAR_TRABAJO"=>"","t_remm AS TRABAJADOR_REMM"=>"");
		$rut = array("RUT"=>"");
		$where = array("nro_doc ="=>$_GET['RUT']);
		echo "<div class='caja'><strong>ANTECEDENTES PERSONALES</strong></div>";
		$ing->Imprimir($personal,'vend',$where,3,$rut);	
		echo "<div class='caja'><strong>ANTECEDENTES LABORALES</strong></div>";
		$ing->Imprimir($laboral,'vend',$where,3,$rut);	
		echo '<br />';
		echo '<div style="display:20px" align="right"><a href="INT/M_VEND.php?EDITAR=1&RUT='.$_GET['RUT'].'&CAT=100" class="boton">Editar</a> 
		<a href="INT/SUB_M_VEND_1.php" class="boton">Doc</a>
		<a href="INT/SUB_M_VEND_1.php" class="boton">Vent</a></div>';
	}	
	
	if ($_GET['COD_CAT'] > 199 && $_GET['COD_CAT'] < 201){
		$rut = array("RUT"=>"");
		$where = array("nro_doc ="=>$_GET['RUT']);				
		$laboral = array("nro_doc AS RUT"=>"","nombre1 AS PRIMER_NOMBRE"=>"","nombre2 AS SEGUNDO_NOMBRE"=>"","apellidos AS APELLIDOS"=>"","f_nac AS F_NACIMIENTO"=>"","domicilio AS DOMICILIO"=>"","fono AS FONO"=>"","celular AS CELULAR"=>"","email AS EMAIL"=>"","lnacimiento AS FECHA_NACIMIENTO"=>"","isapre AS ISAPRE"=>"","afp AS AFP"=>"","f_inicio_cont AS F_INICIO_CONTRATO"=>"");
		$emergencia = array("emer_nombre AS NOMBRE"=>"","emer_fono AS FONO"=>"","emer_celular AS CELULAR"=>"");
		$contrato = array("vendedor_cargo AS CARGO_SEGUN_CONTRATO"=>"","f_renov_contr AS FECHA_ULTIMA_RENOVACION"=>"","s_base AS SUELDO_BASE"=>"","otros AS OTROS"=>"");
		$otros = array("alerg AS ALEGICO_A"=>"","g_san AS GRUPO_SANGUINEO"=>"","obser AS OBSERVACIONES"=>"");
		
		echo "<div class='caja'><strong>ANTECEDENTES PERSONALES</strong></div>";		
		$ing->Imprimir($laboral,'vend',$where,2,$rut);	
		
		echo "<div class='caja'><strong>EN CASO DE EMERGENCIA</strong></div>";		
		$ing->Imprimir($emergencia,'vend',$where,3,$rut);
		
		echo "<div class='caja'><strong>ANTECEDENTES DEL CONTRATO</strong></div>";		
		$ing->Imprimir($contrato,'vend',$where,2,$rut);	
		
		echo "<div class='caja'><strong>OTROS</strong></div>";		
		$ing->Imprimir($otros,'vend',$where,3,$rut);	
		
		echo '<br />';
		echo '<div style="display:20px" align="right"><a href="INT/M_VEND.php?EDITAR=1&RUT='.$_GET['RUT'].'&CAT=200" class="boton">Editar</a>
		<a href="INT/SUB_M_VEND_1.php" class="boton">Doc</a>
		<a href="INT/SUB_M_VEND_1.php" class="boton">Vent</a></div>';		
	}	
	
}

/* LISTADO DE VENDEDORES */
if ( (isset($_POST['ff_vend'])) || (isset($_GET['codigo_cat'])) ){

	foreach($_POST as $campo => $valor){ 
		if ($valor != $_POST['ff_vend'] && $valor != ""){
			if (is_numeric($valor)){
				$condicion[$campo]=" = ".$valor;
			}
			else{
				if($valor != 'TODOS'){
					$condicion[$campo]=" LIKE '".$valor."%'";
				}					
			}
		}
	}
	
	$datos = new Datos;
	$campos = array("nro_doc AS RUT"=>"","nombre1 AS PRIMER_NONBRE"=>"","nombre2 AS SEGUNDO_NOMBRE"=>"","apellidos AS APELIIDOS"=>"","categoria AS CAT"=>"","codigo_cat AS COD_CAT"=>"");
	$eliminar = array('RUT'=>"");
	$ver = array('RUT'=>"","COD_CAT"=>"");	
	$rut = array('RUT'=>"");
	$var_ver = array('VER'=>'1');
	$var_eli = array('ELIMINAR'=>'1');	
	$datos->Listado_per($campos,'vend',$condicion,'VER','ELIMINAR',$ver,$eliminar,'INT/M_VEND.php',$rut,$var_ver,$var_eli,'table');
	
}
	
/* FECHAS */
$fechas = new Datos;
$f_nac = $fechas->cambiaf_a_mysql($_POST['ff_nac']);
$fechas_free = array("f_nac"=>$f_nac);
$f_inicio_cont = $fechas->cambiaf_a_mysql($_POST['ff_inicio_cont']);
$f_renov_contr = $fechas->cambiaf_a_mysql($_POST['ff_renov_contr']);

$fechas_cont = array("f_inicio_cont"=>$f_inicio_cont,"f_nac"=>$f_nac,"f_renov_contr"=>$f_renov_contr);


/*ING VENDEDORES */
if ( (isset($_POST['ff_freelance'])) || (isset($_POST['ff_contratado'])) ){
	

	
	$datos = new Datos;
	$datos->Rut($_POST['nro_doc']);		
	$campos = array('nro_doc'=>$datos->nro_doc);
	
		if ( ($num = $datos->ComDataUni($campos,'vendedor')) < 1){
			$cod = array('cat'=>'100','estado'=>'1');
		
		if (isset($_POST['ff_freelance'])){
			$cod = array('cat'=>'100', 'estado'=>'1');
			$datos->INSERT_PoST('vendedor','',$fechas_free,$cod);}
		
		if (isset($_POST['ff_contratado'])){
			$cod = array('cat'=>'200', 'estado'=>'1');
			$datos->INSERT_PoST('vendedor','',$fechas_cont,$cod);}
		
		if (mysql_query($datos->query)){
					echo INGRE_OK;
			}			
		}
		
		else{			
			echo ERROR_RUT;
		}
}

/* cerrar conexion */
mysql_close($conexion);
?>
<br />
<div id="sub_1"></div>
