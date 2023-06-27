<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');



$sql = "SELECT COUNT, comprovante, cod_mov, nro_doc, num_solici FROM temporal";

//echo $sql;

$query = mysql_query($sql);

while ($ctate = mysql_fetch_array($query)){

    $busq ='DELETE FROM cta WHERE cta.num_solici="'.$ctate['num_solici'].'" AND comprovante ="'.$ctate['comprovante'].'";';

    echo $busq.'<br />';


}

?>