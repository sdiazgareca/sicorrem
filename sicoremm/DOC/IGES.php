<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/IGES_FAC.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Fecha_1.php');


$feh = new Fecha_1('01-'.$_POST['periodo22']);
echo '<h3>INFORME DE GESTION PERIODO '.strtoupper($feh->mes_palabras).' '.$feh->anio.'</h3>';



// FEHCAS
$fecha = new Datos();
$pero = explode('-',$_POST['periodo22']);
$periodo = $pero[1].'-'.$pero[0].'-01';
$ani_periodo=$pero[1];
$mes_periodo=$pero[0];
$desde = $fecha->cambiaf_a_mysql($_POST['del']);
$hasta = $fecha->cambiaf_a_mysql($_POST['al']);


//RECAUDADORES
$sql = "SELECT nro_doc, codigo, nombre1, apellidos FROM cobrador WHERE codigo != 10 AND codigo != 56";
$query=mysql_query($sql);

while($cob = mysql_fetch_array($query)){

    $informe = new Periodos3();
    echo '<h3>'.strtoupper($cob['nombre1'].' '.$cob['apellidos']).'</h3>';

    $cobrador = $cob['codigo'];

    $ent_actual1 = $informe->cob_entrega_pen($periodo, $desde, $hasta, $cobrador, $dev,'=','=');
    $ent_actual2 = $informe->cob_entrega_cob($periodo, $desde, $hasta, $cobrador, $dev,'=','=');
    $ACTUAL= ($ent_actual1 + $ent_actual2);

    //ANTICIPADO
    $anticipado = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'>','=');
    $anti_moros = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'>','!=');

    //ZONA
    $reco_actual = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'=','=');
    $reco_anteri = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'<','=');

    //MOROSO
    $moro_actual = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'=','!=');
    $moro_anteri = $informe->cob_recuperado($periodo, $desde, $hasta, $cobrador, $dev,'<','!=');

    //ANTERIOR
    $entregaAnt = $informe->cob_pendiente($periodo,$desde,$hasta,$cobrador);


    $suma_entrega = $entregaAnt + $reco_anteri + $ACTUAL +  $anticipado;
    $suma_cobrado = $reco_anteri + $reco_actual +  $anticipado;
    $suma_moroso  = $moro_actual + $moro_anteri + $anti_moros;


    //$saldo_anterior = number_format(($entregaAnt + $reco_anteri) - $reco_anteri,0,',','.');
    $saldo_actual = number_format($ACTUAL - $reco_actual,0,',','.');
    $saldo_anticipado = number_format($anticipado -$anticipado);
    $suma_saldo = number_format((($entregaAnt + $reco_anteri) - $reco_anteri) + ($ACTUAL - $reco_actual) + ($anticipado -$anticipado),0,',','.');

   @$porcentaje = round($suma_cobrado  * 100 / $suma_entrega );


   $total_cobrado_anterior =  $moro_anteri + $reco_anteri;
   $saldo_anterior = number_format(($entregaAnt + $reco_anteri + $moro_anteri) - ($reco_anteri+$moro_anteri),0,',','.');
/*
    echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>TOTAL COBRADO MOROSO</th><th>TOTAL COBRADO</th><th>SALDO</th><th>".$porcentaje." %</th></tr>";
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.number_format($entregaAnt + $reco_anteri,0,',','.').'</td><td>'.number_format($reco_anteri,0,',','.').'</td><td>'.number_format($moro_anteri,0,',','.').'</td><td>'.number_format($total_cobrado_anterior,0,',','.').'</td><td>'.$saldo_anterior.'</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($ACTUAL,0,',','.').'</td><td>'.number_format($reco_actual,0,',','.').'</td><td>'.number_format($moro_actual,0,',','.').'</td><td>'.number_format($moro_actual + $reco_anteri +$reco_actual,0,',','.').'</td><td>'.$saldo_actual.'</td></tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anti_moros,0,',','.').'</td><td>'.number_format($anti_moros + $anticipado +$anti_moros,0,',','.').'</td><td>'.$saldo_anticipado.'</td></tr>';
    echo '<tr><th></th><td><strong>'.number_format($suma_entrega,0,',','.').'</strong></td><td><strong>'.number_format($suma_cobrado,0,',','.').'</strong></td><td><strong>'.number_format($suma_moroso,0,',','.').'</strong></td><td><strong>'.$anti_moros + $anticipado +$anti_moros + $moro_actual + $reco_anteri +$reco_actual + $moro_anteri + $reco_anteri.'</strong></td><td><strong>'.$suma_saldo.'</strong></td></tr>';
    echo $periodos->table_cierre;
    echo "</table>";
*/


   $entre_ant = number_format($entregaAnt + $reco_anteri,0,',','.');
   $entre_act = number_format($ACTUAL,0,',','.');
   $entre_ade = number_format($anticipado,0,',','.');
   $entre_sum = number_format($suma_entrega,0,',','.');

   $cobra_ant = number_format($reco_anteri,0,',','.');
   $cobra_act = number_format($reco_actual,0,',','.');
   $cobra_ade = number_format($anticipado,0,',','.');
   $cobra_sum = number_format($suma_cobrado,0,',','.');

   $moros_ant = number_format($moro_anteri,0,',','.');
   $moros_act = number_format($moro_actual,0,',','.');
   $moros_ade = number_format($anti_moros,0,',','.');
   $moros_sum = number_format($suma_moroso,0,',','.');

   $tcobd_ant = number_format($reco_anteri + $moro_anteri,0,',','.');
   $tcobd_act = number_format($reco_actual + $moro_actual,0,',','.');
   $tcobd_ade = number_format($anticipado + $anti_moros,0,',','.');
   $tcobd_sum = number_format($suma_cobrado + $suma_moroso,0,',','.');

   $saldo_ant = number_format( ($entregaAnt + $reco_anteri) -  ($reco_anteri),0,',','.');
   $saldo_act = number_format( ($ACTUAL) - ($reco_actual),0,',','.');
   $saldo_ade = number_format(($anticipado - $anticipado),0,',','.');
   $saldo_sum = number_format(($suma_entrega) - ($suma_cobrado),0,',','.');


   $por_ant = round( $reco_anteri / ($entregaAnt + $reco_anteri)*100 );
   $por_act = round( $reco_actual / $ACTUAL *100 );


        echo "<table>";
    echo "<tr><th></th>                            <th>ENTREGA      </th>      <th>COBRADO             </th> <th>                 </th>        <th>COBRADO MOROSO</th>               <th>TOTAL COBRADO</th>         <th>SALDO            </th>     <th></th>     </tr>";
    echo '<tr><td><strong>ANTERIOR</strong> </td>  <td>'.$entre_ant.'</td>     <td>'.$cobra_ant.'      </td> <td>'.$por_ant.' %</td>        <td>'.$moros_ant.'      </td>         <td>'.$tcobd_ant.'</td>        <td>'.$saldo_ant.'   </td>     <td>'.(100-$por_ant).' %   </td>     </tr>';
    echo '<tr><td><strong>ACTUAL</strong></td>     <td>'.$entre_act.'</td>     <td>'.$cobra_act.'      </td> <td>'.$por_act.' %</td>        <td>'.$moros_act.'      </td>         <td>'.$tcobd_act.'</td>        <td>'.$saldo_act.'   </td>     <td>'.(100-$por_act).' %   </td>     </tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td> <td>'.$entre_ade.'</td>     <td>'.$cobra_ade.'      </td> <td>              </td>        <td>'.$moros_ade.'      </td>         <td>'.$tcobd_ade.'</td>        <td>'.$saldo_ade.'   </td>     <td>                       </td>     </tr>';
    echo '<tr><th></th>                            <td>'.$entre_sum.'</td>     <td>'.$cobra_sum.'      </td> <td>'.$porcentaje.' %</td>        <td>'.$moros_sum.'   </td>         <td>'.$tcobd_sum.'</td>        <td>'.$saldo_sum.'   </td>     <td>'.(100-$porcentaje).' %</td>  </tr></tr>';
    echo $periodos->table_cierre;
    echo "</table>";




    $total_entregado_zona = $total_entregado_zona + $suma_entrega;
    $total_cobrado_zona = $total_cobrado_zona + $suma_cobrado;
    $total_moroso_zona = $total_moroso_zona + $suma_moroso;

    unset($informe);
}


//OFICINA

$sql2 ="SELECT codigo, descripcion FROM f_pago WHERE codigo != 600 AND codigo !=400";
$query2 = mysql_query($sql2);

while($oficina = mysql_fetch_array($query2)){

    $suma_entrega_ofi = 0;
    $suma_cobrado = 0;
    $suma_moroso = 0;
    $saldo_anterior = 0;
    $saldo_actual = 0;
    $suma_saldo = 0;
    $moro_anteri =0;
    $moro_actual =0;
    $anti_moros =0;

    $informe = new Periodos3();

    $ent_actual1 = $informe->ofi_entrega_pen($periodo, $desde, $hasta,10, $dev,'=','=',$oficina['codigo']);
    $ent_actual2 = $informe->ofi_entrega_cob($periodo, $desde, $hasta,10, $dev,'=','=',$oficina['codigo']);
    $ACTUAL= ($ent_actual1 + $ent_actual2);

    //ZONA
    $reco_actual = $informe->ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'=','=',$oficina['codigo']);
    $reco_anteri = $informe->ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'<','=',$oficina['codigo']);

    //ANTICIPADO
    $anticipado = $informe->ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','=',$oficina['codigo']);
    $anti_moros = $informe->ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','!=',$oficina['codigo']);

    //ANTERIOR
    $entregaAnt = $informe->ofi_pendiente($periodo,$desde,$hasta,10,$oficina['codigo']);

    $suma_entrega_ofi = $entregaAnt + $reco_anteri + $ACTUAL +$anticipado;
    $suma_cobrado = $reco_anteri + $reco_actual + $anticipado;
    $suma_moroso = $moro_anteri + $moro_actual + $anti_moros;

    $saldo_anterior = ($entregaAnt + $reco_anteri) - $reco_anteri;
    $saldo_actual = $ACTUAL - $reco_actual;
    $suma_saldo = $saldo_anterior + $saldo_actual;

    if($oficina['descripcion'] == 'COBRO DOMICILIARIO'){
        $oficina['descripcion']= 'OFICINA';
        $total_entregado_ofi = $total_entregado_ofi + $suma_entrega_ofi;
        $total_cobrado_ofi = $total_cobrado_ofi + $suma_cobrado;
        $total_moroso_ofi = $total_moroso_ofi + $suma_moroso;
    }
    else{
        $total_entregado_vi = $total_entregado_vi + $suma_entrega_ofi;
        $total_cobrado_vi = $total_cobrado_vi + $suma_cobrado;
        $total_moroso_vi = $total_moroso_vi + $suma_moroso;
    }


    echo '<h3>'.strtoupper($oficina['descripcion']).'</h3>';
    @$porcentaje = round($suma_cobrado * 100 / $suma_entrega_ofi);
/*
    echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>TOTAL COBRADO MOROSO</th><th>SALDO</th><th>".$porcentaje." %</th></tr>";
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.number_format($entregaAnt + $reco_anteri,0,',','.').'</td><td>'.number_format($reco_anteri,0,',','.').'</td><td>'.number_format($moro_anteri,0,',','.').'</td><td>'.number_format($saldo_anterior,0,',','.').'</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($ACTUAL,0,',','.').'</td><td>'.number_format($reco_actual,0,',','.').'</td><td>'.number_format($moro_actual,0,',','.').'</td><td>'.number_format($saldo_actual,0,',','.').'</td></tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anti_moros,0,',','.').'</td><td>'.$saldo_anticipado.'</td></tr>';
    echo '<tr><th></th><td><strong>'.number_format($suma_entrega_ofi,0,',','.').'</strong></td><td><strong>'.number_format($suma_cobrado,0,',','.').'</strong></td><td><strong>'.number_format($suma_moroso,0,',','.').'</strong></td><td><strong>'.number_format($suma_saldo,0,',','.').'</strong></td></tr>';
    echo $periodos->table_cierre;
    echo "</table>";
*/

   $entre_ant = number_format($entregaAnt + $reco_anteri,0,',','.');
   $entre_act = number_format($ACTUAL,0,',','.');
   $entre_ade = number_format($anticipado,0,',','.');
   $entre_sum = number_format($suma_entrega_ofi,0,',','.');

   $cobra_ant = number_format($reco_anteri,0,',','.');
   $cobra_act = number_format($reco_actual,0,',','.');
   $cobra_ade = number_format($anticipado,0,',','.');
   $cobra_sum = number_format($suma_cobrado,0,',','.');

   $moros_ant = number_format($moro_anteri,0,',','.');
   $moros_act = number_format($moro_actual,0,',','.');
   $moros_ade = number_format($anti_moros,0,',','.');
   $moros_sum = number_format($suma_moroso,0,',','.');

   $tcobd_ant = number_format($reco_anteri + $moro_anteri,0,',','.');
   $tcobd_act = number_format($reco_actual + $moro_actual,0,',','.');
   $tcobd_ade = number_format($anticipado + $anti_moros,0,',','.');
   $tcobd_sum = number_format($suma_cobrado + $suma_moroso,0,',','.');

   $saldo_ant = number_format( ($entregaAnt + $reco_anteri) -  ($reco_anteri),0,',','.');
   $saldo_act = number_format( ($ACTUAL) - ($reco_actual),0,',','.');
   $saldo_ade = number_format(($anticipado - $anticipado),0,',','.');
   $saldo_sum = number_format(($suma_entrega_ofi) - ($suma_cobrado),0,',','.');

   $por_ant = round( $reco_anteri / ($entregaAnt + $reco_anteri)*100 );
   $por_act = round( $reco_actual / $ACTUAL *100 );


        echo "<table>";
    echo "<tr><th></th>                            <th>ENTREGA      </th>      <th>COBRADO             </th><th>                 </th>         <th>COBRADO MOROSO</th>               <th>TOTAL COBRADO</th>         <th>SALDO            </th>     <th>                         </td>     </tr>";
    echo '<tr><td><strong>ANTERIOR</strong> </td>  <td>'.$entre_ant.'</td>     <td>'.$cobra_ant.'      </td><td>'.$por_ant.' %   </td>         <td>'.$moros_ant.'      </td>         <td>'.$tcobd_ant.'</td>        <td>'.$saldo_ant.'   </td>     <td>'.(100-$por_ant).' %     </td>     </tr>';
    echo '<tr><td><strong>ACTUAL</strong></td>     <td>'.$entre_act.'</td>     <td>'.$cobra_act.'      </td><td>'.$por_act.' %   </td>         <td>'.$moros_act.'      </td>         <td>'.$tcobd_act.'</td>        <td>'.$saldo_act.'   </td>     <td>'.(100-$por_act).' %     </td>     </tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td> <td>'.$entre_ade.'</td>     <td>'.$cobra_ade.'      </td><td>                 </td>         <td>'.$moros_ade.'      </td>         <td>'.$tcobd_ade.'</td>        <td>'.$saldo_ade.'   </td>     <td>                         </td>     </tr>';
    echo '<tr><th></th>                            <td>'.$entre_sum.'</td>     <td>'.$cobra_sum.'      </td><td>'.$porcentaje.' %</td>         <td>'.$moros_sum.'      </td>         <td>'.$tcobd_sum.'</td>        <td>'.$saldo_sum.'   </td>     <td>'.(100-$porcentaje).' %  </td>     </tr></tr>';
    echo $periodos->table_cierre;
    echo "</table>";


    unset($informe);

}





//CONVENIOS



$suma_entrega_ofi = 0;
    $suma_cobrado = 0;
    $suma_moroso = 0;
    $saldo_anterior = 0;
    $saldo_actual = 0;
    $suma_saldo = 0;
    $moro_anteri =0;
    $moro_actual =0;
    $anti_moros =0;
    $moros_sum =0;

    $informe = new Periodos3();

    $ent_actual1 = $informe->convenios_entrega_pen($periodo, $desde, $hasta,10, $dev,'=','=','400');
    $ent_actual2 = $informe->convenio_entrega_cob($periodo, $desde, $hasta,10, $dev,'=','=','400');
    $ACTUAL= ($ent_actual1 + $ent_actual2);

    //ZONA
    $reco_actual = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'=','=','400');
    $reco_anteri = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta, 10, $dev,'<','=','400');

    //ANTICIPADO
    $anticipado = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','=','400');
    //$anti_moros = $informe->convenio_ofi_recuperado($periodo, $desde, $hasta,10, $dev,'>','!=','400');




    //ANTERIOR
    $entregaAnt = $informe->convenios_ofi_pendiente($periodo,$desde,$hasta,10,'400');

    $suma_entrega_ofi = $entregaAnt + $reco_anteri + $ACTUAL +$anticipado;
    $suma_cobrado = $reco_anteri + $reco_actual + $anticipado;
    //$suma_moroso = $moro_anteri + $moro_actual + $anti_moros;

    $saldo_anterior = ($entregaAnt + $reco_anteri) - $reco_anteri;
    $saldo_actual = $ACTUAL - $reco_actual;
    $suma_saldo = $saldo_anterior + $saldo_actual;


    $total_entrega_conv = $total_entrega_conv + $suma_entrega_ofi;
    $total_cobrado_conv = $total_cobrado_conv + $suma_cobrado;
    $total_moroso_conv = $total_moroso_conv + $suma_moroso;

    @$porcentaje = round($suma_cobrado * 100 / $suma_entrega_ofi);

    echo '<h3>CONVENIOS</h3>';
/*
    echo "<table>";
    echo "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>TOTAL COBRADO MOROSO</th><th>SALDO</th><th>".$porcentaje." %</th></tr>";
    echo '<tr><td><strong>ANTERIOR</strong></td><td>'.number_format($entregaAnt + $reco_anteri,0,',','.').'</td><td>'.number_format($reco_anteri,0,',','.').'</td><td>'.number_format($moro_anteri,0,',','.').'</td><td>'.number_format($saldo_anterior,0,',','.').'</td></tr>';
    echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($ACTUAL,0,',','.').'</td><td>'.number_format($reco_actual,0,',','.').'</td><td>'.number_format($moro_actual,0,',','.').'</td><td>'.number_format($saldo_actual,0,',','.').'</td></tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anticipado,0,',','.').'</td><td>'.number_format($anti_moros,0,',','.').'</td><td>'.$saldo_anticipado.'</td></tr>';
    echo '<tr><th></th><td><strong>'.number_format($suma_entrega_ofi,0,',','.').'</strong></td><td><strong>'.number_format($suma_cobrado,0,',','.').'</strong></td><td><strong>'.number_format($suma_moroso,0,',','.').'</strong></td><td><strong>'.number_format($suma_saldo,0,',','.').'</strong></td></tr>';
    echo $periodos->table_cierre;
    echo "</table>";
*/

   $entre_ant = number_format($entregaAnt + $reco_anteri,0,',','.');
   $entre_act = number_format($ACTUAL,0,',','.');
   $entre_ade = number_format($anticipado,0,',','.');
   $entre_sum = number_format($total_entrega_conv,0,',','.');

   $cobra_ant = number_format($reco_anteri,0,',','.');
   $cobra_act = number_format($reco_actual,0,',','.');
   $cobra_ade = number_format($anticipado,0,',','.');
   $cobra_sum = number_format($suma_cobrado,0,',','.');

   $moros_ant = number_format($moro_anteri,0,',','.');
   $moros_act = number_format($moro_actual,0,',','.');
   $moros_ade = number_format($anti_moros,0,',','.');
   $moros_sum = number_format($suma_moroso,0,',','.');

   $tcobd_ant = number_format($reco_anteri + $moro_anteri,0,',','.');
   $tcobd_act = number_format($reco_actual + $moro_actual,0,',','.');
   $tcobd_ade = number_format($anticipado + $anti_moros,0,',','.');
   $tcobd_sum = number_format($suma_cobrado + $suma_moroso,0,',','.');

   $saldo_ant = number_format( ($entregaAnt + $reco_anteri) -  ($reco_anteri),0,',','.');
   $saldo_act = number_format( ($ACTUAL) - ($reco_actual),0,',','.');
   $saldo_ade = number_format(($anticipado - $anticipado),0,',','.');
   $saldo_sum = number_format(($total_entrega_conv) - ($suma_cobrado),0,',','.');


   $por_ant = round( $reco_anteri / ($entregaAnt + $reco_anteri)*100 );
   $por_act = round( $reco_actual / $ACTUAL *100 );


        echo "<table>";
    echo "<tr><th></th>                            <th>ENTREGA      </th>      <th>COBRADO       </th> <th>                  </th>        <th>COBRADO MOROSO</th>               <th>TOTAL COBRADO</th>         <th>SALDO            </th>     <th>                 </th>     </tr>";
    echo '<tr><td><strong>ANTERIOR</strong> </td>  <td>'.$entre_ant.'</td>     <td>'.$cobra_ant.'</td> <td>'.$por_ant.' %</td>        <td>'.$moros_ant.'      </td>         <td>'.$tcobd_ant.'</td>        <td>'.$saldo_ant.'   </td>         <td>'.(100-$por_ant).' %</td>     </tr>';
    echo '<tr><td><strong>ACTUAL</strong></td>     <td>'.$entre_act.'</td>     <td>'.$cobra_act.'</td> <td>'.$por_act.' %</td>        <td>'.$moros_act.'      </td>         <td>'.$tcobd_act.'</td>        <td>'.$saldo_act.'   </td>         <td>'.(100-$por_act).' %</td>     </tr>';
    echo '<tr><td><strong>ANTICIPADO</strong></td> <td>'.$entre_ade.'</td>     <td>'.$cobra_ade.'</td> <td>              </td>        <td>'.$moros_ade.'      </td>         <td>'.$tcobd_ade.'</td>        <td>'.$saldo_ade.'   </td>         <td>                 </td>     </tr>';
    echo '<tr><th></th>                            <td>'.$entre_sum.'</td>     <td>'.$cobra_sum.'</td> <td>'.$porcentaje.' %</td>        <td>'.$moros_sum.'      </td>         <td>'.$tcobd_sum.'</td>        <td>'.$saldo_sum.'   </td>      <td>'.(100-$porcentaje).' %</td>     </tr></tr>';
    echo $periodos->table_cierre;
    echo "</table>";

//CONVENIOS




//EVENTOS
$informe = new Periodos3();
$eventos = $informe->eve("Evento", $periodo);

echo '<h3>EVENTOS</h3>';
echo "<table class='table2'>";
echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($eventos,0,',','.').'</td></tr>';
echo "</table>";
unset($informe);


//TRASLADOS
$informe = new Periodos3();
$traslados = $informe->eve("Traslado", $periodo);

echo '<h3>TRASLADOS</h3>';
echo "<table class='table2'>";
echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($traslados,0,',','.').'</td></tr>';
echo "</table>";
unset($informe);

//MEDIMEL
$informe = new Periodos3();
$medimel = $informe->eve("MEDIMEL", $periodo);

echo '<h3>MEDIMEL</h3>';
echo "<table class='table2'>";
echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($medimel,0,',','.').'</td></tr>';
echo "</table>";
unset($informe);

//DICOM
$informe = new Periodos3();
$dicom = $informe->dicom($periodo);

echo '<h3>DICOM</h3>';
echo "<table class='table2'>";
echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($dicom,0,',','.').'</td></tr>';
echo "</table>";
unset($informe);

//COPAGOS
$informe = new Periodos3();
$cop = $informe->copagos($periodo);

echo '<h3>COPAGOS</h3>';
echo "<table class='table2'>";
echo '<tr><td><strong>ACTUAL</strong></td><td>'.number_format($cop,0,',','.').'</td></tr>';
echo "</table>";
unset($informe);




?>
<br /><br />

<h3>RESUMEN</h3>
<table class="table2">

    <tr>
        <th></th>
        <th>ENTREGA</th>
        <th>COBRADO</th>
        <th>COBRADO MOROSO</th>
        <th>SALDO</th>
    </tr>

    <tr>
        <td><strong>ZONA</strong></td>
        <td><?php echo number_format($total_entregado_zona,0,',','.'); ?></td>
        <td><?php echo number_format($total_cobrado_zona,0,',','.'); ?></td>
        <td><?php echo number_format($total_moroso_zona,0,',','.'); ?></td>
        <td><?php echo number_format($total_entregado_zona - $total_cobrado_zona,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $total_entregado_zona; ?>
        <?php $cobrado = $cobrado + $total_cobrado_zona; ?>
        <?php $moroso = $moroso + $total_moroso_zona; ?>
        <?php $saldo = $saldo + ($total_entregado_zona - $total_cobrado_zona); ?>



    <tr>
        <td><strong>VIRTUAL</strong></td>
        <td><?php echo number_format($total_entregado_vi,0,',','.'); ?></td>
        <td><?php echo number_format($total_cobrado_vi,0,',','.'); ?></td>
        <td><?php echo number_format($total_moroso_vi,0,',','.'); ?></td>
        <td><?php echo number_format($total_entregado_vi - $total_cobrado_vi,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $total_entregado_vi; ?>
        <?php $cobrado = $cobrado + $total_cobrado_vi; ?>
        <?php $moroso = $moroso + $total_moroso_vi; ?>
        <?php $saldo = $saldo + ($total_entregado_vi - $total_cobrado_vi); ?>


    <tr>
        <td><strong>OFICINA</strong></td>
        <td><?php echo number_format($total_entregado_ofi,0,',','.'); ?></td>
        <td><?php echo number_format($total_cobrado_ofi,0,',','.'); ?></td>
        <td><?php echo number_format($total_moroso_ofi,0,',','.'); ?></td>
        <td><?php echo number_format( $total_entregado_ofi - $total_cobrado_ofi,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $total_entregado_ofi; ?>
        <?php $cobrado = $cobrado + $total_cobrado_ofi; ?>
        <?php $moroso = $moroso + $total_moroso_ofi; ?>
        <?php $saldo = $saldo + ($total_entregado_ofi - $total_cobrado_ofi); ?>


    <tr>
        <td><strong>CONVENIOS</strong></td>
        <td><?php echo number_format($total_entrega_conv,0,',','.'); ?></td>
        <td><?php echo number_format($total_cobrado_conv,0,',','.'); ?></td>
        <td><?php echo number_format($total_moroso_conv,0,',','.'); ?></td>
        <td><?php echo number_format($total_entrega_conv - $total_cobrado_conv,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $total_entrega_conv; ?>
        <?php $cobrado = $cobrado + $total_cobrado_conv; ?>
        <?php $moroso = $moroso + $total_moroso_conv; ?>
        <?php $saldo = $saldo + ($total_entrega_conv - $total_cobrado_conv); ?>


    <tr>
        <td><strong>EVENTOS</strong></td>
        <td><?php echo number_format($eventos,0,',','.'); ?></td>
        <td><?php echo number_format($eventos,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
        <td><?php echo number_format($eventos-$eventos,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $eventos; ?>
        <?php $cobrado = $cobrado + $eventos; ?>
        <?php $moroso = $moroso + 0; ?>
        <?php $saldo = $saldo + ($eventos - $eventos); ?>

     <tr>
        <td><strong>TRASLADOS</strong></td>
        <td><?php echo number_format($traslados,0,',','.'); ?></td>
        <td><?php echo number_format($traslados,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $traslados; ?>
        <?php $cobrado = $cobrado + $traslados; ?>
        <?php $moroso = $moroso + 0; ?>
        <?php $saldo = $saldo + ($traslados - $traslados); ?>

      <tr>
        <td><strong>MEDIMEL</strong></td>
        <td><?php echo number_format($medimel,0,',','.'); ?></td>
        <td><?php echo number_format($medimel,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
        <td><?php echo number_format($medimel-$medimel,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $medimel; ?>
        <?php $cobrado = $cobrado + $medimel; ?>
        <?php $moroso = $moroso + 0; ?>
        <?php $saldo = $saldo + ($medimel - $medimel); ?>


      <tr>
        <td><strong>DICOM</strong></td>
        <td><?php echo number_format($dicom,0,',','.'); ?></td>
        <td><?php echo number_format($dicom,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
        <td><?php echo number_format($dicom-$dicom,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $dicom; ?>
        <?php $cobrado = $cobrado + $dicom; ?>
        <?php $moroso = $moroso + 0; ?>
        <?php $saldo = $saldo + ($dicom - $dicom); ?>

      <tr>
        <td><strong>COPAGOS</strong></td>
        <td><?php echo number_format($cop,0,',','.'); ?></td>
        <td><?php echo number_format($cop,0,',','.'); ?></td>
        <td><?php echo number_format(0,0,',','.'); ?></td>
        <td><?php echo number_format($cop-$cop,0,',','.'); ?></td>
    </tr>

        <?php $entregado = $entregado + $cop; ?>
        <?php $cobrado = $cobrado + $cop; ?>
        <?php $moroso = $moroso + 0; ?>
        <?php $saldo = $saldo + ($cop - $cop); ?>


   <tr>
        <th>TOTAL</th>
        <th><?php echo number_format($entregado,0,',','.'); ?></th>
        <th><?php echo number_format($cobrado,0,',','.'); ?></th>
        <th><?php echo number_format($moroso,0,',','.'); ?></th>
        <th><?php echo number_format($saldo,0,',','.'); ?></th>
    </tr>

</table>

