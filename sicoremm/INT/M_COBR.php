<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});	
	
$('#ajax3 a:contains("Eliminar")').click(function() {

 if(!confirm(" Esta seguro de eliminar el recaudador?")) {
	  return false;} 
  else {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
}  
});

$('#ajax4 a:contains("ELI")').click(function() {

	 if(!confirm(" Esta seguro de eliminar el ZO-SE-MA?")) {
		  return false;} 
	  else {
		var ruta = $(this).attr('href');	
	 	$('#ajax4').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	}  
	});


$('#ajax3 a:contains("Ver")').click(function() {
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

$('#ajax3 a:contains("Volver")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 #ingCob').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios en el recaudador?")) {
		  return false;} 
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

$('#ajax3 #zosema_').submit(function(){
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax4').html(data);}}) 
	
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

/* ELIMINAR COBRADOR */
	if ( isset($_GET['ELIMINAR']) ){

		$query_sql = "DELETE FROM sicoremm2.cobrador WHERE nro_doc='".$_GET['RUT']."'";
		$query = mysql_query($query_sql);
			if($query){
				echo BORRADO;
			}
			else{
				echo ERROR;
			}
	}

/* PROCESAR */
if($_POST['cob_edit1'] > 0){


foreach ($_POST as $campo => $valor){
	
	if($campo != 'cob_edit1' && $campo != 'ff_freelance_edit1' ){
	
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

$sql = "UPDATE cobrador SET ".$cad." WHERE nro_doc='".$_POST['nro_doc']."'";


if ($query = mysql_query($sql)){
	$_GET['VER']= 1;
	$_GET['RUT'] = $_POST['nro_doc'];
}

else{
	echo ERROR;
}


}		
	
/*EDITAR*/

if ($_GET['EDITAR'] > 0){
		

$sql = "SELECT nombre1,nombre2,apellidos, f_nac,domicilio,fono,celular,email,nro_doc,
AFP,afp_cod,e_civil, desc_civil,isapre,isapre_cod,lnacimiento,
f_inicio_cont,domicilio,fono,celular,email,emer_nombre,emer_fono,emer_celular,alerg,g_san,obser,
f_renov_contr,emer_nombre,emer_fono,emer_celular,s_base,otros,alerg,g_san,obser
FROM cob 
WHERE cob.nro_doc='".$_GET['RUT']."'";

$query = mysql_query($sql);
$vend = mysql_fetch_array($query);

?>
<h1>GESTION RECAUDADORES</h1>

<form action="INT/M_COBR.php" method="post" id="ingCob" name="ingCob" >
<div class="caja_cabezera">


<input type="text" name="cob_edit1" id="cob_edit1" value="1" class="rut" style="display:none"/>

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
	echo '<option value="'.$vend['e_civil'].'">'.$vend['desc_civil'].'</option>';

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

<a href="INT/M_COBR.php?VER=1&RUT=<?php echo $_GET['RUT']; ?>" class="boton">Volver</a>
<input type="submit" value="Guardar" class="boton">

</div>
</form>
<?php 
}
	
/* VISTA COBRADOR */
if ($_GET['VER']){

	$ing = new Datos;	
		
	$rut = array("RUT"=>"");
	$where = array("nro_doc ="=>$_GET['RUT']);				
	$laboral = array("codigo AS COD"=>"","nro_doc AS RUT"=>"","nombre1 AS PRIMER_NOMBRE"=>"","nombre2 AS SEGUNDO_NOMBRE"=>"","apellidos AS APELLIDOS"=>"","f_nac AS F_NACIMIENTO"=>"","domicilio AS DOMICILIO"=>"","fono AS FONO"=>"","celular AS CELULAR"=>"","email AS EMAIL"=>"","lnacimiento AS FECHA_NACIMIENTO"=>"","isapre AS ISAPRE"=>"","afp AS AFP"=>"","f_inicio_cont AS F_INICIO_CONTRATO"=>"");
	$emergencia = array("emer_nombre AS NOMBRE"=>"","emer_fono AS FONO"=>"","emer_celular AS CELULAR"=>"");
	$contrato = array("f_renov_contr AS FECHA_ULTIMA_RENOVACION"=>"","s_base AS SUELDO_BASE"=>"","otros AS OTROS"=>"");
	
	echo "<div class='caja'><strong>ANTECEDENTES PERSONALES</strong></div>";		
	
	$ing->Imprimir($laboral,'cob',$where,3,$rut);	
	echo "<div class='caja'><strong>EN CASO DE EMERGENCIA</strong></div>";		
	$ing->Imprimir($emergencia,'cob',$where,3,$rut);
	echo "<div class='caja'><strong>ANTECEDENTES DEL CONTRATO</strong></div>";		
	$ing->Imprimir($contrato,'cob',$where,3,$rut);
	
	echo '<div style="padding:10px"><a href="INT/M_COBR.php?RUT='.$_GET['RUT'].'&EDITAR=1" class="boton">Editar</a> </div>';
	
	echo '<form method="post" action="INT/SUB_M_COBR_1.php" id="zosema_">';
	
	echo "<div class='caja'><strong>ZO - SE - MA</strong> ";	
	
	$ZOSEMA= "SELECT ZO, SE, MA FROM ZOSEMA WHERE estado = 0";
	$query = mysql_query($ZOSEMA);
	
	echo '<input type="text" value="'.$_GET['RUT'].'" name="cobrador" style="display:none"/>';
	
	echo '<select name="ff_zosema">';
	
	while($zose = mysql_fetch_array($query)){
	
		echo '<option value="'.$zose['ZO'].'-'.$zose['SE'].'-'.$zose['MA'].'">'.$zose['ZO'].'-'.$zose['SE'].'-'.$zose['MA'].'</option>';
	
	}
	
	echo '</select>';
	
	echo ' <input type="submit" value="Asignar" class="boton" />';
	
	echo '</div>';
	
	echo '<br />';
	
	
	echo '<div class="caja" id="ajax4">';
	
	$var = new Datos;
	
	$campos = array("ZO"=>"","SE"=>"","MA"=>"","descripcion"=>"");
	$where = array("cobrador"=>" = '".$_GET['RUT']."'");
	$get1 = array("VER"=>"1"); 
	$get2 = array("ELIMINAR"=>"1","cobrador"=>$_GET['RUT']);
	$rut = array("NULL"=>"");
	$get1_var = array("ZO"=>"","SE"=>"","MA"=>"");
	
	$var->Listado_per($campos,"ZOSE",$where,"","ELI",$get1_var,$get1_var,"INT/SUB_M_COBR_1.php",$rut,$get1,$get2,"table2");
	
	echo '</div>';
	
	echo '</form>';
	
	exit;		
		
}

/* LISTADO DE VENDEDORES */
if ($_POST['ff_busq'] > 0){

	foreach($_POST as $campo => $valor){ 
		if ($valor != $_POST['ff_busq'] && $valor != ""){
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
	$campos = array("codigo AS COD"=>"","nro_doc AS RUT"=>"","nombre1 AS PRIMER_NONBRE"=>"","nombre2 AS SEGUNDO_NOMBRE"=>"","apellidos AS APELIIDOS"=>"");
	$eliminar = array('RUT'=>'');
	$ver = array('RUT'=>'');	
	$rut = array('RUT'=>'');
	$var_ver = array('VER'=>'1');
	$var_eli = array('ELIMINAR'=>'1');	
	$datos->Listado_per($campos,'cobrador',$condicion,'Ver','Eliminar',$ver,$eliminar,'INT/M_COBR.php',$rut,$var_ver,$var_eli,'table');
	
}
	
/* FECHAS */
$fechas = new Datos;
$f_nac = $fechas->cambiaf_a_mysql($_POST['ff_nac']);
$fechas_free = array("f_nac"=>$f_nac);
$f_inicio_cont = $fechas->cambiaf_a_mysql($_POST['ff_inicio_cont']);


$fechas_cont = array("f_inicio_cont"=>$f_inicio_cont,"f_nac"=>$f_nac);


/*ING VENDEDORES */

if ($_POST['ff_ingreso'] > 0){
	
	
	$datos = new Datos;
	$datos->Rut($_POST['nro_doc']);		
	$campos = array('nro_doc'=>$datos->nro_doc);
	$campos2 = array('codigo'=>$_POST['codigo']);
	
	
	
		if ( ($num = $datos->ComDataUni($campos,'cobrador')) < 1  && ($num2 = $datos->ComDataUni($campos2,'cobrador')) < 1 ){

			$cod = array('estado'=>'1');
			
			$datos->INSERT_PoST('cobrador','',$fechas_cont,$cod);
			
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