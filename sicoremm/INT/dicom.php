<script type="text/javascript">
$(document).ready(function() {


 $('.eli').click(function() {
	var ruta = $(this).attr('href');
 	$('#in').load(ruta);
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
include_once('../CLA/Cobrador.php');
include_once('../CLA/Calendario.php');

if($_GET['num_solici'] && $_GET['ingreso']){

    $sql="DELETE FROM dicom WHERE dicom.num_solici='".$_GET['num_solici']."' AND ingreso='".$_GET['ingreso']."'";
    $query = mysql_query($sql);

    if($query){
        echo '<div class="mensaje1">Valor eliminado</div>';
    }
    else{
        echo '<div class="mensaje2">Error</div>';
    }

}


if (isset($_POST['num_solici'])){

foreach ($_POST AS $campo=>$valor){

    if ($valor == ""){
        echo '<div class="mensaje2">Debe llenar todos los campos</div>';
        exit;
    }

}


$fecha = explode("-",$_POST['FECHA']);

if(checkdate($fecha[1], $fecha[0],$fecha[2]) == false){
    echo '<div class="mensaje2">Error, fecha mal ingresada</div>';
    exit;
}

else{
    $f= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
}

$con = 'select contratos.num_solici from contratos where contratos.num_solici="'.num_solici.'"';
$con_q = mysql_query($con);
$num = mysql_num_fields($con_q);

if($num < 1){

    echo '<div class=mensaje2>Error, el contrato no existe en la bd.</div>';
    exit;

}


$sql ="INSERT INTO `sicoremm2`.`dicom`
	(`num_solici`,
	`fecha`,
	`nombre`,
	`atiende`,
	`motivo`,
	`monto`,
	`ingreso`
	)
	VALUES
	('".$_POST['num_solici']."',
	'".$f."',
	'".$_POST['NOMBRES']."',
	'".$_POST['ATENDIDO']."',
	'".$_POST['MOTIVO']."',
	'".$_POST['MONTO']."',
	'".$_POST['INGRESO']."'
	)";


//echo $sql;

$query = mysql_query($sql);

if($query){

    echo '<div class="mensaje1">OK</div>';

}

else{

     echo '<div class="mensaje2">Error, posiblemente el contrato ya esta ingresado</div>';

}

}






//LISTADO
$listado_sql ="SELECT 	`num_solici`,
	DATE_FORMAT(`fecha`,'%d-%m-%Y') AS fecha,
	`nombre`,
	`atiende`,
	`motivo`,
	`monto`,
	`ingreso`

	FROM
	`sicoremm2`.`dicom` ORDER BY `fecha` ASC";

$query = mysql_query($listado_sql);
echo '<br />';
echo '<table class="table2">';
    echo '<tr><th>CONTRATO</th>
        <th>FECHA</th>
        <th>NOMBRE</th>
        <th>ATENDIDO POR</th>
        <th>MOTIVO</th>
        <th>MONTO</th>
        <th>INGRESO</th></tr>';

echo '<tr>';

echo '</tr>';
while($dicom = mysql_fetch_array($query)){

    echo '<tr><td>'.$dicom['num_solici'].'</td>
        <td>'.$dicom['fecha'].'</td>
        <td>'.$dicom['nombre'].'</td>
        <td>'.$dicom['atiende'].'</td>
        <td>'.$dicom['motivo'].'</td>
        <td>'.$dicom['monto'].'</td>
        <td>'.$dicom['ingreso'].'</td>
        <td><a class="eli" href="INT/dicom.php?num_solici='.$dicom['num_solici'].'&ingreso='.$dicom['ingreso'].'">Eliminar</a></td></tr>';
}




?>
