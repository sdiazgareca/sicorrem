<?php
include('../conf.php');
include('../bd.php');
?>
<select name="movil" size="5" id="movil" style=" font-size:10px;color:#006699;background-color:#F6DF17; font-weight:bold; height:80px; width:90px;">
<?php
$consulta = "select numero from movilasig where estado = 1 and medico >0";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){

?>
<option class="text" onclick="$ajaxload('masig','Form/AgregarFicha2.php?num=<?php echo $matriz_resultados['numero'];?>',false,false,false);" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>

<?php
$consultaY = "select cod,espera from movil_espera where estado = 1";		
$resultadosY = mysql_query($consultaY);
while($matriz_resultadosY = mysql_fetch_array($resultadosY)){
?>
<option class="text" onclick="$ajaxload('masig','Form/AgregarFicha2.php?num=<?php echo $matriz_resultadosY['cod'];?>',false,false,false);" value="<?php echo $matriz_resultadosY['cod']; ?>">Espera&nbsp;<?php echo $matriz_resultadosY['espera']; ?></option>
<?php
}
?>
</select>
