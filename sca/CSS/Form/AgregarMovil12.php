<tr>
<td class="celda2"><?php echo $matriz_resultados['nro_doc'];?></td>
<td class="celda2"><?php echo $matriz_resultados['apellido']."&nbsp;".$matriz_resultados['nombre1']."&nbsp;".$matriz_resultados['nombre2'];?></td>
<td class="celda2"><div align="right"><input type="button" value="Asignar Movil" class="boton" onclick="$ajaxload('bus', 'PHP/main.php?rut=<?php echo $matriz_resultados['nro_doc']; ?>',false,false);" /></div></td>
</tr>