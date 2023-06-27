<table class="celda3">
<tr>
<td>
<div style="padding:5px;">

<table>
<tr>
<td>Contrato</td><td><input type="text" id="contrato" /></td>
<td>
<input type="button" value="Buscar" onclick="$ajaxload('info', 'php/natenciones2.php?protocolo='+document.getElementById('contrato').value,false,false,false); alert(document.getElementById('contrato').value);" class="boton"/>
</td>
</tr>

<tr>
<td>RUT</td>
<td><input type="text" id="corres" /></td>
<td>
<input type="button" value="Buscar" onclick="$ajaxload('bus', 'estadistica/lista.php?correlativo='+document.getElementById('corres').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" class="boton"/>
</td>
</tr>

<tr>
<td>Protocolo</td>
<td><input type="text" id="corres" /></td>
<td><input type="button" value="Buscar" onclick="$ajaxload('bus', 'estadistica/lista.php?correlativo='+document.getElementById('corres').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" class="boton"/>
</td>
</tr>
</table>



</div>
<?php
include('../conf.php');
include('../bd.php');



?>
<div id="info">&nbsp;</div>
</td>
</tr>
</table>