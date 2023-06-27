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
<li><a href="FOR/TESORERIA/M_TESO.php">Contratos</a></li>
<li><a href="FOR/TESORERIA/M_INCO.php">Incorporaciones</a></li>
<li><a href="FOR/TESORERIA/F_MEDI.php">Copagos</a></li>
<li><a href="FOR/VENTAS/M_REND.php">Rendiciones</a></li>
<li><a href="FOR/VENTAS/M_FLEX.php">Flexwin</a></li>
<li><a href="FOR/TESORERIA/M_BOLL_VENT.php">Ingresos Ventas</a></li>
</ul>
</div>
<br />
<div id="ajax1"></div>