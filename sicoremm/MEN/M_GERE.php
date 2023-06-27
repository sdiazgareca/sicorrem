<script type="text/javascript">

$(document).ready(function() {
$('#menu_main ul li a').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax1').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });

});
</script>

<div id="menu_main">
<ul>
<li><a href="FOR/GERENCIA/M_GERE.php">Planes</a></li>
<li><a href="FOR/GERENCIA/M_PSAL.php">Previsi&oacute;n de Salud</a></li>
<li><a href="FOR/GERENCIA/M_ATME.php">Antecedentes M&eacute;dicos</a></li>
<li><a href="FOR/GERENCIA/M_CONT.php">Contratos</a></li>
<li><a href="FOR/GERENCIA/M_INCO.php">Incorporaciones</a></li>
<li><a href="FOR/GERENCIA/M_BUSQ.php">B&uacute;squedas</a></li>
</ul>
</div>
<br />
<div id="ajax1"></div>