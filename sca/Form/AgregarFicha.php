
<div class="formulario">
<div id="popup"></div>
<form method="get" name="form1">

<? echo $_SESSION["nombre1"].'&nbsp;'.$_SESSION["apellido"]; ?>

<table style="width:500px;">
<tr>
<td class="celda1"><div style="width:auto; float:left">Numero de Contrato&nbsp;</div><div id="ncontrato" style="float:left; width:auto;"><?php echo $matriz_resultados['num_solici']; ?></div></td>
</tr>
</table>

<table style="width:500px;">
<tr>
<td class="celda2">
<h1><a onclick="$toggle('myId2');" class="boton1"><img src="IMG/user.png" width="16" height="16" /></a>&nbsp;Datos Afiliados&nbsp;

<a href="#" class="boton1" onclick="$ajaxload('cargas', 'PHP/main.php?muestracargas=1&grupo_nd=<?php echo $matriz_resultados['num_solici']; ?>','<p>Cargando</p>',false,false);">
<img src="IMG/user_green.png" width="16" height="16" /></a>
&nbsp;Cargas</h1>

<table style="width:480px; background:#FFFEE0" class="celda3">
<tr style="background-color:#FFFEE0">
<td class="celda3" style="background-color:#FFFEE0">Rut</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="a"><?php echo htmlentities($matriz_resultados['nro_doc']); ?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Afiliado</td>
<td  class="celda2" style="background-color:#FFFEE0"><div id="paciente"><?php echo htmlentities(strtoupper($matriz_resultados['nombre1'])); ?> <?php echo strtoupper($matriz_resultados['$nombre2']); ?> <?php echo htmlentities(strtoupper($matriz_resultados['apellido']));?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Estado</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['descripcion1']);?></td>
</tr>
</table>
    
    
    
<div id="myId2" style="display:none;" >
<?php 
include('../Form/MuestraDatos.php');
?>
    
    <?php
    $sql = "SELECT ate_medicos.descripcion 
            FROM ate_medicos_reg INNER JOIN ate_medicos ON ate_medicos.cod = ate_medicos_reg.ate_medicos
            WHERE ate_medicos_reg.codigo='".$matriz_resultados['nro_doc']."' GROUP BY ate_medicos.cod";
    
    
    $q = mysql_query($sql);
    $n = mysql_num_rows($q);
    if($n > 0){
        echo '<h1>Antecedentes Medicos</h1>';
        echo '<table style="width:480px; background:#FFFEE0" class="celda3">';
        while($sal = mysql_fetch_array($q)){
            echo '<tr>';
            echo '<td class="celda2" style="background-color:#FFFEE0">'.htmlentities($sal['descripcion']).'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    ?>
    
</div>

<br />
<div id="cargas"></div>
<?php

$funcion ='javascript:GuardarFicha();';
if (($matriz_resultados['tipo_plan'] == '1') ||($matriz_resultados['tipo_plan'] == '2')){
$funcion ='javascript:GuardarFicha();';
}
else{
$funcion ='javascript:GuardarFicha1();';
}

if (($matriz_resultados['tipo_plan']==3) || ($matriz_resultados['tipo_plan']==5)){
?>
<img src="IMG/user.png" width="16" height="16" />&nbsp;Paciente&nbsp;
<input type="text" size="40" class="text" id="paciente_area"/>
&nbsp;<img src="IMG/user.png" width="16" height="16" />&nbsp;Edad&nbsp;
<input type="text" size="2" class="text" id="edad_area"/>
<?php
}
else{
?>
<br /><br />
<img src="IMG/user_edit.png" width="16" height="16" />&nbsp;Agregar Carga no Registrada
<select id="AgregarCargaNoregistrada">
<option class="text" value="0"></option>
<option class="text" onclick="javascript:AgregarCarga()" value="1">Si</option>
<option class="text" onclick="javascript:AgregarCarga()" value="0">No</option>
</select>
<?php
}
if(($matriz_resultados['codigo'] == '00') || ($matriz_resultados['codigo'] == '05') || ($matriz_resultados['codigo'] == 'AZ')){
echo "";
}
else {
?>
&nbsp;
Autorizado por&nbsp;
<select id="autorizadopor">
<option class="text" value="0"></option>
<?php

$consulta = "select cod, autorizacion from autorizacion order by autorizacion";
$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" value="<?php echo $matriz_resultados['cod'];?>"><? echo htmlentities($matriz_resultados['autorizacion']);?></option>
<?php
}
?>
</select>
<?php
}
?>

<div id="AgregarCarga"></div>
<br />
<!----------------------------------------------------------------------------------------------------------------->
<div id="masig">
Fono&nbsp;
<input name="telefono" id="telefono" type="text" size="5" maxlength="6" class="text">
&nbsp;Celular&nbsp;
<select id="cel">
<option class="text" value="9">9</option>
<option class="text" value="8">8</option>
<option class="text" value="7">7</option>
</select>
<input type="text" size="10" maxlength="8" id="celular" />
<br /><br />
<?php
$consulta = "select domicilios.calle,domicilios.numero,domicilios.piso,domicilios.departamento,domicilios.localidad
from domicilios  where domicilios.nro_doc =$rutt";
$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);

if($matriz_resultados['piso'] == 0){
$value = 'Calle '.$matriz_resultados['calle'].' Numero '.$matriz_resultados['numero'].' Localidad '.$matriz_resultados['localidad'];
}
else {
$value = 'Calle '.$matriz_resultados['calle'].' Numero '.$matriz_resultados['numero'].'Piso'.$matriz_resultados['piso'].' Departamento '.$matriz_resultados['departamento'].' Localidad '.$matriz_resultados['localidad']; 
}

?>
<div id="DetalleAmb">&nbsp;</div>
Direcci&oacute;n&nbsp;
<input class="text" name="direccion" id="direccion" type="text" size="40">
<a href="#" class="boton1" onclick='javascript:document.getElementById("direccion").value=""';><img src="IMG/tick.png" width="16" height="16" /></a><br />
<br />
Entre&nbsp;
<input class="text" name="entre" id="entre" type="text" size="40">
&nbsp;Sector&nbsp;
<select id="sector">
<option class="text" value="0"></option>
<?php

$consulta = "select cod,sector from sector order by sector";
$resultados = mysql_query($consulta);

while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" value="<?php echo $matriz_resultados['cod'];?>"><? echo htmlentities($matriz_resultados['sector']);?></option>
<?php
}
?>
</select>
<br /><br />
</div>
<!----------------------------------------------------------------------------------------------------------------->
<div id="sint" class="sintoma" ></div>
</td>
</tr>
</table>
<table style="width:500px;">
<tr>
<td  class="celda2"><a href="#" class="boton1"><img src="IMG/folder_magnify.png" width="16" height="16" /></a>&nbsp;Sintoma</td>
<td  class="celda2"><img src="IMG/color_swatch.png" width="16" height="16" />Clave</td>
<td  class="celda2"><a href="#" class="boton1" 
onclick="if(confirm('Desea mostrar los moviles asignados?')){
$ajaxload('movil_asignados','Form/Muestra_moviol_compartir.php',false,false,false);}"><img src="IMG/ICONOS/car.png" width="16" height="16" /></a>&nbsp;Movil Asig <a href="#" onclick="if(confirm('Desea mostrar los moviles disponibles?')) {
$ajaxload('movil_asignados','Form/Muestra_moviol_compartir2.php',false,false,false);}" class="boton1"><img src="IMG/car_add.png" width="16" height="16" /></a>Movil Libr</td>
</tr>
<tr>
<td>

<select name="sintoma" size="5" multiple="MULTIPLE" id="sintoma1" style=" width:310px;background-color:#FFFEE0; font-size:10px; height:80px" >
<?php

$consulta = "select cod,sintoma from sintomas order by sintoma";
$resultados = mysql_query($consulta);

while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option  class="text" ondblclick="sinto('<? echo htmlentities($matriz_resultados['cod']);?>','<? echo htmlentities($matriz_resultados['sintoma']);?>')" value="<?php echo $matriz_resultados['cod'].'&nbsp;'.$matriz_resultados['sintoma'];?>"><? echo htmlentities($matriz_resultados['sintoma']);?></option>
<?php
}
?>
</select>
</td>

<td>
<select size="5" id="color" name="color" style="background-color:#FFFEE0; height:80px; font-size:10px; width:80px">
<option class="text" value="0"></option>
<?php
$consulta = "select cod,color from color where cod < 4 order by cod";
$resultados = mysql_query($consulta);

while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" value="<?php echo $matriz_resultados['cod'];?>"><? echo htmlentities($matriz_resultados['color']);?></option>
<?php
}
?>
</select>
</td>
<td>
<div id="movil_asignados">
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0; height:80px; width:90px; height:80px; font-size:10px">
<?php
include('../conf.php');
include('../bd.php');

$consulta = "select numero from movilasig where estado = 0 and medico >1";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" ondblclick="DetalleAmbulancia('<? echo $matriz_resultados['numero'];?>')" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo 'Movil '.$matriz_resultados['numero']; ?></option>
<?php
}
?>

<?php
$consultaY = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosY = mysql_query($consultaY);
while($matriz_resultadosY = mysql_fetch_array($resultadosY)){
?>
<option class="text" value="<?php echo $matriz_resultadosY['cod']; ?>">Espera&nbsp;<?php echo $matriz_resultadosY['espera']; ?></option>
<?php
}
?>
</select>
</div>
</td>
</tr>
</table>
<table style="width:500px;">
<tr>
<td class="celda2"><img src="IMG/note.png" width="16" height="16" />&nbsp;Observaciones<br />
<input class="text" name="observacion" type="text" id="observacion" value="" size="50" />&nbsp;
<input type="button" value="Guardar" class="boton" onclick="<?php echo $funcion;?>" />
</td>
</tr>
</table>

</td>
</tr>
</table>
</form>
</div>
