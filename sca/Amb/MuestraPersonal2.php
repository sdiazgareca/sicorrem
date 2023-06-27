<tr>
<td class="celda2"><?php echo $matriz_resultados['rut'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['nombre1'].'&nbsp;'.$matriz_resultados['nombre2'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['apellidos'];?></td>
<td  class="celda2"><?php echo $matriz_resultados['cargo'];?></td>
<td  class="celda2"><input type="button" class="boton" value="Editar" onclick="javascript:$ajaxload('mensajemovil','PHP/main.php?rutpersonal=<?php echo $matriz_resultados['rut']; ?>',false,false,false);" /></td>
</tr>