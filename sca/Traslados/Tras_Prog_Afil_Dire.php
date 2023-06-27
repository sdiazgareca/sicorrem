<?php
include('../conf.php');
include('../bd.php');
?>
<br />
<table style="width:480px;">
<tr>
<td class="celda1"><h1  style="color:#FFFFFF">Traslado Programados Afiliados Directos</h1></td>
</tr>
</table>


<table style="width:480px;">
<tr>
<td class="celda2">
<?php
if ($_GET['rut']){

$query ="select afiliados.obra_numero AS isapre,afiliados.num_solici,afiliados.nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo as codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,tipo_plan.tipo_plan,reducido, planes.desc_plan,titular,(YEAR(CURRENT_DATE)-YEAR(fecha_nac)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fecha_nac,5)) as edad,planes.cod_plan,obras_soc.nro_doc as isapre,afiliados.cod_plan  as plannn
from afiliados
inner join mot_baja on afiliados.cod_baja = mot_baja.codigo
inner join categoria on afiliados.categoria = categoria.categoria
inner join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
inner join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
inner join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where afiliados.nro_doc ='".$_GET['rut']."' AND (afiliados.cod_baja ='00' || afiliados.cod_baja = '05' || afiliados.cod_baja= 'AZ')";

$resultados = mysql_query($query);
while ($matriz_resultados = mysql_fetch_array($resultados)){
include('../Traslados/BusquedaTraslados.php');
}
}
else{
?>

Rut&nbsp;
<input type="text" id="rut" size="15" maxlength="10">
&nbsp;<br />
<br/>
<div id="lugarr"></div>
<br /> <br />
<div align="right"><input type="button" value="Buscar" onclick="var rut = document.getElementById('rut').value;
$ajaxload('traslado_s','Traslados/Tras_Prog_Afil_Dire.php?rut='+rut,false,false,false);" class="boton"></div>
<?php
}
?>
</td>
</tr>
</table>
