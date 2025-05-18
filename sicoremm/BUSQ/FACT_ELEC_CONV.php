<script type="text/javascript">
    $(document).ready(function () {

        $('#conv').submit(function () {

            if (!confirm("Esta seguro de iniciar el proceso?")) {
                return false;
            }

            var url_ajax = $(this).attr('action');
            var data_ajax = $(this).serialize();

            $.ajax({
                type: 'POST', url: url_ajax, cache: false, data: data_ajax, success: function (data) {
                    $('#factu_1').html(data);
                }
            })

            url_ajax = "";
            data_ajax = "";

            return false;
        });


    });
</script>



<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');

echo '<h1>' . $_POST['empresa'] . '</h1>';

$mensaje_error = '<div class="mensaje2">Error fecha incorrecta.</div>';

//COMPRUBE QUE EL PERIODO NO SEA VACIO
if ($_POST['periodo'] != "") {

    $fecha = explode('-', $_POST['periodo']);
    $valfecha = checkdate($fecha[1], $fecha[0], $fecha[2]);
} else {
    echo $mensaje_error;
    exit;
}

//COMPRUEBA LA FECHA
if ($valfecha == false) {
    echo $mensaje_error;
    exit;
}


$periodo = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

$nempresa = "SELECT comprovante,cod_mov,
contratos.ajuste,
DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso,
DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,debe,
       e_contrato.descripcion AS des_estado,
       valor_plan.valor,
       contratos.num_solici,
       contratos.f_ingreso,
       contratos.secuencia,
       titulares.nro_doc, 
       CONCAT(titulares.apellido,' ',titulares.nombre1) AS nombres
                FROM titulares
                LEFT JOIN contratos ON contratos.titular = titulares.nro_doc
                LEFT JOIN cta ON cta.num_solici=contratos.num_solici AND cta.nro_doc = contratos.titular AND cta.cod_mov=1 AND cta.fecha_mov='" . $periodo . "'
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                WHERE contratos.empresa='" . $_POST['empresa'] . "' 
                    ORDER BY apellido";


$query = mysql_query($nempresa);

echo '<form action="BUSQ/PROCESA_FACT.php" method="post" id="conv">';

echo '<table class="table2">';


echo '<tr>
            <th>CONTRATO</th>
            <th>RUT</th>
            <th>TITULAR</th>
            <th>F INGRESO</th>
            <th>F BAJA</th>
            <th>ESTADO</th>
            <th>AJUSTE</th>
            <th>FAC</th>
            <th>TOTAL</th>
            <th></th>
            </tr>';


while ($emp = mysql_fetch_array($query)) {

    echo '<tr>
            <td>' . $emp['num_solici'] . '</td>
            <td>' . $emp['nro_doc'] . '</td>
            <td>' . $emp['nombres'] . '</td>
            <td>' . $emp['f_ingreso'] . '</td>
            <td>' . $emp['f_baja'] . '</td>
            <td>' . $emp['des_estado'] . '</td>
            <td>' . $emp['ajuste'] . '</td>';
    echo '<td>' . $emp['comprovante'] . '</td>';
    if ($emp['cod_mov'] > 0) {

        echo '<td>' . number_format($emp['valor'], 0, ',', '.') . '</td>';
        echo '<td><strong>' . number_format(($emp['debe']), 0, ',', '.') . '</strong></td>';
        echo '<td><strong>FACTURA INGRESADA</strong></td>';
        $total = $total + $emp['debe'];
    } else {
        echo '<td>' . number_format($emp['valor'], 0, ',', '.') . '</td>';
        echo '<td>' . number_format(($emp['ajuste'] + $emp['valor']), 0, ',', '.') . '</td>';
        echo '<td><input type="checkbox" name="' . $emp['num_solici'] . '" value="' . $emp['num_solici'] . '/' . $emp['nro_doc'] . '/' . $periodo . '/' . ($emp['valor'] + $emp['ajuste']) . '/' . $_POST['nfactu'] . '"></td>';

    }
    echo '</tr>';


}
echo '</table>';
echo '<h1>TOTAL ' . number_format($total, 0, ',', '.') . '</h1>';
echo '<input type="submit" value="Facturar" class="boton" />';
echo '</form>';

?>