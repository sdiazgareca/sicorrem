
<?php
include('DAT/conf.php');
include('DAT/bd.php');
if ( (isset($_POST['usuario_v'])) and (isset($_POST['clave']))){

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

<div class="usuario">Nombre de Usuario</div><!-- usuario -->
<div id="contenido">
<div id="tabs1">
<ul>
<li><a href="MEN/M_VENT.php" class="enlace"><span>VENTAS</span></a></li>
<li><a href="MEN/M_COBR.php"><span>COBRANZA</span></a></li>
<li><a href="MEN/M_GERE.php"><span>GERENCIA</span></a></li>
<li><a href="MEN/M_FACTU.php"><span>FACTURACION</span></a></li>
<li><a href="MEN/MTES.php"><span>TESORERIA</span></a></li>
<li><a href="MEN/M_REND.php"><span>RENDICION</span></a></li>
<!-- <li><a href="MEN/M_REND_COB.php"><span>RDC</span></a></li> -->
<li><a href="MEN/M_BOL.php"><span>GESTOR DE COMP</span></a></li>
<li><a href="MEN/M_EST.php"><span>ESTADISTICA</span></a></li>
</ul>
</div>
<br /><br />
<div id="cargando_imagen">
<img alt="" src="IMG/C3.gif" />
<br />
Espere...
</div>

<div id="ajax">
<div align="right">
<img src="IMG/I2.PNG"/>
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

<h1>VALIDACION SICOREMM</h1>

<FORM ACTION='index.php' method="post" name="validacion">
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