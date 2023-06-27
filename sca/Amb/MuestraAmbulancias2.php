<tr>
<td class="celda2"><?php echo $matriz_resultados['patente'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['num'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['marca'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['modelo'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['anio'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['chasis'];?></td>
<td  class="celda2"><input type="button" class="boton" value="Editar" onclick="javascript:$ajaxload('mensajemovil','PHP/main.php?nmovil=<?php echo $matriz_resultados['num']; ?>',false,false,true);" /></td>
</tr>