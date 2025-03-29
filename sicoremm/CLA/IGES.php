???????????????????????????????????????????????????????????????

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/IGES_FAC.php');
include_once('../CLA/Datos.php');

// FEHCAS
$fecha = new Datos();
$pero = explode('-',$_POST['periodo22']);
$periodo = $pero[1].'-'.$pero[0].'-01';
$ani_periodo=$pero[1];
$mes_periodo=$pero[0];
$desde = $fecha->cambiaf_a_mysql($_POST['del']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al']);

//RECAUDADORES
$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador WHERE codigo != 10";
$query=mysql_query($sql);

while($cob = mysql_fetch_array($query)){

    $informe = new Periodos3();
    echo '<h3>'.strtoupper($cob['nombre1'].' '.$cob['apellidos']).'</h3>';


    unset($informe);
}

?>
