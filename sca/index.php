<?php

session_start();
date_default_timezone_set("America/New_York");
include('conf.php');
include('bd.php');

if ( (isset($_POST['usuario_v'])) and (isset($_POST['clave']))){
$usuario_v = $_POST['usuario_v'];
$clave = $_POST['clave'];
}

if ((isset($_GET['usuario_v'])) and (isset($_GET['clave']))){
$usuario_v = $_GET['usuario_v'];
$clave = $_GET['clave'];
}

$cerrarsesion = $_GET['cerrarsesion'];
if ($cerrarsesion == 1){
session_destroy();
}

$contenidos = "select privilegio,rut, clave,nombre1,nombre2,apellido from operador where rut ='".$usuario_v."'  and clave = '".$clave."' and estado =1";
$resultados_contenidos = mysql_query ($contenidos, $conexion) or die ("Fallo en la consulta");
$nfilas = mysql_num_rows ($resultados_contenidos);
$matriz_resultados1 = mysql_fetch_array($resultados_contenidos);

if ($nfilas > 0){
$usuario_valido = $usuario_v;
$_SESSION["rut"] = $usuario_valido;
$_SESSION["identificador"]=$matriz_resultados1['rut'];
$_SESSION["nombre1"] = $matriz_resultados1['nombre1'];
$_SESSION["nombre2"] = $matriz_resultados1['nombre2'];
$_SESSION["apellido"] = $matriz_resultados1['apellido'];
$_SESSION["privilegio"] = $matriz_resultados1['privilegio'];
}
?>
		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 2.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REMM</title>


	<style type="text/css">
	
	/* START CSS NEEDED ONLY IN DEMO */
	
	#mainContainer{
		width:660px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}
	
	</style>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>




<!-- Hojas de Estilo -->
<link href="CSS/Estructura.css" rel="stylesheet" type="text/css" />
<link href="CSS/Fuentes.css" rel="stylesheet" type="text/css" />
<!-- Libreria simple -->

<script type="text/javascript" src="JS/js/simple.js"></script>
<script type="text/javascript" src="JS/js/simpleacco.js"></script>
<script type="text/javascript" src="JS/js/simpleajax.js"></script>
<script type="text/javascript" src="JS/js/simpleslish.js"></script>
<script type="text/javascript" src="JS/Buscar.js"></script>
</head>

<body onload="javascript:$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',true);">

<div id="contenedor">
<div id="patallagrande"></div>

<?PHP
// Sesión iniciada
if ( (isset($_SESSION["rut"])) && ($_SESSION["privilegio"] != 3) ){
?>
<div id="cabezera" style="float:left">
<img src="IMG/LogoRemm.jpg" />
&nbsp;
<?php
$traslado = "select count(tipo_traslado) as nu , min(DATE_FORMAT(fecha_traslado,'%H:%s')) as max from traslados where estado = 0 and DATE_FORMAT(fecha_traslado,'%Y') = ".date('Y')." and DATE_FORMAT(fecha_traslado,'%m')='".date('m')."' and DATE_FORMAT(fecha_traslado,'%d')='".date('d')."'";

$tras_res = mysql_query($traslado);
$res = mysql_fetch_array($tras_res);

if ($res['nu'] > 0){
?>
<blink style="color:#009900">Hoy tiene <?php echo $res['nu']; ?> traslados programados, proximo a las <?php echo $res['max']; ?> Hrs. </blink>
<?php
}
?>
</div>

<div style="display:none" id="rutoperador">
<?php echo $_SESSION["identificador"] ?>
</div>
<div style="background-color:#FFC000; padding:2px; font-size:9px;">
Operador: <? echo $_SESSION["nombre1"].'&nbsp;'.$_SESSION["apellido"]; ?>
</div>

<div class="relleno" align="left">

<?php

if( $_SESSION["privilegio"] == 2){
?>
<a href="#" class="boton11" style="color:#003366" onclick="$ajaxload('bus', 'Operador/form_operador_ingresar.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);">&nbsp;Usuarios</a>

<a href="#" class="boton11" style="color:#003366" onclick="$ajaxload('bus', 'PLANES_TRASLADOS/menu_planes.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);">&nbsp;PTras</a>

<a href="#" class="boton11" style="color:#003366" onclick="$ajaxload('bus', 'Amb/AgregarAmbulancia.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);">&nbsp;Ambulancias</a>

<a href="#" class="boton11" onclick="$ajaxload('bus', 'Amb/AgregarPersonal.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Personal</a>

<a href="#" class="boton11" onclick="$ajaxload('bus', 'Sintomas/menu_sintomas.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Sintomas</a>

<a href="#" class="boton11" onclick="$ajaxload('bus', 'Diagnostico/menu.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Diag</a>
<?php
}
?>
<a class="boton11" href="#" onclick="$ajaxload('bus', 'Amb/AgregarMovil.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Movil</a>

<a class="boton11" href="#" onclick="$ajaxload('bus', 'atenciones/lista.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Aten</a>

<!--
<a class="boton11" href="#" onclick="$ajaxload('bus', 'medimel.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" style="color:#003366">Medimel</a>
-->
<a href="#" class="boton11" onclick="$ajaxload('bus', 'Form/busqueda.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);"style="color:#003366">Buscar</a>

<a href="#" class="boton11" style="color:#003366"
onclick="$ajaxload('bus', 'Form/AgregarFichaParticular.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);">Particular</a>

<a href="#" style="color:#003366" class="boton11" onclick="$ajaxload('bus','Traslados/Menu_traslados.php?operador=<?php echo $_SESSION["identificador"]; ?>',false,false,false);">Traslados</a>

<a href="#" style="color:#003366" class="boton11" onclick="abrir('patallagrande');$ajaxload('patallagrande','patallaComp.php','Cargando ...',false,false);">PC</a>

<a href="#" class="boton11" style="color:#003366"
onclick="$ajaxload('bus', 'estadistica/GENERAR_MANTENCION.php','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);">DOC</a>

<a class="boton11" href="index.php?cerrarsesion=1" style="color:#003366">Salir</a>&nbsp;
</div>

<div id="control_de_tiempos"></div>
<div id="der"></div>
<div id="editar" style="position:absolute"></div>
<div id="izq">
<!-- fin relleno -->
<div id="bus">
<div id="formulario">
<form method="get">
<div id="control_de_tiempos"></div>

<table width="540px" align="center">
<tr>
<td class="celda1">B&uacute;squeda</td>
</tr>
</table>
<table width="540px" align="center">
<tr>
<td class="celda4"><strong>&nbsp;Rut</strong>&nbsp;
<input name="rut" type="text" id="rut" size="10" />
&nbsp;
<a href="#" class="boton1" onclick="javascript:buscar();"><img src="IMG/page_white_magnify.png" /></a>&nbsp;N&deg;&nbsp;Contrato&nbsp;
<input type="text" size="10" id="nro_contrato" />
&nbsp;<a href="#" class="boton1" onclick="javascript:buscar3();"><img src="IMG/page_white_magnify.png" /></a>
Traslado Convenio 
<a href="#" class="boton1" onclick="$ajaxload('bus','Amb/Traslados_convenios.php',false,false,false);"><img src="IMG/folder.png" width="16" height="16" /></a>
<br /><br />
<strong>&nbsp;Apellidos</strong>/Nombre
<input name="apaterno" type="text" id="apaterno" />&nbsp;
&nbsp;
<input name="nombre" type="text" id="nombre"/>&nbsp;
&nbsp;
&nbsp;<a href="#" class="boton1" onclick="javascript:buscar2();"><img src="IMG/folder_magnify.png" /></a>&nbsp;
&nbsp;<a href="#" class="boton1" onclick="javascript:limpiar()"><img src="IMG/tick.png" /></a>
<br /><br />
<div id="bus2"></div>
</td>
</tr>
</table>

</form>
</div><!-- fin formulario -->

</div>
<!-- fin bus -->
</div><!-- fin contenedor -->
<?php
}
else if(isset($_SESSION["rut"]) && $_SESSION["privilegio"] == 3 ){
?>

<div id="cabezera">
<img src="IMG/LogoRemm.jpg" />
</div><!-- fin cabezera -->
<div style="background-color:#FFC000; padding:2px; font-size:9px;">
Operador: <? echo $_SESSION["nombre1"].' '.$_SESSION["nombre2"].' '.$_SESSION["apellido"]; ?>
</div>
<div  id="contenido">

<div class="relleno">

<a class="boton11" href="index.php?cerrarsesion=1" style="color:#003366">Cerrar Sesion</a>&nbsp;
</div>
<table style="width:800px;">
<tr>
<td class="celda1">Nro de Contrato  <input type="text" id="copago_contr" />&nbsp;

<input class="boton" type="button" value="Buscar" id="copago_bus1" onclick="$ajaxload('cop', 'copagos/busqueda_contr.php?ncontrato='+document.getElementById('copago_contr').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" />&nbsp;

Rut <input type="text" id="copago_rut" />&nbsp;<input class="boton" type="button" value="Buscar" id="copago_bus2" />&nbsp;
</td>
</tr>
<tr>
<td class="celda2"><div id="cop" style="width:auto; height:auto; min-height:400px;">&nbsp;</div></td>
</tr>
</table>
</div>

<?php
}
else if (isset ($usuario_v))
{
?>
<div id="cabezera">
<img src="IMG/LogoRemm.jpg" />
</div><!-- fin cabezera -->
<div  id="contenido">
<div class="modulo_relleno">
<br />
<div align="center"><img src="IMG/error.png"/></div><div align="center">Acceso denegado.</div>
<div align="center">[<a href='index.php' style="color:#003366">Ingresar</a>]</div>
</div>
</div>
<?php   
}

else
   {
?>
<div id="cabezera">
<img src="IMG/LogoRemm.jpg" />
</div><!-- fin cabezera -->
<div id="contenido">

<div class="modulo_relleno">
<br />
<FORM CLASS='negocios' ACTION='index.php' method="post" name="validacion">
<table class='tabla2'>
<tr>
<td><LABEL CLASS='etiqueta-entrada'>Usuario&nbsp;</LABEL></td>
<td><INPUT NAME='usuario_v' TYPE='TEXT' maxlength="100">
<br /></td>
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
</div>
<?php
}
?>
</div>
</body>
</html>
<?php
mysql_close ($conexion);
?>
