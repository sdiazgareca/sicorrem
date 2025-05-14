<script type="text/javascript">
	$(document).ready(function () {

		$('#ajax #ff_EPSALUD').submit(function () {

			var url_ajax = $(this).attr('action');
			var data_ajax = $(this).serialize();

			$.ajax({
				type: 'POST', url: url_ajax, cache: false, data: data_ajax, success: function (data) {
					$('#ajax3').html(data);
				}
			})

			url_ajax = "";
			data_ajax = "";

			return false;
		});

		$('#ajax3 a:contains("ELIMINAR")').click(function () {

			if (!confirm(" Esta seguro de eliminar el estado del Plan?")) {
				return false;
			}
			else {
				var ruta = $(this).attr('href');
				$('#ajax3').load(ruta);
				$.ajax({ cache: false });
				ruta = "";
				return false;
			}
		});


		$('a:contains("VER")').click(function () {
			var ruta = $(this).attr('href');
			$('#ajax3').load(ruta);
			$.ajax({ cache: false });
			ruta = "";
			return false;
		});

		$('a:contains("EDITAR")').click(function () {
			var ruta = $(this).attr('href');
			$('#ajax3').load(ruta);
			$.ajax({ cache: false });
			ruta = "";
			return false;
		});


	});
</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
/*
echo '<pre>';
var_dump($_REQUEST);  // o $_GET, $_REQUEST, etc.
echo '</pre>';*/

/* INGRESO PREVISION DE SALUD */
if (isset($_POST['ff_ing_psalu'])) {
	$datos = new Datos;

	$estado = array("f_ingreso" => date('Y-m-d'));
	$datos->INSERT_PoST('obras_soc', '', $estado, $_POST['cod_plan']);

	if (mysql_query($datos->query)) {
		echo OK;
	} else {
		echo ERROR;
	}
}

/* BUSQUEDA PREVISION DE SALUD */

if (isset($_POST['ff_bus'])) {


	$datos = new Datos;

	foreach ($_POST as $campo => $valor) {

		if ($valor != $_POST['ff_bus'] && $valor != "") {
			if (is_numeric($valor)) {
				$condicion[$campo] = " = " . $valor;
			} else {
				if ($valor != 'TODOS') {
					$condicion[$campo] = " LIKE '" . $valor . "%'";
				}
			}
		}
	}
	$get1 = array("id" => "");
	$get2 = array("id" => "");
	$get1_var = array("VER" => '1');
	$get2_var = array("ELIMINAR" => '1');
	$campos = array("id" => "Id", "mes" => "Mes", "anio" => "Año", "valor" => "Valor");
	$rut = array("NULL" => "");
	$datos->Listado_per($campos, "vista_uf", $condicion, "VER", "ELIMINAR", $get1, $get2, "INT/M_UF.php", $rut, $get1_var, $get2_var, "table");
	
}

/* PROCESA EDICION */

if ($_POST['ff_edisalud']) {

	$sql = "UPDATE obras_soc SET descripcion='" . $_POST['descripcion'] . "', tipo='" . $_POST['cod_tipo'] . "',reducido='" . $_POST['reducido'] . "' WHERE nro_doc='" . $_POST['nro_doc'] . "' AND tipo='" . $_POST['cod_tipo'] . "'";

	if ($query = mysql_query($sql)) {
		$_GET['VER'] = 1;
		$_GET['nro_doc'] = $_POST['nro_doc'];
		$_GET['cod_tipo'] = $_POST['cod_tipo'];

	} else {
		echo ERROR;
	}


}

/* LISTRAR DETALLE DE LA PREVISION DE SALUD */

if (isset($_GET['VER'])) {

	echo '<div class="caja"><strong>DETALLE UF</strong></div>';
	$datos = new Datos;
	$campos = array("id AS Id" => "", "mes AS Mes" => "", "anio As Año" => "", "valor AS Valor" => "");
	$rut = array('NULL' => "");
	$condicion = array("id ='" => $_GET['id'] . "'");
	echo "<div class='caja'>";
	$datos->Imprimir($campos, 'vista_uf', $condicion, 1, $rut);

	echo '<div style="padding:10px"><a href="INT/M_PSALU.php?EDITAR=1&cod_tipo=' . $_GET['cod_tipo'] . '&nro_doc=' . $_GET['nro_doc'] . '" class="boton" >EDITAR</a></div>';

	echo "</div>";

}

/* FORMULARIO EDITAR */
if ($_GET['EDITAR'] > 0) {

	$con_sql = "SELECT nro_doc, descripcion, reducido, cod_tipo, isapre FROM PSALUD WHERE nro_doc ='" . $_GET['nro_doc'] . "' AND cod_tipo='" . $_GET['cod_tipo'] . "'";
	$query = mysql_query($con_sql);
	$isapre = mysql_fetch_array($query);
	?>

	<h1>EDICI&Oacute;N PREVISI&Oacute;N DE SALUD</h1>

	<div class="caja_cabezera">PLANES</div>
	<form action="INT/M_PSALU.php" method="post" id="ff_EPSALUD" name="ff_EPSALUD">
		<input type="text" name="ff_edisalud" value="1" style="display:none;" />
		<div class="caja">
			<table>
				<tr>
					<td><strong>N&Uacute;MERO</strong></td>
					<td><input type="text" name="nro_doc" value="<?php echo $_GET['nro_doc']; ?>" /></td>
					<td><strong>NOMBRE</strong></td>
					<td><input type="text" name="descripcion" size="40" value="<?php echo $isapre['descripcion']; ?>" />
					</td>
				</tr>

				<tr>
					<td><strong>REDUCIDO</strong></td>
					<td><input type="text" name="reducido" size="20" value="<?php echo $isapre['reducido']; ?>" /></td>

					<td><strong>TIPO</strong></td>
					<td>
						<?php

						$select = "SELECT tipo, codigo FROM tipo_obrasocial";
						$select_query = mysql_query($select);
						echo '<select name="cod_tipo">';
						echo '<option value="' . $isapre['cod_tipo'] . '">' . $isapre['isapre'] . '</option>';

						while ($op = mysql_fetch_array($select_query)) {
							echo '<option value="' . $op['codigo'] . '">' . $op['tipo'] . '</option>';
						}

						echo '</select>';

						?>
					</td>

					<td>
						<div align="right"><input type="submit" value="EDITAR" class="boton" /></div>
					</td>
				</tr>
			</table>

		</div>

	</form>

	<?php
}

/* ELIMINAR PREVISION DE SALUD */
if (isset($_GET['ELIMINAR'])) {

	$query = "DELETE FROM obras_soc WHERE nro_doc='" . $_GET['nro_doc'] . "' AND tipo = '" . $_GET['cod_tipo'] . "'";
	if (mysql_query($query)) {
		echo OK;
	} else {
		echo ERROR;
	}

}




?>