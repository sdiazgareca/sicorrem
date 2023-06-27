<table style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="#FFCC00">
<td>FOLIO ATENCION</td>
<td>Nº FICHA</td>
<td>DIA ATENCION</td>
<td>MES ATENCION</td>
<td>AÑO ATENCION</td>
<td>RUT_ PRESTADOR</td>
<td>DV_PRESTADOR</td>
<td>RUT_TRATANTE</td>
<td>DV_TRATANTE</td>
<td>CODIGO ESPECIALIDAD</td>
<td>ESPECIALIDAD TRATANTE</td>
<td>RUT_TITULAR</td>
<td>DV_TITULAR</td>
<td>NOMBRE TITULAR</td>
<td>RUT_PACIENTE</td>
<td>DV_PACIENTE</td>
<td>NOMBRE_PACIENTE</td>
<td>CODIGO PARENTESCO</td>
<td>DESCRIPCION PARENTESCO</td>
<td>CIE 10</td>
<td>GLOSA CIE</td>
<td>CODIGO TIPO DE ATENCION</td>
<td>TIPO DE ATENCION</td>
<td>CODIGO INSTITUCION PREVISIONAL</td>
<td>DESCRIPCION INSTITUCION PREVISIONAL</td>
<td>CODIGO PRESTADOR DERIVADO</td>
<td>PRESTADOR DERIVADO</td>
<td>CODIGO TIPO COBRO</td>
<td>TIPO COBRO</td>
<td>FOLIO DOCUMENTO</td>
<td>OBSERVACIONES</td>
</tr>

<?php
include('conf.php');
include('bd.php');
include('rut.php');

$consulta = "SELECT julio_medimel.observacion,DATE_FORMAT(julio_medimel.hora_llamado_bd,'%d') AS dia,color.color,
			DATE_FORMAT(julio_medimel.hora_llamado_bd,'%m') AS mes,
			DATE_FORMAT(julio_medimel.hora_llamado_bd,'%Y') AS anio,
			julio_medimel.PROTOCOLO,julio_medimel.NOMBRE_BD, julio_medimel.APELLIDOS_BD, julio_medimel.NO FROM julio_medimel
			INNER JOIN color ON color.cod = julio_medimel.clave";
$resultados = mysql_query($consulta);
?>
<tr>
<?php
while	($mr = mysql_fetch_array($resultados)){

	
	$consulta = "SELECT afiliados.nro_doc, afiliados.nombre1, afiliados.apellido,glosa_parentesco
				FROM afiliados 
				INNER JOIN parentesco ON parentesco.cod_parentesco = afiliados.cod_parentesco
				WHERE afiliados.nombre1 LIKE '".substr($mr['NOMBRE_BD'],0,2)."%' AND afiliados.apellido  LIKE '".substr($mr['APELLIDOS_BD'],0,2)."%' AND afiliados.cod_plan ='W71' order by afiliados.nombre1 asc ";
	
	$res = mysql_query($consulta);
	$mat = mysql_fetch_array($res);	
	/*
	echo $mr['observacion'].' ';
	echo $mat['apellido'].' ';
	echo $mat['nombre1'].'<br />';
	*/
	
?>
<td><?php echo $mr['NO']; ?></td>
<td><?php echo $mr['PROTOCOLO']; ?></td>
<td><?php echo $mr['dia']; ?></td>
<td><?php echo $mr['mes']; ?></td>
<td><?php echo $mr['anio']; ?></td>
<td>96964780</td>
<td>K</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>1</td>
<td>1</td>
<td>RUT_TITULAR</td>
<td>DV_TITULAR</td>
<td>NOMBRE TITULAR</td>
<td><?php echo $mat['nro_doc']; ?></td>
<td><?php echo ValidaDVRut($mat['nro_doc']); ?></td>
<td><?php echo $mat['nombre1']; ?></td>
<td>CODIGO PARENTESCO</td>
<td><?php echo $mat['glosa_parentesco']; ?></td>
<td>CIE 10</td>
<td>GLOSA CIE</td>
<td></td>
<td>Clave <?php echo $mr['color']; ?></td>
<td>CODIGO INSTITUCION PREVISIONAL</td>
<td>DESCRIPCION INSTITUCION PREVISIONAL</td>
<td>CODIGO PRESTADOR DERIVADO</td>
<td>PRESTADOR DERIVADO</td>
<td>CODIGO TIPO COBRO</td>
<td>TIPO COBRO</td>
<td>FOLIO DOCUMENTO</td>
<td><?php echo $mr['observacion']; ?></td>
</tr>
<?php
}
?>

</table>
