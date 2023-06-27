<?php
sleep(3);
include('../conf.php');
include('../bd.php');
?>

<img src="IMG/LogoRemm.jpg" />
&nbsp;
<?php
$traslado = "select count(tipo_traslado) as nu , min(DATE_FORMAT(fecha_traslado,'%H:%s')) as max from traslados where estado = 0 and DATE_FORMAT(fecha_traslado,'%Y') = ".date('Y')." and DATE_FORMAT(fecha_traslado,'%m')='".date('m')."' and DATE_FORMAT(fecha_traslado,'%d')='".date('d')."'";

$tras_res = mysql_query($traslado);

$res = mysql_fetch_array($tras_res);
if ($res['nu'] > 0){
?>
<blink style="color:#009900">Hoy tiene <?php echo $res['nu']; ?> traslados programados, proximo a las <?php echo $res['max']; ?> Hrs. </blink>
<?php
}
?>