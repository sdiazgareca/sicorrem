<?php
include('../conf.php');
include('../bd.php');


if ( (isset($_GET['convenio'])) && (isset($_GET['paciente'])) && (isset($_GET['telefono'])) && (isset($_GET['celular']))  && (isset($_GET['fecha_traslado'])) && (isset($_GET['direco'])) && (isset($_GET['direccion_destino'])) && (isset($_GET['ciudad'])) && (isset($_GET['costo']))){

$hora_llamado = date("Y-m-d h:m");

$con ="SELECT MAX(correlativo) AS maximo FROM fichas";
$res = mysql_query($con);
$mat = mysql_fetch_array($res);
$correlativo =$mat['maximo'];
$correlativo = $correlativo + 1;

$con2 ="SELECT MAX(cod) AS maximo FROM traslados";
$res2 = mysql_query($con2);
$mat2 = mysql_fetch_array($res2);
$cod =$mat2['maximo'];
$cod = $cod + 1;

$_GET['valor_e'] = (is_numeric($_GET['valor_e'] ))? $_GET['valor_e'] : 0;
$consulta = "insert into traslados(cod,tipo_traslado,convenio,fecha_traslado,Direccion_origen, Direccion_destino,ciudad,costo,estado,tipo_plan,valor) values ('".$cod."','4','1','".$_GET['fecha_traslado']."','".$_GET['direco']."','".$_GET['direccion_destino']."','".$_GET['ciudad']."','".$_GET['costo']."','0',6,'".$_GET['valor_e']."')";
$resultados = mysql_query($consulta);

$consulta2="INSERT INTO fichas(tipo_plan,color,correlativo,traslado,paciente,telefono,celular,hora_llamado,obser_man,estado) VALUES ('TRA_PAR','4','".$cod."','".$cod."','".$_GET['paciente']."','".$_GET['telefono']."','".$_GET['celular']."','".$hora_llamado."','TRA','0')";
$resultados = mysql_query($consulta2);


	if($resultados){
		echo '<div class="mensaje"><img src="IMG/tick.png">Los cambios se han realizado con exito.</div>';
		exit;}
}
?>
<br />
<table style="width:480px;">
<tr>
<td class="celda1"><h1 style="color:#FFFFFF">Traslado Simple de Particulares</h1></h1></td>
</tr>
</table>

<table style="width:480px;">
<tr>
<td class="celda2">
Paciente&nbsp;
<input type="text" id="paciente_convenio" size="30">
<br /><br />
Telefono&nbsp;<input type="text" id="fono_paciente">&nbsp;Celular&nbsp;<input type="text" id="celular_paciente">
<br /><br />
&nbsp;Fecha Traslado 
<select id="dia">
<option value="<?php echo date(d); ?>"><?php echo date(d); ?></option>
<?php
for($i=1; $i<=31;$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
&nbsp;
<select id="mes">
<option value="<?php echo date(m); ?>"><?php echo date(m); ?></option>
<?php
for($i=1; $i<=12;$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
&nbsp;
<select id="anio">
<option value="<?php echo date(Y) ?>"><?php echo date(Y); ?></option>
<option value="<?php echo (date(Y) + 1) ?>"><?php echo (date(Y) + 1); ?></option>
</select>
&nbsp;Hora&nbsp;
<select id="hora">
<option value="<?php echo date(h); ?>"><?php echo date(h); ?></option>
<?php
for($i=01; $i<=24;$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
:
<select id="minutos">
<option value="0">00</option>
<?php
for($i=15; $i<60;$i = $i +15){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
<br /><br/>
Direccion de Origen <input type="text" name="direco" id="direco" size="40">
<br><br>
Direccion Destino
<br /><br/>
C. Hospitalario&nbsp;
<input value="1" type="radio" id="dir" name="dir" onClick="$ajaxload('lugarr','Traslados/centrohospitalario.php',false,false,false);">
&nbsp;

Direccion&nbsp;
<input value="2" type="radio" id="dir" name="dir"onClick="$ajaxload('lugarr','Traslados/dentrodeantofagasta.php',false,false,false);">&nbsp;
Fuera de Antofagasta&nbsp;
<input value="3" type="radio" id="dir" name="dir" onClick="$ajaxload('lugarr','Traslados/fueradeantofagasta.php',false,false,false);">&nbsp;
Especial&nbsp;
<input value="4" type="radio" id="dir" name="dir" onClick="$ajaxload('lugarr','Traslados/especial.php',false,false,false);">
<br /><br/>
<div id="lugarr"></div>
<br /> <br />
<div align="right"><input type="button" value="Guardar" onClick="guradar_traslado('Tras_Simple_Par.php','TRA3','6')" class="boton"></div>
</td>
</tr>
</table>