<script type="text/javascript">
$(document).ready(function() {

	$('#ajax3 #ingVenCon2').submit(function(){

		if(!confirm("Esta seguro de modificar el registro?")) {
			return false;
		 } 
	 	
		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();
		
		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
		$('#ajax3').html(data);}}) 
		
		url_ajax ="";
		data_ajax="";
		
		return false;});
	
	$('#ajax3 a:contains("ELIMINAR")').click(function() {

		if(!confirm("Esta seguro de eliminar el registro?")) {
			return false;
		 } 

	 	 else {
			var ruta = $(this).attr('href');	
	 		$('#ajax3').load(ruta);
			$.ajax({cache: false});
			ruta = "";
	 		return false;
		}  
	});

	

	$('#ajax3 a:contains("EDITAR")').click(function() {
		var ruta = $(this).attr('href');	
		$('#ajax3').load(ruta);
		$.ajax({cache: false});
		ruta = "";
		return false;
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

});
</script>



<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$conv = new Datos;	

if (isset($_POST['ff_folio_bus']) || isset($_GET['listado'])){

	foreach($_POST as $campo => $valor){ 
		if ($valor != $_POST['ff_folio_bus'] && $valor != ""){
			
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
	
	$campos = array("nro_doc AS RUT"=>"","ZO"=>"","SE"=>"","MA"=>"","empresa AS NOMBRE"=>"","giro AS GIRO"=>"","breve as FAC"=>"");	
	$eliminar = array("ZO"=>"","SE"=>"","MA"=>"","RUT"=>"");
	
	$ver = array("ZO"=>"","SE"=>"","MA"=>"","RUT"=>"");
	$rut = array('RUT'=>"");
	
	$var_ver = array('VER'=>'1');
	$var_eli = array('ELIMINAR'=>'1');	

	$datos->Listado_per($campos,'emp',$condicion,'VER','ELIMINAR',$ver,$eliminar,'INT/M_CONV.php',$rut,$var_ver,$var_eli,'table');	

}




//PROCESA
if($_POST['ff_folio_edit'] > 0){

$rut = new Datos;
$rut->Rut($_POST['nro_doc']);
$rutt = $rut->nro_doc;



foreach ($_POST as $campo => $valor){

	if($campo == 'ff_ZOSEMA'){		
	$zosema = explode('-',$valor);
	$edicion = $edicion." ZO = '".$zosema[0]."' ,";
	$edicion = $edicion." SE = '".$zosema[1]."' ,";
	$edicion = $edicion." MA = '".$zosema[2]."' ,";
	}
	
	if($campo == 'nro_doc'){
		$edicion = $edicion." ".$campo." = '".$rutt."' ,";
	}

	if($campo != 'ff_folio_edit' && $campo != 'ff_ZOSEMA' && $campo != 'nro_doc'){
		$edicion = $edicion." ".$campo." = '".$valor."' , ";
	}
}

$cad = substr($edicion,0,strlen($edicion)-2);

$sql = "UPDATE empresa SET ".$cad." WHERE nro_doc= '".$rutt."'";

if (mysql_query($sql)){

	$_GET['VER'] = '1';
	$_GET['RUT'] = $rutt;
	$_GET['ZO'] = $zosema[0];
	$_GET['SE'] = $zosema[1];
	$_GET['MA'] = $zosema[2];

}

else{
	echo ERROR;

}

}


if (isset($_GET['VER'])){
	
	$datos = new Datos;
	$campos = array('ZO'=>'','SE'=>'','MA'=>'','nro_doc AS RUT'=>'','fono AS FONO'=>'','email AS EMAIL'=>'','celular AS CELULAR'=>'','empresa AS NOMBRE'=>'','breve AS FACTURACION'=>'','giro AS GIRO'=>'','d_pago AS D_PAGO'=>'','des_copago AS COPAGO'=>'');
	$rut = array('RUT'=>"");
	$where = array('nro_doc ="'=>$_GET['RUT'].'"','ZO ="'=>$_GET['ZO'].'"','SE ="'=>$_GET['SE'].'"','MA ="'=>$_GET['MA'].'"');
	$datos->Imprimir($campos,'emp',$where,'3',$rut);
	echo '<br />';
	echo '<div style="padding:10px"><a href="INT/M_CONV.php?EDITAR=1&RUT='.$_GET['RUT'].'" class="boton">EDITAR</a></div>';
}

//EDITAR

if ($_GET['EDITAR'] > 0){

$sql ='SELECT contacto,ZO,SE,MA,nro_doc,fono,email,celular,f_factu,empresa,estado,cod_giro,breve,exten,giro,cod_copago,des_copago FROM emp WHERE nro_doc="'.$_GET['RUT'].'"';
$query = mysql_query($sql);

$empresa = mysql_fetch_array($query);

?>

<h1>GESTION DE EMPRESAS</h1>

<form action="INT/M_CONV.php" method="post" id="ingVenCon2" name="ingVenCon2" >
<input type="text" name="ff_folio_edit" value="1" style="display:none;" />
<div class="caja_cabezera">

Descrici&oacute;n de la Empresa</div> 

<div class="caja">
 <table>
 <tr> 
<td>
 <label for="ContactName">Facturaci&oacute;n</label> 

<?php 
$sql = "SELECT breve, codigo FROM f_factu";
$query = mysql_query($sql);

echo '<SELECT name="f_factu">';
echo '<option value="'.$empresa['f_factu'].'">'.$empresa['breve'].'</option>';
while ($f_factu = mysql_fetch_array($query)){
	echo '<option value="'.$f_factu['codigo'].'">'.$f_factu['breve'].'</option>';
}
echo '</SELECT>';

?>
</td>

<td><label for="ContactName">Giro</label>
<?php 

$sql = "SELECT `desc`,`codigo` FROM `giro`";
$query = mysql_query($sql);

echo '<SELECT name="giro">';
echo '<option value="'.$empresa['cod_giro'].'">'.$empresa['giro'].'</option>';

while ($giro = mysql_fetch_array($query)){
	echo '<option value="'.$giro['codigo'].'">'.$giro['desc'].'</option>';
}
echo '</SELECT>';
?>

</td>
<td>Contacto&nbsp;&nbsp;<input type="text" name="contacto" value="<?php  echo $empresa['contacto']?>"  /></td>
</tr>
 
<tr>
<td><label for="ContactName">Fono</label>&nbsp;&nbsp;<input name="fono" type="text" maxlength="6" value="<?php  echo $empresa['fono']?>"/></td>
<td>Email&nbsp;&nbsp;<input type="text" name="email" value="<?php  echo $empresa['email']?>" /></td>
<td><label for="ContactName">Celular</label>&nbsp;&nbsp;<input type="text" name="celular" value="<?php  echo $empresa['celular']?>"></td>
</tr>

<tr>

<td>
ZO - SE - MA <select name="ff_ZOSEMA">
<?php 
$sql = "SELECT ZO, SE,MA FROM ZOSEMA WHERE cobrador = 1";
$sql_query = mysql_query($sql);

echo '<option value="'.$empresa['ZO'].'-'.$empresa['SE'].'-'.$empresa['MA'].'">'.$empresa['ZO'].'-'.$empresa['SE'].'-'.$empresa['MA'].'</option>';
while($zosema = mysql_fetch_array($sql_query)){
?>
<option value="<?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA']; ?>"><?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA']; ?></option>
<?php 
}
?>
</select>
</td>


<td><label for="ContactName">Empresa</label>&nbsp;&nbsp;<input type="text" name="empresa" value="<?php  echo $empresa['empresa']?>" /></td>
<td><label for="ContactName">RUT</label>&nbsp;&nbsp;<input readonly="readonly" type="text" name="nro_doc" class="rut" value="<?php $rut = new Datos; $rut->validar_rut($empresa['nro_doc']); echo $rut->nro_doc; ?>" /></td>
</tr>

<tr>
<td><label for="ContactName">Copago</label>&nbsp;&nbsp;
    <select name="copago" >
        <option value="<?php echo $empresa['cod_copago'];?>"><?php echo $empresa['des_copago'];?></option>
        <?php
        $sql="SELECT cod, copago_emp FROM empresa_copago WHERE cod != '".$empresa['cod_copago']."'";
        $query = mysql_query($sql);
        while($cop = mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $cop['cod'];?>"><?php echo $cop['copago_emp'];?></option>
        <?php
        }
        ?>
    </select>
</td>

</tr>

</table>

</div>

<div class="caja_boton"><a href="INT/M_CONV.php?VER=1&RUT=<?php echo $_GET['RUT'];?>&ZO=<?php echo $empresa['ZO']; ?>&SE=<?php echo $empresa['SE'];?>&MA=<?php echo $empresa['MA']; ?>" class="boton">Volver</a>  <input type="submit" value="Guardar" class="boton"></div>
</form>



<?php 
}
//INGRESA
if (isset($_POST['ff_folio_int']) ){
	
	if($_POST['nro_doc'] > 0){

	$conv->Rut($_POST['nro_doc']);	
		
	$campos = array('nro_doc'=>$conv->nro_doc);	
		
	if ( ($num = $conv->ComDataUni($campos,'empresa')) < 1){
	
		$so = new Datos;
		
		$zose = explode('-',$_POST['ff_ZOSEMA']);
		
		$zosema = array('ZO'=>$zose[0],'SE'=>$zose[1],'MA'=>$zose[2]);	

			$conv->INSERT_PoST('empresa','','',$zosema);
			
			$bd2 = new Datos;
			$query = array("empresa"=>$conv->query,"zosema"=>"UPDATE ZOSEMA SET estado='1' WHERE ZO='".$zose[0]."' AND SE='".$zose[1]."' AND MA='".$zose[2]."'");
			$bd2->Trans($query);
	}	
}
else{
	echo '<strong>RUT NO VALIDO</strong>';
}
}

if (isset($_GET['ELIMINAR'])){
	$query = "DELETE FROM empresa WHERE empresa.nro_doc='".$_GET['RUT']."' AND ZO='".$_GET['ZO']."' AND SE = '".$_GET['SE']."' AND MA = '".$_GET['MA']."'";
	if (mysql_query($query)){
		echo OK;
	}
	else{
		echo ERROR;
	}
	
}


/* cerrar conexion */
mysql_close($conexion);
?>