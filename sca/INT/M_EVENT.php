<script type="text/javascript">
$(document).ready(function() {

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

/* INGRESAR */
	if ( isset($_POST['ff_ing']) ){

           // echo $_POST['docu'];

           if ($_POST['docu'] == '100' || $_POST['docu'] == '300' || $_POST['500']){
               $monto = $_POST['monto'] * 81 / 100;
               $iva = $_POST['monto'] * 19 / 100;
           } 
           else{
               $monto = $_POST['monto'];
               $iva = 0;
           }
           
        $fecha = new Datos;
        $eve ="INSERT INTO
            eventos
            (fecha , descripcion , docuemnto , monto, iva, cliente, direccion, ciudad, fpago )

            VALUES
            ('".$fecha->cambiaf_a_mysql($_POST['fecha'])."' , '".$_POST['descripcion']."' , '".$_POST['docu']."' , '".$monto."', '".$iva."','".$_POST['cliente']."','".$_POST['direccion']."', '".$_POST['ciudad']."','".$_POST['fpago']."')";


        $query = mysql_query($eve);

        $_POST['ff_vend'] = 1;
        $_POST['docu'] ="TODOS";
        $_POST['fecha']="";
        $_POST['descripcion']="";
}

/* REGISTRO DE EVENTOS */
if ( isset($_POST['ff_vend'])){

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
	$campos = array("cod"=>"","descripcion"=>"","fecha"=>"","monto"=>"","iva"=>"","docu"=>"");
	$eliminar = array('cod'=>"");
	$ver = array("cod"=>"");
	$rut = array('RUT'=>"");
	$var_ver = array(''=>'1');
	$var_eli = array(''=>'1');
	$datos->Listado_per($campos,'event',$condicion,'','VER',$ver,$eliminar,'INT/M_EVENT.php',$rut,$var_ver,$var_eli,'table');

}
?>
<div id="sub_1"></div>
