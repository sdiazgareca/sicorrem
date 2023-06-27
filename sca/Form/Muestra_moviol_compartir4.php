<?php
include('../conf.php');
include('../bd.php');
$id = $_GET['id'];

$correlativo = $_GET['correlativo'];
$num = $_GET['num'];
$movil = $_GET['movil'];

?>
<a style="color:#000000;" href="#" 
onclick="$ajaxload('movil_asignados_<?php echo $correlativo; ?>', 'Form/Muestra_moviol_compartir3.php?correlativo=<?php echo $correlativo; ?>&num=<?php echo $num; ?>&movil=<?php echo $movil; ?>',false,false,false);">
Movil Libre</a>
<select name="<?php echo $id; ?>" size="5" id="<?php echo $id; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
<?php
$consulta = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" onDblClick="cambiar_amb(this.value,'<?php echo $correlativo; ?>','<?php echo $num;?>','<?php echo $movil; ?> ')" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>
</select>
