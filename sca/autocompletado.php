<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<input type="text" id="input-fill" autocomplete="off"     onkeyup="inputFilling(event, this)"     onblur="setInput(this, document.getElementById('lista'))">     &nbsp; <img src="abajo.gif" border="0"     onmouseover="cambiarImagen(this, true)"     onmouseout="cambiarImagen(this, false)" class="boton"     onclick="despliegaFilling(document.getElementById('input-fill'), datos, document.getElementById('lista'))"     title="Importar"><div class="contenedor"><div id="lista"     class="fill"></div></div>  
</body>
</html>
