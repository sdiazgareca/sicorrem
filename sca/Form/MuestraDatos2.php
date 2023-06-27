<table style="width:460px; background:#FFFEE0" class="celda3">
<tr style="background-color:#FFFEE0">

<td  class="celda3" style="background-color:#FFFEE0">Plan</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="plann"><?php echo htmlentities($matriz_resultados['desc_plan']);?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Isapre</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['reducido']); ?></td>
<td class="celda3" style="background-color:#FFFEE0">Categoria</td>
<td class="celda2"style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['descripcion2']);?></td>
</tr>
<tr style="background-color:#FFFEE0">
<td class="celda3" style="background-color:#FFFEE0">Tipo</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['tipo_plan_desc']);?></td>
<td class="celda3" style="background-color:#FFFEE0">Fono Referencia</td>
<?php

include('../conf.php');
include('../bd.php');

$consulta3 = "select telefono from afiliados 
inner join domicilios on afiliados.nro_doc = domicilios.nro_doc
where afiliados.nro_doc ='".$matriz_resultados['nro_doc']."'";
		
$resultados3 = mysql_query($consulta3);
$nbd = mysql_num_rows($resultados3);


$matriz_resultados3 = mysql_fetch_array($resultados3);
?>
<td class="celda2" style="background-color:#FFFEE0"><?php if(!$matriz_resultados3['telefono']){echo 'No registra';} else{ echo htmlentities($matriz_resultados3['telefono']);}?></td>
<td class="celda3" style="background-color:#FFFEE0">Edad</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="edad"><?php echo htmlentities($matriz_resultados['edad']); ?></div></td>
</tr>
</table>

<div id="cod_plann" style="display:none"><?php echo $matriz_resultados['cod_plan']; ?></div>
<div id="tipo_plann" style="display:none"><?php echo $matriz_resultados['tipo_plan']; ?></div>
<div id="isapren" style="display:none"><?php echo $matriz_resultados['isapre']; ?></div>
<div id="plannn" style="display:none"><?php echo $matriz_resultados['plannn'];?></div>