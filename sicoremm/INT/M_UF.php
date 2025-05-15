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

/* INGRESO REGISTRO UF */
if (isset($_POST['ff_ing_uf'])) {

    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $valor = $_POST['valor'];

    if ($mes > 0 && $anio > 0 && is_numeric($valor)) {
        $sql = "INSERT INTO uf (mes, anio, valor) VALUES ('$mes', '$anio', '$valor')";
        if (mysql_query($sql)) {
            echo "OK";
        } else {
            echo "ERROR al insertar: " . mysql_error();
        }
    } else {
        echo "ERROR: Datos inválidos";
    }
}


/* BUSQUEDA PREVISION DE SALUD */

if (isset($_POST['ff_bus'])) {

	$datos = new Datos;

	foreach ($_POST as $campo => $valor) {

		if (($valor != $_POST['ff_bus'] && $valor != "") && !($campo === 'id_mes' && $valor == 0)) {
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

if (isset($_POST['ff_edi_uf'])) {

    $id = $_POST['id'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $valor = $_POST['valor'];

    $sql = "UPDATE uf SET mes = '$mes', anio = '$anio', valor = '$valor' WHERE id = '$id'";

    if (mysql_query($sql)) {
        // Para que se muestre el detalle actualizado
        $_GET['VER'] = 1;
        $_GET['id'] = $id;
    } else {
        echo "ERROR";
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

	echo '<div style="padding:10px"><a href="INT/M_UF.php?EDITAR=1&id=' . $_GET['id'] . '" class="boton" >EDITAR</a></div>';

	echo "</div>";

}

/* FORMULARIO EDITAR */
if ($_GET['EDITAR'] > 0) {

	$id = $_GET['id'];
	$sql = "SELECT id, mes, anio, valor FROM uf WHERE id = '$id'";
	$query = mysql_query($sql);
	$uf = mysql_fetch_array($query);

	if (!$uf) {
		echo "<div class='mensaje2'>No se encontró el registro UF para editar.</div>";
		return;
	}
	?>

	<h1>EDICI&Oacute;N UF</h1>

	<div class="caja_cabezera">MODIFICAR VALOR UF</div>
	<form action="INT/M_UF.php" method="post" id="ff_EPSALUD" name="ff_EPSALUD">
		<input type="hidden" name="ff_edi_uf" value="1" />
		<input type="hidden" name="id" value="<?php echo $uf['id']; ?>" />
		<div class="caja">
			<table>
				<tr>
					<td><strong>MES</strong></td>
					<td>
						<?php
						$select = new Select;
						$select->selectMesActual('mes', 'mes', $uf['mes']);
						?>
					</td>

					<td><strong>A&Ntilde;O</strong></td>
					<td>
						<?php
						$select = new Select;
						$select->selectAnios('anio', 'anio', $uf['anio']);
						?>
					</td>

					<td><strong>VALOR</strong></td>
					<td><input type="text" name="valor" value="<?php echo $uf['valor']; ?>" /></td>

					<td>
						<div align="right">
							<input type="submit" value="EDITAR" class="boton" />
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>

	<?php
}


/* ELIMINAR REGISTRO UF */
if (isset($_GET['ELIMINAR'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM uf WHERE id = '$id'";
    
    if (mysql_query($query)) {
        echo "OK";
    } else {
        echo "ERROR";
    }
}





?>