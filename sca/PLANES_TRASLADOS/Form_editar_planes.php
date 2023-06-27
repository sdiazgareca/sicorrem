<?php
include('../conf.php');
include('../bd.php');


$cod = $_GET['cod'];

if( (isset($_GET['cod_plan'])) and (isset($_GET['plan_'])) ){

$query = "update planes_traslados set  desc_plan='".htmlentities($_GET['plan_'])."' where cod_plan='".$_GET['cod_plan']."'";

$con = mysql_query($query);

if($con){
echo '<table class="celda1" style="width:500px;"><tr><td><div class="mensaje"><img src="IMG/tick.png" />&nbsp;Datos almacenados</div></td></tr></table>';
}
exit;
}


$query = "select desc_plan,cod_plan from planes_traslados where cod_plan = '".$cod."'";
$consu = mysql_query($query);
$matri = mysql_fetch_array($consu);
?>

<table class="celda1" style="width:500px;">
<tr>
<td class="celda2"><strong>Sintoma</strong> &nbsp; <input name="plan_" type="text" id="plan_" value="<?php echo htmlentities($matri['desc_plan']); ?>" size="40">
<br />

<div align="right"><input class="boton" type="button" value="Guardar" onclick="

$ajaxload('sintomas','PLANES_TRASLADOS/Form_editar_planes.php?cod_plan=<?php echo $matri['cod_plan'];?>&plan_='+document.getElementById('plan_').value ,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);"></div></td>
</tr>
</table>