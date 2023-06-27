<script type="text/javascript">
$(document).ready(function() {


$('#dicom').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#in').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});


 $('a:contains("Listado")').click(function() {
	var ruta = $(this).attr('href');
 	$('#in').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

});


</script>

<br />
<h1>INGRESO PAGOS DICOM</h1>

<form method="post" id="dicom" action="INT/dicom.php">
<table style="width:auto;">
  <tr>

   <td><strong>CONTRATO</strong></td>
   <td><input type="text" name="num_solici" /></td>
    <td><strong>FECHA</strong></td>
    <td><input type="text" name="FECHA" class="calendario" /></td>
   <td><strong>NOMBRES</strong></td>
   <td><input type="text" name="NOMBRES" /></td>
   <td><strong>MOTIVO</strong></td>
   <td><input type="text" name="MOTIVO" /></td>
  </tr>

  <tr>
   <td><strong>MONTO</strong></td>
   <td><input type="text" name="MONTO" /></td>
   <td><strong>INGRESO</strong></td>
   <td><input type="text" name="INGRESO" /></td>
   <td><strong>ATENDIDO POR</strong></td>
   <td><input type="text" name="ATENDIDO" /></td>

    <td><input type="submit" value="Ingresar" class="boton"></td>
    <td><a class="boton" href="INT/dicom.php">Listado</a></td>
  </tr>
</table>
</form>







<div id="in"></div>