<script type="text/javascript">
$(document).ready(function() {


$('#ajax1 a').click(function() {

 	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });


});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


/* VER */

if(isset($_GET['ELIMINAR'])){

    $sql ="DELETE FROM eventos WHERE eventos.cod='".$_GET['cod']."'";
    if($query = mysql_query($sql)){

        echo OK;

    }
    else{
        echo ERROR2;
    }

}


if(isset($_GET['VER'])){


$sql ="SELECT cod,categoria,cod,descripcion, DATE_FORMAT(fecha, '%d-%m-%Y') AS fecha, docuemnto, monto, iva, cliente, direccion, ciudad, fpago
       FROM sicoremm2.eventos
       WHERE eventos.cod='".$_GET['cod']."'";

$query = mysql_query($sql);

$event = mysql_fetch_array($query);

?>
<div class="caja">

    <h1><?php echo $event['categoria']; ?></h1>
    <h2>DOCUMENTO N <?php echo $event['cod']; ?></h2>


<table class="table">
<tr>
   <td><strong>Fecha de Pago</strong></td><td><?php echo $event['fecha']; ?></td>

<td>
    <strong>Documento</strong></td>
<td>
    <?php

    $sql = "SELECT cod, descripcion FROM eventos_f WHERE cod='".$event['docuemnto']."'";
    $query = mysql_query($sql);
    $bol = mysql_fetch_array($query);
    echo $bol['descripcion'];
    
    ?>
</td>

</tr>

<tr>

<td><strong>Monto</strong></td>
<td><?php echo $event['monto']; ?></td>

    <td><strong>Cliente</strong></td><td><?php echo $event['cliente'];?></td>
</tr>

<tr>
    <td><strong>Direccion</strong></td><td> <?php echo $event['direccion']; ?></td>

    <td><strong>F.Pago</strong></td>
    <td><?php echo $event['fpago']; ?></td>

</tr>

<tr>
        <td><strong>Ciudad</strong></td>
        <td>

        <?php
        $sql = "SELECT ciudad.codigo, ciudad.nombre FROM ciudad WHERE ciudad.codigo ='".$event['ciudad']."'";
        $query = mysql_query($sql);
        ?>

            <?php
            $ciudad = mysql_fetch_array($query);
            ?>
            <?php echo $ciudad['nombre'];?>

        </td>

    <td><strong>Categoria</strong></td>
    <td><?php echo $event['categoria']; ?></td>

</tr>

</table>

<br />

<table class="table2">

    <tr>
        <td><strong>Descripcion</strong></td>
        <td><?php echo $event['descripcion']; ?></td>
    </tr>
</table>
</div>

<?
exit;


}

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
            (cod,fecha , descripcion , docuemnto , monto, iva, cliente, direccion, ciudad, fpago,categoria )

            VALUES
            ('".$_POST['codigo']."','".$fecha->cambiaf_a_mysql($_POST['fecha'])."' , '".$_POST['descripcion']."' , '".$_POST['docu']."' , '".$monto."', '".$iva."','".$_POST['cliente']."','".$_POST['direccion']."', '".$_POST['ciudad']."','".$_POST['fpago']."','".$_POST['categoria']."')";

        //echo $eve;
        if(mysql_query($eve)){

            echo OK;
            exit;

        }

        else{
            echo 'El numero de factura existe';
            exit;
        }

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
	$var_ver = array('ELIMINAR'=>'1');
	$var_eli = array('VER'=>'1');
	$datos->Listado_per($campos,'event',$condicion,'ELIMINAR','VER',$ver,$eliminar,'INT/M_EVENT.php',$rut,$var_ver,$var_eli,'table');

}
?>
<div id="sub_1"></div>