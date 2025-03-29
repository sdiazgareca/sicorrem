<?php

/*
 * VISTA RENDICIONES DE COBRADORES
 * BOLETAS ENTREGADAS COMISIONES ETC
 */


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once ('../CLA/Cta.php');
include_once('../CLA/Datos.php');

    $periodo = explode('-',$_POST['periodo']);

    $mes  = $periodo[1];
    $anio = $periodo[2];
    $dia = $periodo[0];

    echo $dia.'-'.$mes.'-'.$anio;

    $boletas = new Cta();

    echo '<table>';
    echo '<tr>';

    echo '<td>';
    echo '<h1>DETALLE DE BOLETAS</h1>';
    $boletas->BuscaBoletasCobrador($anio, $mes, $_POST['cobrador'],$dia);
    echo '</td>';
/*
    echo '<td>';
    echo '<h1>Pendientes</h1>';
    $boletas->BuscaBoletasCobradorPen($anio, $mes, $_POST['cobrador']);
    echo '</td>';

    echo '<td>';
    echo '<h1>Mora</h1>';
    $boletas->BuscaBoletasCobradorMor($anio, $mes, $_POST['cobrador']);
    echo '</td>';
*/
    echo '</tr>';
    echo '</table>';


