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
<li><a href="FOR/COBRANZA/M_COBR.php">Recaudadores</a></li>
<li><a href="FOR/COBRANZA/M_ZONA.php">Zonas</a></li>
<li><a href="FOR/CONVENIOS/M_EMPR.php">Convenios</a></li>
<li><a href="FOR/CONVENIOS/M_GIRO.php">Giros</a></li>
<li><a href="FOR/COBRANZA/M_PAGO.php">Cobranza</a></li>
<li><a href="FOR/VENTAS/M_EVENT.php">Eventos y Traslados</a></li>
<li><a href="FOR/CONVENIOS/F_BUSQ_CONV.php">Nominas</a></li>
<li><a href="FOR/COBRANZA/F_BUSQ_MAND.php">Mandatos</a></li>
<!--<li><a href="FOR/COBRANZA/F_PAGOS_I.php">PAC</a></li> -->
<li><a href="FOR/COBRANZA/F_PAGOS_II.php">CD</a></li>
<li><a href="FOR/COBRANZA/F_PAGOS_III.php">CONV</a></li>
<li><a href="FOR/COBRANZA/F_PAGOS_TEXT.php">PAC Archivo</a></li>

</ul>
</div>
<br />
<div id="ajax1"></div>