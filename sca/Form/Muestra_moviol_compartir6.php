<?php
include('../conf.php');
include('../bd.php');
$id = $_GET['id'];

$correlativo = $_GET['correlativo'];
$num = $_GET['num'];
$movil = $_GET['movil'];

?>
<a style="color:#000000;" href="#" 
onclick="$ajaxload('movil_asignados_<?php echo $correlativo; ?>', 'Form/Muestra_moviol_compartir5.php?correlativo=<?php echo $correlativo; ?>&num=<?php echo $num; ?>&movil=<?php echo $movil; ?>',false,false,false);">
Movil Libre</a>
<select name="<?php echo $id; ?>" size="5" id="<?php echo $id; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
<?php
$consulta = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" onDblClick="
if(confirm('Esta seguro de cambiar al paciente de movil?')){
cambiar_amb2(this.value,'<?php echo $correlativo; ?>','<?php echo $num;?>','<?php echo $movil; ?> ');}" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>

<?php
$consultare = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
<option class="text" onDblClick="
if(confirm('Esta seguro de establecer en espera al paciente?')){
cambiar_amb3(this.value,'<?php echo $matriz_resultados2['correlativo']; ?>','<?php echo $num;?>');}" value="<?php echo $matriz_resultadosre['cod']; ?>"><?php echo 'Espera '.$matriz_resultadosre['espera']; ?></option>
<?php
}
?>
</select>