<?php
include('../conf.php');
include('../bd.php');

$destino_ = $_GET['destino_'];
$correlativo = $_GET['correlativo'];
$rut = $_GET['rut'];

if (($destino_== 7) || ($destino_== 10) || ($destino_== 13) || ($destino_== 14) || ($destino_== 15) || ($destino_== 16) || ($destino_== 17) || ($destino_== 27) || ($destino_==39) || ($destino_==40) || ($destino_==9)){
echo "Anulado";
}
?>