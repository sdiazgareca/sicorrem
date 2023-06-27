<script type="text/javascript">
$(document).ready(function() {

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

$('#ajax3 a:contains("ASIGNAR")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ASIG_ZOSE').submit(function(){

	 if(!confirm(" Esta seguro de asignar la ZONA al recaudador?")) {
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
		
		$cont = 0;
		$num = count($_GET) - 1;
		$mat = 'WHERE';
		
		foreach($_GET as $campo => $valor){ 
		
			if($campo != 'ELIMINAR'){
				$mat = $mat.' '.$campo.'='."'".$valor."'";
			}
			
			$cont = $cont +1;	
			
			if ($cont < $num){
				$mat = $mat.' AND';
			}
		}		
	
		$query_sql = "DELETE FROM ZOSEMA ".$mat;
		
		$query = mysql_query($query_sql);
			
		if($query){
				echo BORRADO;
			}
		
		else{
				echo ERROR;
			}
	}

	
/* PROCESA ASIGNACION */
if ($_POST['AIGG'] > 0){

$query = 'UPDATE ZOSEMA SET cobrador="'.$_POST['cob'].'",  estado=1 
WHERE ZO="'.$_POST['ZO'].'" AND SE="'.$_POST['SE'].'" AND MA="'.$_POST['MA'].'"';

if (mysql_query($query)){
	echo OK;
}

else{
echo ERROR;
}

}		
	
/* ASIGNACION */
if ($_GET['ASIGNAR']){

$sql = 'SELECT ZO, SE, MA, cobrador.nombre1, cobrador.nombre2, cobrador.apellidos, cobrador.nro_doc 
FROM ZOSEMA LEFT JOIN cobrador ON ZOSEMA.cobrador = cobrador.nro_doc
WHERE ZO ="'.$_GET['ZO'].'" AND SE ="'.$_GET['SE'].'" AND MA = "'.$_GET['MA'].'"';

$query = mysql_query($sql);
$cob = mysql_fetch_array($query);

?>
<form action="INT/M_ZOSEMA.php" method="post" name="ASIG_ZOSE" id="ASIG_ZOSE">

<input type="text" value="1" style="display:none;" name="AIGG" id="AIGG"/>
<input type="text" value="<?php  echo $_GET['ZO']; ?>" style="display:none;" name="ZO" id="ZO"/>
<input type="text" value="<?php  echo $_GET['SE']; ?>" style="display:none;" name="SE" id="SE"/>
<input type="text" value="<?php  echo $_GET['MA']; ?>" style="display:none;" name="MA" id="MA"/>

<strong>RECAUDADOR</strong> <select name="cob">
<option value="<?php echo $cob['nro_doc']?>" style="background:#9CF"><?php echo $cob['nombre1'].' '.$cob['nombre2'].' '.$cob['apellidos'];?></option>
<?php 
$sql2 = "SELECT nro_doc, nombre1, nombre2, apellidos FROM cobrador";
$query2 = mysql_query($sql2);
while($COB2 = mysql_fetch_array($query2)){
?>
<option value="<?php echo $COB2['nro_doc']; ?>"><?php echo $COB2['nombre1'].' '.$COB2['nombre2'].' '.$COB2['apellidos']; ?></option>
<?php
}
?>
</select>

<input type="submit"  class="boton" value="Asignar" />
</form>
<?php
}

/* LISTADO DE ZOSEMA */
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
	$campos = array("ZO"=>"","SE"=>"","MA"=>"","nombre1 AS NOMBRE_COB"=>"","apellidos AS AP_COB"=>"","descripcion AS DETALLE"=>"");
	
	$eliminar = array("ZO"=>"","SE"=>"","MA"=>"");
	$ver = array("ZO"=>"","SE"=>"","MA"=>"");	
	$var_ver = array('ASIGNAR'=>'1');
	$var_eli = array("ELIMINAR"=>"1");
	$rut = array('NULL'=>'');	
	$datos->Listado_per($campos,'ZOSE',$condicion,'ASIGNAR','ELIMINAR',$ver,$eliminar,'INT/M_ZOSEMA.php',$rut,$var_ver,$var_eli,'table');
	
}


/*ING ZOSEMA */

if ($_POST['ff_ing'] > 0){

	$datos = new Datos;
	$campos = array('estado'=>0);
	$datos->INSERT_PoST('ZOSEMA','','',$campos);
	
	if (mysql_query($datos->query)){
		echo INGRE_OK;}			
		
	else{			
		echo ERROR_RUT;
	}
}

/* cerrar conexion */
mysql_close($conexion);
?>