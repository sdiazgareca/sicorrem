<?php




//OBTIENE NOMBRE DE ISAPRE, PLANES
$consul = "SELECT
empresa.empresa AS n_empresa,f_pago.descripcion as f_pago,fichas.nro_doc AS rut,obras_soc.descripcion AS isapre, planes.desc_plan
FROM fichas
INNER JOIN obras_soc ON fichas.isapre = obras_soc.nro_doc
INNER JOIN planes ON fichas.cod_plan = planes.cod_plan AND fichas.tipo_plan = planes.tipo_plan
LEFT JOIN contratos ON contratos.num_solici = fichas.num_solici
LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
WHERE fichas.nro_doc = '".$matriz_resultados['nro_doc']."' AND fichas.num_solici='".$matriz_resultados['num_solici']."' AND fichas.correlativo='".$matriz_resultados['correlativo']."'";

//echo $consul;

		$resull = mysql_query($consul);
		$matriz = mysql_fetch_array($resull);
		
		//OBTIENE NOMBRE AFILIADO, APELLIDO, MOT_ BAJA DESDE AFILIADOS
		$mat_rut = "SELECT afiliados.nombre1, afiliados.apellido,  mot_baja.descripcion, afiliados.cod_baja, mot_baja.codigo
					FROM afiliados INNER JOIN mot_baja ON mot_baja.codigo = afiliados.cod_baja WHERE afiliados.nro_doc = '".$matriz_resultados['nro_doc']."' AND afiliados.num_solici='".$matriz_resultados['num_solici']."'";
					
		$mat_rut_resul = mysql_query($mat_rut);
		$mat_rut_resul_1 = mysql_fetch_array($mat_rut_resul);

?>

<!-- Muestra TABLA AFILIADO, ESTADO -->
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="40">Afiliado</td>
<td width="133"><?php echo htmlentities($mat_rut_resul_1['nombre1']).' '.htmlentities($mat_rut_resul_1['apellido']); ?></td>
<?php
if (($mat_rut_resul_1['codigo'] == 00) || ($mat_rut_resul_1['codigo'] == 05)){
?>
<td width="44">Estado</td>
<td width="100" style="color:#009900"><?php echo $mat_rut_resul_1['descripcion']; ?></td>
<?php
}
else {
?>
<td width="44">Estado</td>
<td width="100"><blink style="color:#FF0000;"><?php echo $mat_rut_resul_1['descripcion']; ?></blink></td>
<?php
}
?>
</tr>
</table>

<!-- Muestra TABLA RUT, PLAN, CONVENIO -->
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="37">Rut</td>
<td width="73" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz_resultados['nro_doc'].' - '.ValidaDVRut($matriz_resultados['nro_doc']); ?></td>
<td width="26">Isapre</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['isapre'] ?></td>
<td width="58">Plan</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['desc_plan'] ?></td>
</tr>
<tr>
<td width="37">EMPRESA</td>
<td width="73" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['n_empresa']; ?></td>
<td width="26">MENSUALIDAD</td>
<td width="129" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz['f_pago'] ?></td>
<td width="58">&zwnj;</td>
<td width="129" class="celda2" style="background-color:#FFFEE0">&zwnj;</td>
</tr>
</table>
