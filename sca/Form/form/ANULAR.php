Anular &nbsp;
<select style="width:120px;" id="destino_<?php echo $matriz_resultados['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php

if ($matriz_resultados['cod'] != '4'){
$consu = "where otros = 1";
}
else{
$consu = "where azul = 1";
}
$query = "select cod,destino from destino ".$consu."";
$respuesta = mysql_query($query);
while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>

<input type="button" value="Aceptar" class="boton" onClick="
if(confirm('Esta seguro de anular el llamado?')){

var destino = document.getElementById('destino_<?php echo $matriz_resultados['correlativo']; ?>').value;
  
$ajaxload('bus','Form/Actualizar_ficha.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&direccion=<?php echo $matriz_resultados['direccion']; ?>&color=<?php echo $matriz_resultados['cod'];; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
if($ajaxload){
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);

}
}
}
" />&nbsp;