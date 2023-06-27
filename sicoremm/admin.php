<?php
include('DAT/conf.php');
include('DAT/bd.php');
if ( $_POST['usuario_v'] == 'AdMiN' && $_POST['clave'] =='nuncal'){

$_SESSION["identificador"]=1;
}
else{
$_SESSION["identificador"] = 0;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SICOREMM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="JS/jquery/jquery.js"></script>
<script type="text/javascript" src="JS/jquery/jqueryRut.js"></script>
<script type="text/javascript" src="JS/jquery/Jquery.Rut.min.js"></script>
<script type="text/javascript" src="JS/DISP.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.datepicker.js"></script>


<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>


<link type="text/css" rel="stylesheet" href="JS/calendar/development-bundle/themes/base/jquery.ui.all.css" />
<link href="CSS/estructura.css" rel="stylesheet" type="text/css" />
<link href="CSS/fuentes.css" rel="stylesheet" type="text/css" />
<link href="CSS/menu.css" rel="stylesheet" type="text/css" />
<link href="CSS/main.css" rel="stylesheet" type="text/css" />
</head>

<body>


<?php
if ( $_SESSION["identificador"] > 0 ){
?>

<div id="contenedor">
<div id="cabezera">

  <table width="100%">
  <tr>
  <td align="left"><img src="IMG/L1.jpg" /></td>
  <td align="right">&nbsp;</td>
  </tr>
</table>

</div><!-- cabezera -->

<div class="usuario">&zwnj;</div><!-- usuario -->
<div id="contenido">

<div id="cargando_imagen">
<img alt="" src="IMG/C3.gif" />
<br />
Espere...
</div>

<div id="ajax">
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


<div id="menu_main" style=" width: 100%;">
<ul>
<li><a href="FOR/ADMIN/M_FORM.php">Ingreso</a></li>
<li><a href="FOR/ADMIN/M_MAIN.php">Listado</a></li>
</ul>
</div>

<div id="ajax1">

    <div align="right">
<img src="IMG/I2.PNG"/>
</div>

</div>




</div><!-- ajax -->
</div><!-- contenido -->
</div><!-- contenedor -->
<?php
}
else{
?>
<div id="contenedor">
<div id="cabezera">

<table width="100%">
<tr>
<td align="left"><img src="IMG/L1.jpg" /></td>
<td align="right">&nbsp;</td>
</tr>
</table>

</div><!-- cabezera -->


<div id="contenido">
  <div class="usuario">&nbsp;</div><!-- usuario -->
  <div id="tabs1">&nbsp;</div>
<div id="ajax">

<h1>ADMINISTRADOR</h1>

<FORM ACTION='admin.php' method="post" name="validacion">
<table class='tabla2'>
<tr>
<td><LABEL CLASS='etiqueta-entrada'>Usuario&nbsp;</LABEL></td>
<td><INPUT NAME='usuario_v' TYPE='TEXT' maxlength="100"><br /></td>
</tr>

<tr>
<td><LABEL CLASS='etiqueta-entrada'>Clave&nbsp;</LABEL></td>
<td><INPUT TYPE='PASSWORD' NAME='clave' maxlength="6"><br /></td>
</tr>

<tr>
<td>&nbsp;</td>
<td><div align="right"><INPUT TYPE='SUBMIT' VALUE='Entrar' class="boton"></div></td>
</tr>

</table>

</FORM>
</div>
</div><!-- contenido -->
</div><!-- contenedor -->
<?php
}
?>
</body>
</html>
