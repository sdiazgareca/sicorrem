<?php
include('../conf.php');
include('../bd.php');
?>
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0; height:80px;width:90px;">
<?php
include('../conf.php');
include('../bd.php');

$consulta = "select numero from movilasig where estado = 0  and medico >1";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" onDblClick="DetalleAmbulancia('<? echo $matriz_resultados['numero'];?>')" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>

<?php
$consultaY = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosY = mysql_query($consultaY);
while($matriz_resultadosY = mysql_fetch_array($resultadosY)){
?>
<option class="text" value="<?php echo $matriz_resultadosY['cod']; ?>">Espera&nbsp;<?php echo $matriz_resultadosY['espera']; ?></option>
<?php
}
?>
</select>

