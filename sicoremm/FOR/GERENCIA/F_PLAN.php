<script type="text/javascript">
	$(document).ready(function () {

		$('#ajax3 #ingVenCon').submit(function () {

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
	});


</script>

<?php
include_once ('../../DAT/conf.php');
include_once ('../../DAT/bd.php');
include_once ('../../CLA/Select.php');
?>

<div id="ajax1">
	<h1>INGRESO DE PLANES</h1>

	<form action="INT/M_PLAN.php" method="post" id="ingVenCon" name="ingVenCon">
		<div class="caja_cabezera">

			Descrici&oacute;n del Plan

		</div>

		<div class="caja">
			<table>
				<tr>
					<td>
						<input type="text" name="ff_indreso" value="1" style="display:none" />
						<label for="ContactName">C&oacute;digo</label> <input type="text" name="cod_plan" size="3"
							maxlength="3" />
					</td>
					<td>
						<label for="ContactName">Categor&iacute;a</label>

						<?php
						$vendedor = new Select;
						$vendedor->selectSimple('tipo_plan', 'tipo_plan, tipo_plan_desc', 'tipo_plan_desc', 'tipo_plan', 'tipo_plan', 'tipo_plan', 'NULL');
						?>

					</td>
					<td><label for="ContactName">Nombre</label><input type="text" name="desc_plan" /></td>
					<td><label for="ContactName">Valor Copago</label></td>
					<td><input type="text" name="copago" /></td>
				</tr>

				<tr>

					<td><label for="ContactName">Casa Protegida</label>&nbsp;&nbsp;SI<input name="casa_p" type="radio"
							value="SI" />NO<input name="casa_p" type="radio" value="NO" /></td>
					<td>N&uacute;mero de Atenciones Sin Copago</td>
					<td><input value="0" type="text" size="2" maxlength="2" name="cm_gratis" />&nbsp;<select
							name="tiempo">
							<option value="ANUAL">Anual</option>
							<option value="MENSUAL">Mensual</option>
						</select></td>
					<td><label>Valor Incor</label></td>
					<td><input name="v_incor" type="text" id="v_incor" /></td>
				</tr>

				<tr>
					<td>Incorporaciones Sin costo</td>
					<td><input type="text" value="" name="n_inco_grat" /></td>
					<td>Moneda
						<select name="id_tipo_moneda">
							<option value="1">Peso</option>
							<option value="2">UF</option>
						</select>
					</td>
					<td>&zwj;</td>
					<td>&zwj;</td>

				</tr>

			</table>

		</div>

		<div class="caja_boton"><input type="submit" value="Guardar" class="boton"></div>
	</form>
</div>