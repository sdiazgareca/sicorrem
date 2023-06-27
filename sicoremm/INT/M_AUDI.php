<script type="text/javascript">
$(document).ready(function() {
	
        
        
        $('td:contains("DEVUELTO")').parent().addClass('rojo');
        
        $('td:contains("INGRESADO")').parent().addClass('verde');
        
	$('td:contains("RENDIDO")').parent().addClass('verde');

	$('td:contains("NULO")').parent().addClass('rojo');

	$('td:contains("ENTREGADO")').parent().addClass('azul');
        
        $('td:contains("FALTANTE")').parent().addClass('rojo');
        
	
	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});		
	
$('#ajax3 a:contains("ANULAR")').click(function()  {

 if(!confirm(" Esta seguro de continuar?")) {
	  return false;} 
  else {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
 	}  
});

$('#ajax3 a:contains("Ver")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
});

$('#comprobar').submit(function(){

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
set_time_limit(1000000);
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Vendedor.php');
include_once('../CLA/Titular.php');
include_once('../CLA/Contrato.php');
include_once('../CLA/Domicilio.php');

$datos = new Datos;


/* CAMBIAR ESTADO DEL CONTRATO */
if($_POST['ident'] == 'update'){
    
    $sql = "UPDATE doc SET estado =".$_POST['estado']." WHERE folio = ".$_POST['FOLIO']." AND categoria=".$_POST['GAT']." AND estado!=600";

    $sql2= "UPDATE doc SET f_entrega ='".date('Y-m-d')."', vendedor=".$_POST['VENDEDOR']." 
            WHERE folio = ".$_POST['FOLIO']." AND categoria=".$_POST['GAT']." AND codigo =".$_POST['COD'];
    
    $sql3= "UPDATE ventas_reg SET vendedor=".$_POST['VENDEDOR']." 
            WHERE codigo =".$_POST['COD'];    
    
    if(mysql_query($sql) && mysql_query($sql2) && mysql_query($sql3)){
        echo INGRE_OK;
    }
    else{
        echo ERROR3;
    }
}


/* Eliminar */
if( isset($_GET['ELIMINAR']) ){
   
	echo '<form action="INT/M_AUDI.php" method="post" id="comprobar">';
	echo '
        <input type="text" value="update" style="display:none;" name="ident">
	<input type="text" value="'.$_GET['FOLIO'].'" style="display:none;" name="FOLIO">
	<input type="text" value="'.$_GET['CATEGORIA'].'" style="display:none;" name="CATEGORIA">
        <input type="text" value="'.$_GET['GAT'].'" style="display:none;" name="GAT">    
	<input type="text" value="'.$_GET['COD'].'" style="display:none;" name="COD">';
        echo '<p><strong>FOLIO: '.$_GET['FOLIO'].'</strong></p><p><strong>TIPO DE DOCUMENTO: '.$_GET['CATEGORIA'].'</strong></p></h1>
	
        <table style="width:auto;">
	
	<tr>
	<td><strong>ESTADO</strong><td>';
        
        echo '<td><select name="estado">';
        echo '<option value="'.$_GET['CAT'].'">'.$_GET['ESTADO'].'</option>';
        $sql = "SELECT codigo, detalle, resu FROM e_doc WHERE codigo != ".$_GET['CAT']." AND codigo <= 400";
        $query = mysql_query($sql);
        while($sal = mysql_fetch_array($query)){
            echo '<option value="'.$sal['codigo'].'">'.$sal['detalle'].'</option>';
        }
        echo '</select>';
        
        echo '</td>
            
	<td><strong>VENDEDOR</strong><td>';
        
        echo '<td><select name="VENDEDOR">';
        
        $sql2 = "SELECT nro_doc, apellidos FROM vendedor WHERE nro_doc=".$_GET['RUT']."";
        echo "<br /><strong>".$sql2."</strong><br />";
        $query = mysql_query($sql2);
        while($sal2 = mysql_fetch_array($query)){
            echo '<option value="'.$sal2['nro_doc'].'">'.$sal2['apellidos'].'</option>';
        }        
        
        
        $sql = "SELECT nro_doc, apellidos FROM vendedor ORDER BY nro_doc";
        $query = mysql_query($sql);
        while($sal = mysql_fetch_array($query)){
            echo '<option value="'.$sal['nro_doc'].'">'.$sal['apellidos'].'</option>';
        }
        echo '</select>';
        
        echo '</td>    

            <td><input type="submit" value="Guardar" /></td>
	</tr>

	</table>';
        echo '</form>';
}




/* LISTADO */

if ( isset($_POST['ff_folio_bus']) ){

foreach($_POST as $campo => $valor){ 
		
		
		if ($valor != $_POST['ff_folio_bus'] && $valor != ""){
			
			if ($campo =='ff_entrega'){
				$fechas = new Datos;
				$f_entrega = $fechas->cambiaf_a_mysql($_POST['ff_entrega']);
				$condicion['f_entrega']="= '".$f_entrega."'";
			}
			
			else if($valor != 'TODOS'){
				$condicion[$campo]=" LIKE '".$valor."%'";
			}
			
			if (is_numeric($valor)){
				$condicion[$campo]=" = ".$valor;
			}					
		}
	}
	
	$datos = new Datos;
	$campos = array("codigo AS COD"=>"","folio AS FOLIO"=>"","vendedor AS RUT"=>"","nombre1 as P_NOMBRE"=>"","nombre2 as S_NOMBRE"=>"","apellidos AS APELLIDOS"=>"","cat_des AS CATEGORIA"=>"","est_des AS ESTADO"=>"","f_entrega AS F_ENTREGA"=>"","codigo_est_res AS CAT"=>"","categoria as GAT"=>"");
	$rut = array('NULL'=>"");
	//$get1 =     array("ESTADO"=>"","GAT"=>"","FOLIO"=>"","RUT"=>"","CATEGORIA"=>"","P_NOMBRE"=>"");
        $get1 = array("ESTADO"=>"","GAT"=>"","FOLIO"=>"","RUT"=>"","CATEGORIA"=>"","CAT"=>"","COD"=>"");

	$rendir = array('RENDIR'=>'1');
	$eliminar = array('ELIMINAR'=>'1');	
	$datos->Listado_per($campos,'docu',$condicion,'Ver','ANULAR',$get1,$get1,'INT/M_AUDI.php',$rut,$rendir,$eliminar,'table');

}
?>

<?php
/* Rendicion */
if ( isset($_GET['RENDIR']) && $_GET['CAT'] != 600 && $_GET['CAT'] != 500){
	
	$rut = new Datos;

	$rut->validar_rut($_GET['RUT']);
	
	echo '<h1>VENDEDOR</h1>';
	echo '<form action="INT/SUB_M_AUDI_1.php" method="post" id="comprobar">';
	echo '
	<input type="text" value="'.$_GET['FOLIO'].'" style="display:none;" name="FOLIO">
	<input type="text" value="'.$_GET['CATEGORIA'].'" style="display:none;" name="CATEGORIA">
	<input type="text" value="'.$_GET['RUT'].'" style="display:none;" name="VENDEDOR">
	
	<table style="width:auto;">
	
	<tr>
	<td><strong>VENDEDOR</strong><td><input type="text" readonly="readonly" name="P_NOMBRE" value="'.$_GET['P_NOMBRE'].' '.$_GET['S_NOMBRE'].'"/></td>
	</tr>
	
	<tr>
	<td><strong>RUT</strong></td>
	<td><input type="text" readonly="readonly" name="ff_VENDEDOR_RUT" value="'.$rut->nro_doc .'" /></td>
	</tr>
	</table>
	
	<h1>Titular</h1>
	
	<table style="width:auto;">
	<tr>
	<td><strong>RUT TITULAR</strong></td>
	<td><input type="text" name="nro_doc" class="rut" /></td>
	<td><input type="submit" value="Comprobar" class="boton"></td>
	</table>
	</form>
	<h1>&nbsp;</h1>';
	
}

/*ING AUDITORIA */

if ( isset($_POST['ff_folio_ing'])){
	
	$campos_aud = array('folio'=>$_POST['folio'],'categoria'=>$_POST['categoria']);

        if ($_POST['categoria'] == '101' ){
        
        $campos_cont = array('num_solici'=>$_POST['folio']);
        $cont = $datos->ComDataUni($campos_cont,'contratos');
        }
        else{
            $cont = 0;
        }

        
	$aud = $datos->ComDataUni($campos_aud,'doc');
	
	$fecha = new Datos;
	
	$f_entrega = array("f_entrega"=>$fecha->cambiaf_a_mysql($_POST['ff_entrega']));
	
	
	if ($aud < 1 && $cont < 1){
	
		$datos->CompData('codigo','doc');	
		
	
		$cod = array('codigo'=>$datos->num);
		$datos->INSERT_PoST('doc','',$f_entrega,$cod);
		
		if( mysql_query($datos->query)){
			$condicion = "";
			echo OK;
		}
	
	}
	
	else{
		echo ERROR;
	}
}



//vista documentpos RENDIDOS Y LISTOS
if ( isset($_GET['RENDIR']) && ($_GET['CAT'] == 600 || $_GET['CAT'] == 500) ){
	
	//OBTENER EL NUMERO DE CONTRATO
	$con_sql = "SELECT num_solici,vendedor FROM doc WHERE codigo='".$_GET['COD']."'";
	
	$query = mysql_query($con_sql);
	$con = mysql_fetch_array($query);
	
	$_GET['CONTRATO'] = $con['num_solici'];

        //DATOS DEL VENDEDOR
        $vendedor = new Vendedor();
        $vendedor->DatosVendedor($con['vendedor']);

        //DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO
        $datosRespo = new Titular;
        $datosRespo->DatosContratante($_GET['CONTRATO'],0);

        //VALOR MENSUAL DE LOS SERVICIOS
        $valorMensual = new Contrato;
        $valorMensual->ValorMensual($_GET['CONTRATO'],0);

        //OBTIENE LA FORMA DE PAGO
	$pago = "SELECT titular,contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
	$pago_sql = mysql_query($pago);
	$tipo_pago = mysql_fetch_array($pago_sql);

       // echo '<br />'.$pago.'<br />';
        //FORMA DE PAGO MENSUAL
        
        $valorMensual->FormaPago($_GET['CONTRATO'], $tipo_pago['cod_f_pago'],1);

        //OBTIENE FORMA DE PAGO INICIAL
        $sql3 = "SELECT cod_pago_venta,des_pago_venta FROM REG_VENTAS WHERE num_solici ='".$_GET['CONTRATO']."'";
	$query3 = mysql_query($sql3);
	$doc_pago = mysql_fetch_array($query3);

        //echo '<br />'.$doc_pago['cod_pago_venta'].'<br />';
        //FORMA DE PAGO INICIAL
        $valorMensual->FormaPagoInicial($_GET['CONTRATO'], $doc_pago['cod_pago_venta'],0);

        echo '<br />';
        //DOMICILIOS
        $dom = new Domicilio();
        $dom->Display( $_GET['CONTRATO'], $tipo_pago['titular'],'#ajax3');

}


?>
<div id="ajax4"></div>
<?php
/* cerrar conexion */
mysql_close($conexion);
?>