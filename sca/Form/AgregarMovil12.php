<tr>
<td class="celda2"><?php echo $matriz_resultados['num_solici'];?></td>
<td class="celda2"><?php echo $matriz_resultados['nro_doc'];?></td>
<td class="celda2"><?php echo htmlentities($matriz_resultados['descripcion1']);?></td>
<td class="celda2"><?php echo htmlentities($matriz_resultados['apellido'])."&nbsp;".htmlentities($matriz_resultados['nombre1'])."&nbsp;".htmlentities($matriz_resultados['nombre2']);?></td>
<td class="celda2">
    <div align="right">
        <input type="button" value="Asignar Movil" class="boton" onclick="$ajaxload('bus','PHP/main.php?rut=<?php echo $matriz_resultados['nro_doc']; ?>&contratito=<?php echo $matriz_resultados['num_solici']; ?>',false,false);" />
    </div>
</td>
</tr>