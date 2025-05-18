<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

/*
 * Facturación Boletas Particulares
 * Mod: 15/03/2011 10:41
 * Mod: 25/04/2011 18:02
 *
 */

include('../DAT/conf.php');
include('../DAT/bd.php');
include('../CLA/funciones_fact.php');
include_once('../CLA/Datos.php');

//$q ="DELETE FROM emi_par_b_imp WHERE e_deuda > -1";
//mysql_query($q);

$i = $_POST['boletas']; //numero de boleta inicial
$periodo = $_POST['periodo']; //periodo a facturar
$ajuste = $_POST['Ajuste']; // porcentaje de ajuste

$f_periodo = explode('-', $_POST['periodo']);
$dia_f_periodo = $f_periodo[0];
$mes_f_periodo = $f_periodo[1];
$anio_f_periodo = $f_periodo[2];

$f_periodo2 = $anio_f_periodo . '-' . $mes_f_periodo . '-' . $dia_f_periodo;

$dia_limite = 20;
$mes_limite = $mes_f_periodo;
$anio_limite = $anio_f_periodo;

/* CALCULO DE SECUENCIAS */

$sql = "SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
FROM afiliados
WHERE (afiliados.cod_baja='00'  ||  afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ'  ||  afiliados.cod_baja='04')
GROUP BY num_solici";

$query = mysql_query($sql);

while ($secuencia = mysql_fetch_array($query)) {


    $con = 'UPDATE contratos SET secuencia="' . $secuencia['secuencia'] . '"
        WHERE num_solici="' . $secuencia['num_solici'] . '"';

    $q = mysql_query($con);

}
$limite = $anio_limite . '-' . ($mes_limite - 1) . '-' . $dia_limite;

$fac_sql = "

SELECT
empresa.empresa,
contratos.ajuste,
titulares.nombre1 AS nom,
titulares.apellido AS ape,
contratos.ZO,
contratos.SE,
contratos.MA,
contratos.titular,
e_contrato.descripcion,
contratos.num_solici,
CASE
WHEN p.id_tipo_moneda = 2 THEN ROUND(valor_plan.valor * uf.valor,0)
ELSE ROUND(valor_plan.valor,0)
END AS importe,
contratos.f_pago,
contratos.titular,
DATE_FORMAT(contratos.f_baja,'%d-%m-%Y')  AS f_baja,
DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y')  AS f_ingreso,
contratos.f_ingreso AS f_ingreso2,
contratos.secuencia,
contratos.estado,
domicilios.numero,
domicilios.calle,
domicilios.poblacion,
domicilios.casa,
domicilios.departamento,
domicilios.telefono,
domicilios.pasaje,
domicilios.departamento,
f_pago.codigo AS f_pago,
f_pago.descripcion AS f_pago_des,
cobrador.apellidos AS ap_cob,
cobrador.nombre1 AS nom_cob,
contratos.secuencia,
contratos.tipo_plan,
contratos.cod_plan,
p.id_tipo_moneda

FROM contratos

LEFT JOIN valor_plan ON valor_plan.secuencia = contratos.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
LEFT JOIN domicilios ON domicilios.nro_doc = contratos.titular AND domicilios.num_solici = contratos.num_solici
LEFT JOIN f_pago ON contratos.f_pago = f_pago.codigo
LEFT JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
LEFT JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador
LEFT JOIN titulares ON titulares.nro_doc = contratos.titular
INNER JOIN empresa ON empresa.nro_doc = contratos.empresa

WHERE
empresa.f_factu = 1 AND
(contratos.estado ='500' || contratos.estado ='400' || contratos.estado =  '3500')
AND f_pago = '400' AND contratos.tipo_plan != 5 AND (contratos.tipo_plan != 2 AND contratos.cod_plan != 'W71')
ORDER BY empresa.nro_doc";




$fac_query = mysql_query($fac_sql);

echo '<div style="overflow: auto; width: 940px; height: 450px;">';
echo '<table class="table">';

echo '<tr>
    <th>BOL</th>
    <th>CONTRATO</th>
    <th>TITULAR</th>
    <th>Nombre</th>
    <th>f_ingreso</th>
    <th>Ajuste</th>
    <th>SO</th>
    <th>SE</th>
    <th>MA</th>
    <th>Descripcion</th>
    <th>Calle</th>
    <th>numero</th>
    <th>poblacion</th>
    <th>casa</th>
    <th>departamento</th>
    <th>telefono</th>
    <th>pasaje</th>
    <th>f_pago</th>
    <th>ape_cob</th>
    <th>nom_cop</th>
    <th>num_de</th>
    <th>accion</th>
    <th>importe</th>
    <th>Ajuste</th>
    <th>Total</th>
    <th>sec</th>
    </tr>';


while ($fac = mysql_fetch_array($fac_query)) {

    $importe = ($fac['id_tipo_moneda'] == 1) ? $fac['importe'] + $fac['ajuste'] : $fac['importe'];


    //COMPROBAR REAJUSTE
    if ($_POST['Ajuste'] > 0) {

        $f_comp = explode("-", $periodo);
        $anio_comp = $f_comp[2] - 1;

        $f_comparacion = mktime(0, 0, 0, 4, 30, 2011);

        $f_ing = explode("-", $fac["f_ingreso2"]);
        $f_ingreso = mktime(0, 0, 0, $f_ing[1], $f_ing[2], $f_ing[0]);
        

        if ($f_ingreso <= $f_comparacion && $fac['tipo_plan'] != 3) {

            if ($fac['id_tipo_moneda'] == 1) {
                $re_ajuste = $importe * $_POST['Ajuste'] / 100;
            } else {
                $re_ajuste = 0;
                $fac['importe'] = 0;
            }

            $total = round($importe + $re_ajuste, -2);
            $ajuste = ($total - $fac['importe']);

        } else {
            $total = round($importe, -2);
            if ($fac['id_tipo_moneda'] == 2) {
                $fac['ajuste'] = 0;
            }
            $ajuste = $fac['ajuste'];
        }
    } else {

        $total = round($importe, -2);
        if ($fac['id_tipo_moneda'] == 2) {
            $fac['ajuste'] = 0;
        }
        $ajuste = $fac['ajuste'];
    }


    //DESCUENTO POR PLANILLA
    if ($fac['f_pago'] == '400') {

        $num_deudas = deuda($fac['num_solici'], $fac['titular']);

        if ($num_deudas >= 3) {

            echo '<tr><td>' . $i . '</td><td>' . $fac['num_solici'] . '</td><td>' . $fac['titular'] . '</td><td>' . $fac['nom'] . ' ' . $fac['ape'] . '</td><td>' . $fac['f_ingreso'] . '</td><td>' . $ajuste . '</td><td>' . $fac['ZO'] . '</td><td>' . $fac['SE'] . '</td><td>' . $fac['MA'] . '</td><td>' . strtoupper($fac['descripcion']) . '</td><td>' . $fac['calle'] . '</td><td>' . $fac['numero'] . '</td><td>' . $fac['poblacion'] . '</td><td>' . $fac['casa'] . '</td><td>' . $fac['departamento'] . '</td><td>' . $fac['telefono'] . '</td><td>' . $fac['pasaje'] . '</td><td>' . $fac['f_pago_des'] . '</td><td>' . $fac['ap_cob'] . '</td><td>' . $fac['nom_cob'] . '</td><td>' . $num_deudas . '</td><td><strong>DICOM 1</strong></td><td>' . $fac['importe'] . '</td><td>' . $re_ajuste . '</td><td>' . $total . '</td><td>' . $fac['secuencia'] . '</td></tr>';
            //PASAR A CLIENTE MOROSO
            $query1 = cambiarDicomContratos($fac['num_solici'], $f_periodo2);
            $query2 = cambiarDicomAfiliados($fac['num_solici'], $f_periodo2);
            $query3 = cambiarHonorarioMoroso($fac['num_solici'], $f_periodo2);

            mysql_query($query1);
            mysql_query($query2);
            mysql_query($query3);

        } else {

            $t = pago_cta($fac['titular'], 'B', $i, 0, $f_periodo2, $f_periodo2, $total, $fac['cobrador_cod'], $fac['num_solici'], $f_periodo2, $total, 0, 0, $ajuste, $i, $fac['ape'] . ' ' . $fac['nom'], $fac['calle'] . ' ' . $fac['poblacion'] . ' ' . $fac['numero'], $fac['ZO'], $fac['SE'], $fac['MA'], $mes_f_periodo, $mes_f_periodo, $fac['telefono'], $fac['secuencia'], $fac['tipo_plan'], $fac['cod_plan'], mes($mes_f_periodo), $anio_f_periodo);
            echo '<tr><td>' . $i . '</td><td>' . $fac['num_solici'] . '</td><td>' . $fac['titular'] . '</td><td>' . $fac['nom'] . ' ' . $fac['ape'] . '</td><td>' . $fac['f_ingreso'] . '</td><td>' . $ajuste . '</td><td>' . $fac['ZO'] . '</td><td>' . $fac['SE'] . '</td><td>' . $fac['MA'] . '</td><td>' . strtoupper($fac['descripcion']) . '</td><td>' . $fac['calle'] . '</td><td>' . $fac['numero'] . '</td><td>' . $fac['poblacion'] . '</td><td>' . $fac['casa'] . '</td><td>' . $fac['departamento'] . '</td><td>' . $fac['telefono'] . '</td><td>' . $fac['pasaje'] . '</td><td>' . $fac['f_pago_des'] . '</td><td>' . $fac['ap_cob'] . '</td><td>' . $fac['nom_cob'] . '</td><td>' . $num_deudas . '</td><td><strong>FACTURAR 2</strong></td><td>' . $fac['importe'] . '</td><td>' . $re_ajuste . '</td><td>' . $total . '</td><td>' . $fac['secuencia'] . '</td></tr>';
            if ($t > 0) {
                $i++;
            }

        }

    }



    //}
}

echo '</table>';
echo '<div>';

?>