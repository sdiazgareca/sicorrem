<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-top::none;" class="celda3">
<tr>
<td style="color:#00CC00">SINTOMAS</td>
</tr>
<tr>
<td>
<?php
$consulta_sintomas = "SELECT sintomas.sintoma as sint FROM sintomas INNER JOIN sintomas_reg ON sintomas.cod=sintomas_reg.sintoma WHERE correlativo='".$matriz_resultados['correlativo']."'";		
$resintoma = mysql_query($consulta_sintomas);
$i = 1;
while($matriz_sintoma = mysql_fetch_array($resintoma)){
?>

<?php echo $i.')'.$matriz_sintoma['sint'].'  '; ?>

<?
$i = $i+1;
}
?>
</td>
</tr>
</table>