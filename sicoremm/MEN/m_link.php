<?php
include('../DAT/conf.php');
include('../DAT/bd.php');
?>

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

<?php
$modulos_sql = "select  link_nombre, link_direccion FROM privilegios WHERE cod_usuario='".$_GET['cod_usuario']."' AND cod_modulo='".$_GET['modulo']."'";

//echo $modulos_sql;

$modulos_query = mysql_query($modulos_sql);

?>
<div id="menu_main">

<?php
echo "<ul>";
while ($modulos = mysql_fetch_array($modulos_query)){
?>
<li><a href="<?php echo $modulos['link_direccion']; ?>" class="enlace"><span><?php echo $modulos['link_nombre']; ?></span></a></li>
 <?php
}
echo "</ul>";
?>
</div>
<div id="ajax1"></div>
