<script type="text/javascript">
$(document).ready(function() {


	$('#ajax3 a:contains("MODIFICAR")').click(function() {
		var ruta = $(this).attr('href');	
	 	$('#secuencia').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	  
	});

	$('#ajax3 a:contains("EDITAR")').click(function() {
		var ruta = $(this).attr('href');	
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	  
	});
	

	$('#ajax3 a:contains("CAMBIAR")').click(function() {
		var ruta = $(this).attr('href');	
	 	$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	  
	});

	$('#ajax3 a:contains("ELIMINAR")').click(function() {

		 if(!confirm(" Esta seguro de eliminar el estado del Plan?")) {
			  return false;} 
		  else {
			var ruta = $(this).attr('href');	
		 	$('#secuencia').load(ruta);
			$.ajax({cache: false});
			ruta = "";
		 	return false;
		}  
		});
		
	
$('#form_secuencia').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#secuencia').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});


$('#editVenCon').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});


$('a:contains("VER")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$datos = new Datos;



/* PROCESO EDITAR */

if ($_POST['ff_editar'] > 0){

$cont = 0;
$max = count($_POST) - 4;

	foreach($_POST AS $campo=>$valor){
		
		if ($campo != 'cod_plan' && $campo != 'ff_editar' && $campo != 'tipo_plan'){
			
			$camp = $camp.' '.$campo.' = "'.$valor.'"';
			
			if ($cont < $max){
				$camp = $camp.', ';				
			}
			$cont = $cont + 1;
		}
		
	
	}
	
	$sql = 'UPDATE planes SET '.$camp.' WHERE cod_plan="'.$_POST['cod_plan'].'" AND tipo_plan="'.$_POST['tipo_plan'].'"';
	
	if (mysql_query($sql)){
	
		$_GET['VER'] = 1;
		$_GET['ESTADO'] = 1;
		$_GET['CODIGO'] = $_POST['cod_plan'];
		$_GET['TIPO'] = $_POST['tipo_plan'];
	
	}
	else{
		echo ERROR;
		exit;
	}
	
}



/* EDITAR PLANN */

if ($_GET['EDITAR_PLAN'] > 0){
	
	$plann = new Datos;
	
	$sql = "SELECT v_incor,cod_plan AS COD_PLAN,desc_plan AS NOMBRE_PLAN,copago AS VALOR_COPAGO,casa_p AS CASA_PROTEGUIDA,cm_gratis AS ATEN_SIN_COPAGO,
tiempo AS PERIODO_ATEN_SIN_COPAGO,tipo_plan_desc AS TIPO_PLAN,estado AS ESTADO,f_ingreso AS FECHA_INGRESO,n_inco_grat
FROM plann WHERE cod_plan = '".$_GET['cod_plan']."' AND cod_tipo_plan = '".$_GET['tipo_plan']."'";
	
	$query = mysql_query($sql);
	
	while($valores = mysql_fetch_array($query) ){
		
?>

<h1>EDITAR PLAN</h1>

<form action="INT/M_PLAN.php" method="post" id="editVenCon" name="editVenCon" >
<div class="caja_cabezera">

Descrici&oacute;n del Plan

</div> 

<div class="caja">
 <input type="text" name="ff_editar" value="1" style="display:none"/>
 <input type="text" name="cod_plan" size="3" maxlength="3" style="display:none" value="<?php echo $valores['COD_PLAN']; ?>"/>
 <input type="text" name="tipo_plan" value="<?php echo $_GET['tipo_plan']; ?>" style="display:none"/>
 
 <table>
<tr> 
 <td><label for="ContactName">Nombre</label><input type="text" value="<?php echo $valores['NOMBRE_PLAN']; ?>" name="desc_plan" /></td>
 <td><label for="ContactName">Valor Copago</label></td><td><input type="text" name="copago" value="<?php echo $valores['VALOR_COPAGO']; ?>" /></td>
 </tr>
 
<tr>

<td><label for="ContactName">Casa Protegida</label>&nbsp;&nbsp;

<?php 

if ($valores['CASA_PROTEGUIDA'] == "SI"){
$si = "checked";
$no = "";
}
else{
$no = "checked";
$si = "";

}

?>

SI <input name="casa_p" type="radio" value="SI" <?php echo $si; ?> />
NO <input name="casa_p" type="radio" value="NO" <?php echo $no; ?>/>

</td>
<td>N&uacute;mero de Atenciones Sin Copago</td>
<td><input value="<?php echo $valores['ATEN_SIN_COPAGO']; ?>" type="text" size="2" maxlength="2" name="cm_gratis" />&nbsp;

<select name="tiempo">
<option value="<?php echo strtoupper($valores['PERIODO_ATEN_SIN_COPAGO']); ?>"><?php echo $valores['PERIODO_ATEN_SIN_COPAGO']; ?></option>
<option value="ANUAL">Anual</option>
<option value="MENSUAL">Mensual</option>
</select>
</td>
</tr>

<tr>
<td><strong>V_INCOR</strong>&nbsp;<input type="text" name="v_incor" value="<?php echo $valores['v_incor']; ?>" /></td>
<td><strong>N_INCO_SP</strong></td><td><input type="text" name="n_inco_grat" value="<?php echo $valores['n_inco_grat']; ?>"</td>
</tr>
</table>

</div>

<div class="caja_boton"><input type="submit" value="Guardar" class="boton"></div>
</form>	
<?php 
	
}
	
	

	
	exit;
}



/* PLANN */
if( (isset($_GET['VER'])) ){
	
	echo '<div class="caja"><strong>DETALLE PLAN</strong></div>';
	$campos = array("cod_plan AS COD_PLAN"=>"","desc_plan AS NOMBRE_PLAN"=>"","copago AS VALOR_COPAGO"=>"","casa_p AS CASA_PROTEGUIDA"=>"","cm_gratis AS ATEN_SIN_COPAGO"=>"","tiempo AS PERIODO_ATEN_SIN_COPAGO"=>"","tipo_plan_desc AS TIPO_PLAN"=>"","estado AS ESTADO"=>"","f_ingreso AS FECHA_INGRESO"=>"","v_incor AS V_INORP"=>"",'n_inco_grat AS N_INCO_SN'=>'');
	$rut = array('NULL'=>"");
	$condicion= array("cod_plan ='"=>$_GET['CODIGO']."'","cod_tipo_plan = '"=>$_GET['TIPO']."'");		
	echo "<div class='caja'>";
	$datos->Imprimir($campos,'plann',$condicion,2,$rut);
	echo "</div>";
	
	echo '<div style="padding:10px"><a class="boton" href="INT/M_PLAN.php?EDITAR_PLAN=1&cod_plan='.$_GET['CODIGO'].'&tipo_plan='.$_GET['TIPO'].'">EDITAR</a></div>';
	echo '<table><tr><td><form action="INT/SUB_M_PLAN_1.php" method="post" id="form_secuencia"><div class="caja"><p><strong>CONFIGURACION</strong></p><table class="sub_menu"><tr><td style="display:none;"><input type="text" name="cod_plan" value="'.$_GET['CODIGO'].'" /></td><td style="display:none;"><input type="text" name="tipo_plan" value="'.$_GET['TIPO'].'" /></td><td><strong>SECUENCIA</strong>&nbsp;<input type="text" name="secuencia" size="5" maxlength="2" /></td><td><strong>VALOR</strong>&nbsp;<input type="text" name="valor" size="8" maxlength="8" /></td><td>&nbsp;</td><td><input type="submit" value="Guardar" /></td></tr></table></div></form><div class="caja" id="secuencia">';
	
	
	
	$datos = new Datos;
		
	//Imprimir scuencia
	$campos = array("secuencia AS SECUENCIA"=>"","valor AS VALOR"=>"","cod_plan AS COD"=>"","tipo_plan AS CAT"=>"");	
	$eliminar = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");
	$ver = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");		
	$rut = array("NULL"=>"");
	$var_ver = array("MODIFICAR"=>'1');
	$var_eli = array("ELIMINAR"=>'1');	
	$condicion = array("cod_plan = '"=>$_GET['CODIGO']."'","tipo_plan = '"=>$_GET['TIPO']."'");
	$datos->Listado_per($campos,'valor_plan',$condicion,'MODIFICAR','ELIMINAR',$ver,$eliminar,'INT/SUB_M_PLAN_1.php',$rut,$var_ver,$var_eli,'table2');
	echo '</div></div>';
}

//ELIMINAR PLAN

if ( isset($_GET['CAMBIAR']) ){
	$baja = new Datos;
	
	//echo $_GET['ESTADO'];
	
		if($_GET['ESTADO'] == 'ACTIVO'){
			$camp = 'INACTIVO';
		}
		if ($_GET['ESTADO'] == 'INACTIVO'){
			$camp = 'ACTIVO';		
		}
		if ($_GET['ESTADO'] == ""){
			$camp = 'ACTIVO';		
		}
	
	$campos = array("estado"=>$camp);
	$condicion = "WHERE cod_plan='".$_GET['CODIGO']."' AND tipo_plan='".$_GET['TIPO']."'";	
	$baja->UPDATE_Param('planes',$campos,$condicion);
	
	if (mysql_query($baja->query)){
		echo OK;
	}
	else{
		echo ERROR;
	}
	
} 

//BUSQUEDA

if ($_POST['ff_bus_plan']){

	foreach($_POST as $campo => $valor){ 
   		
		if ($valor != $_POST['ff_bus_plan'] && $valor != ""){
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
	
	$planes = new Datos;
	$get1 = array("CODIGO"=>"","TIPO"=>"","ESTADO"=>"");
	$get2 = array("CODIGO"=>"","TIPO"=>"","ESTADO"=>"");	
	$get1_var = array("VER"=>'1');
	$get2_var = array("CAMBIAR"=>'1');	
	$campos = array("cod_plan AS CODIGO"=>"","tipo_plan AS TIPO"=>"","desc_plan AS PLAN"=>"","ESTADO"=>"");
	$rut = array("NULL"=>"");
	$planes->Listado_per($campos,"planes",$condicion,"VER","CAMBIAR",$get1,$get2,"INT/M_PLAN.php",$rut,$get1_var,$get2_var,"table");

}

//LISTADO
if (isset($_GET['tipo_plan']) ){
	
	$planes = new Datos;
	$get1 = array("CODIGO"=>"","TIPO"=>"","ESTADO"=>"");
	$get2 = array("CODIGO"=>"","TIPO"=>"","ESTADO"=>"");	
	$get1_var = array("VER"=>'1');
	$get2_var = array("CAMBIAR"=>'1');	
	$campos = array("cod_plan AS CODIGO"=>"","tipo_plan AS TIPO"=>"","desc_plan AS PLAN"=>"","ESTADO"=>"");
	$condicion =array("tipo_plan ='"=>$_GET['tipo_plan']."'");
	$rut = array("NULL"=>"");
	$planes->Listado_per($campos,"planes",$condicion,"VER","CAMBIAR",$get1,$get2,"INT/M_PLAN.php",$rut,$get1_var,$get2_var,"table");
}

/* INGRESO PLAN */
if (isset($_POST['ff_indreso']) ){	

		$estado = array("estado"=>"ACTIVO","f_ingreso"=>date('Y-m-d'));
		$datos->INSERT_PoST('planes','',$estado,$_POST['cod_plan']);		
	
		
		if ( mysql_query($datos->query) ){	
			echo '<div class="caja"><strong>DETALLE PLAN</strong></div>';
			
			//Imprimir Detalle PLan
			$rut = array("NULL"=>"");
			$campos = array("cod_plan AS COD_PLAN"=>"","desc_plan AS NOMBRE_PLAN"=>"","copago AS VALOR_COPAGO"=>"","casa_p AS CASA_PROTEGUIDA"=>"","cm_gratis AS ATEN_SIN_COPAGO"=>"","tiempo AS PERIODO_ATEN_SIN_COPAGO"=>"","tipo_plan_desc AS TIPO_PLAN"=>"","estado AS ESTADO"=>"","f_ingreso AS FECHA_INGRESO"=>"");
			$condicion = array("cod_plan ='"=>$_POST['cod_plan']."'","cod_tipo_plan ='"=>$_POST['tipo_plan']."'");
			echo "<div class='caja'>";
			$datos->Imprimir($campos,'plann',$condicion,2,$rut);
			echo "</div>";
			echo '<div style="padding:10px"><a class="boton" href="INT/M_PLAN.php?EDITAR_PLAN=1&cod_plan='.$_POST['cod_plan'].'&tipo_plan='.$_POST['tipo_plan'].'">EDITAR</a></div>';
			echo '<table><tr><td><form action="INT/SUB_M_PLAN.php" method="post" id="form_secuencia"><div class="caja"><p><strong>CONFIGURACION</strong></p><table class="sub_menu"><tr><td style="display:none;"><input type="text" name="cod_plan" value="'.$_POST['cod_plan'].'" /></td><td style="display:none;"><input type="text" name="tipo_plan" value="'.$_POST['tipo_plan'].'" /></td><td><strong>SECUENCIA</strong>&nbsp;<input type="text" name="secuencia" size="5" maxlength="2" /></td><td><strong>VALOR</strong>&nbsp;<input type="text" name="valor" size="8" maxlength="8" /></td><td>&nbsp;</td><td><input type="submit" value="Guardar" /></td></tr></table></div></form><div class="caja" id="secuencia">';
			
			//Imprimir scuencia
			$campos = array("secuencia AS SECUENCIA"=>"","valor AS VALOR"=>"","cod_plan AS COD"=>"","tipo_plan AS CAT"=>"");	

			$eliminar = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");
			$ver = array("COD"=>"","CAT"=>"","SECUENCIA"=>"","VALOR"=>"");	
	
			$rut = array("NULL"=>"");
			$var_ver = array("MODIFICAR"=>'1');
			$var_eli = array("ELIMINAR"=>'1');	
			$condicion = array("cod_plan = '"=>$_POST['cod_plan']."'","tipo_plan = '"=>$_POST['tipo_plan']."'");
			$datos->Listado_per($campos,'valor_plan',$condicion,'MODIFICAR','ELIMINAR',$ver,$eliminar,'INT/SUB_M_PLAN_1.php',$rut,$var_ver,$var_eli,'table2');
			echo '</div></div>';
		}
		else{
			echo ERROR;
		}
}
/* cerrar conexion */
mysql_close($conexion);
?>
