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
<li><a href="FOR/VENTAS/M_VEND.php">Vendedores</a></li>
<li><a href="FOR/VENTAS/M_AUDI.php">Auditoria</a></li>
<li><a href="FOR/VENTAS/M_COMI.php">Comisiones</a></li>
<li><a href="FOR/VENTAS/M_BONO.php">Bonos</a></li>
<li><a href="FOR/VENTAS/M_INCO.php">Incorporaciones</a></li>
<li><a href="FOR/VENTAS/M_REND.php">Rendiciones</a></li>
<li><a href="FOR/GERENCIA/M_BUSQ.php">B&uacute;squedas</a></li>
</ul>
</div>
<br />
<div id="ajax1"></div>