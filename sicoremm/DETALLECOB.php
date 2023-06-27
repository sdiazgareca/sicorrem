<?php

 header('Content-type: application/msword');
 header('Content-Disposition: inline; filename=FEDOC.rtf');

include_once('DAT/conf.php');
include_once('DAT/bd.php');
include_once('CLA/Periodos4.php');
include_once('CLA/Datos.php');
?>

<style type="type/css" >

    body{
        font-size: 10pt;
        font-family: Arial;
        text-align: justify;
}

 h3{
        font-size: 10pt;
        font-family: Arial;
        text-align: justify;
}

p{
    text-align: justify;
    font-size: 10pt;
}

table{
    background-color:  #C0C0C0;
    border: none;
}

table tr{
    background-color:#ffffff;
    border: solid 1px #ffffff;
}

table tr td{
    background-color:#ffffff;
    font-size: 12px;
    border: solid 1px #ffffff;

}

</style>
<?php

$per = explode('-', $_GET['periodo']);

$periodo = $per[0].'-'.$per[1].'-01';
$inicio =  $per[0].'-'.$per[1].'-'.$per[2];

$cierre1 = $_GET['cierre1'];
$cierre2 = $_GET['cierre2'];
$cierre3 = $_GET['cierre3'];

$c1 = explode("-",$_GET['cierre1']);
$c2 = explode("-",$_GET['cierre2']);
$c3 = explode("-",$_GET['cierre3']);

$f_cierre1= $c1[2].'/'.$c1[1].'/'.$c1[0];
$f_cierre2= $c2[2].'/'.$c2[1].'/'.$c2[0];
$f_cierre3= $c3[2].'/'.$c3[1].'/'.$c3[0];


$fecha = new Datos();
$normal = $fecha->cambiaf_a_mysql($_GET['periodo']);


/*
echo 'PERIODO '.$periodo.'<br />';
echo 'INICIO '.$inicio.'<br />';
echo 'CIERRE1 '.$cierre1.'<br />';
echo 'CIERRE2 '.$cierre2.'<br />';
echo 'CIERRE3 '.$cierre3.'<br />';
*/

$cobrador_sql = "SELECT cobrador.nombre1, cobrador.nombre2, cobrador.apellidos, cobrador.codigo,nro_doc
                 FROM cobrador
                 WHERE cobrador.codigo='".$_GET['cobrador']."'";

$query_cobrador = mysql_query($cobrador_sql);

$cobrador = mysql_fetch_array($query_cobrador);

$rut = new Datos();
$rut->validar_rut($cobrador['nro_doc']);
$_POST['cobrador']=$cobrador['codigo'];
?>

<strong>RESUMEN COBRABZA <br /><?php echo strtoupper($cobrador['nombre1'].' '.$cobrador['nombre2'].' '.$cobrador['apellidos']); ?></strong>
<br /><strong>PERIODO <?php echo $normal; ?></strong>
<br />
Fecha <?php echo date("d-m-Y");?><br />

<?php

$pendientes_zona = new Periodos3();

echo '<h3>Total Pendiente Zona</h3>';
echo $pendientes_zona->inicio;
echo $pendientes_zona->cabecera;
$Total_pendiente = $pendientes_zona->pendiente($periodo, $inicio, $cierre3, $_POST['cobrador'],1,0);
echo $pendientes_zona->cierre;

echo '<h3>Total '.$Total_pendiente.'</h3>';

$devoluvionces = new Periodos3();
/*
echo '<h3>Devoluciones</h3>';
echo $devoluvionces->inicio;
echo $devoluvionces->cabecera;
$Total_devueltas = $devoluvionces->pendiente($periodo, $inicio, $cierre3, $_POST['cobrador'],1,1);
echo $devoluvionces->cierre;
echo '<h3>TOTAL '.$Total_devueltas.'</h3>';
*/
/**********************************************************************************************************/

$anti = new Periodos3();

echo '<h3>Total Anticipado</h3>';
echo $anti->inicio;
echo $anti->cabecera;
$anticipado_Zona = $anti->cobrado('>', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',1);
$anticipado_fueraZona = $anti->cobrado('>', $periodo, $inicio, $cierre3, $_POST['cobrador'],'!=',1);
$Total_Anti = $anticipado_Zona + $anticipado_fueraZona;
echo $anti->cierre;

echo '<h3>Total '.$Total_Anti.'</h3>';




$fueraZona = new Periodos3();
echo '<h3>Fuera de Zona</h3>';
echo $fueraZona->inicio;
echo $fueraZona->cabecera;
$pendiente_fueraZona = $fueraZona->cobrado('<', $periodo, $inicio, $cierre3, $_POST['cobrador'],'!=',1);
$actual_fueraZona = $fueraZona->cobrado('=', $periodo, $inicio, $cierre3, $_POST['cobrador'],'!=',1);
//$anticipado_fueraZona = $fueraZona->cobrado('>', $periodo, $inicio, $cierre3, $_POST['cobrador'],'!=',1);
echo $fueraZona->cierre;
$total_fueraZona = $pendiente_fueraZona + $actual_fueraZona;
echo '<h3>Total '.$total_fueraZona.'</h3>';
/**********************************************************************************************************/

$periodos = new Periodos3();

$pendiente_cierre1 = $periodos->cobrado('<', $periodo, $inicio, $cierre1, $_POST['cobrador'],'=',0);
$actual_cierre1 = $periodos->cobrado('=', $periodo, $inicio, $cierre1, $_POST['cobrador'],'=',0);
//$anticipado_cierre1 = $periodos->cobrado('>', $periodo, $inicio, $cierre1, $_POST['cobrador'],'=',0);

$pendiente_cierre2 = $periodos->cobrado('<', $periodo, $inicio, $cierre2, $_POST['cobrador'],'=',0);
$actual_cierre2 = $periodos->cobrado('=', $periodo, $inicio, $cierre2, $_POST['cobrador'],'=',0);
//$anticipado_cierre2 = $periodos->cobrado('>', $periodo, $inicio, $cierre2, $_POST['cobrador'],'=',0);

/*
$pendiente = $periodos->cobrado('<', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',0);
$actual = $periodos->cobrado('=', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',0);
$anticipado = $periodos->cobrado('>', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',0);

$total_cobrado = ($pendiente + $actual + $anticipado);
$total_entregado = $Total_pendiente + $total_cobrado;
*/

echo '<h3>COBRADO ZONA</h3>';
echo $fueraZona->inicio;
echo $fueraZona->cabecera;
$pendiente = $periodos->cobrado('<', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',1);
$actual = $periodos->cobrado('=', $periodo, $inicio, $cierre3, $_POST['cobrador'],'=',1);
echo $fueraZona->cierre;

$total_cobrado = ($pendiente + $actual);
$total_entregado = $Total_pendiente + $total_cobrado;

echo '<h3>Total '.$total_cobrado.'</h3>';

echo '<h3>RESUMEN</h3>';
echo '<table class="table2" border="1">';

//BONO1

if(number_format((($actual_cierre1 + $pendiente_cierre1)* 100/$total_entregado),0,',','.') >= 60){

    $bono1 = 45000;
}
else{
    $bono1 = 0;
}

if(number_format((($pendiente_cierre2 + $actual_cierre2 )* 100/$total_entregado),0,',','.') >= 80){

    $bono2 = 30000;
}
else{
    $bono2 = 0;
}

if(number_format(($total_cobrado* 100/$total_entregado),0,',','.') >= 93){

    $bono3 = 40000;
}
else{
    $bono3 = 0;
}

$bono = number_format(($bono1 + $bono2 + $bono3),0,',','.');

/*
 * COPAGO
 */

$cobrador_sql = "SELECT cobrador.nro_doc FROM cobrador WHERE cobrador.codigo='".$_POST['cobrador']."'";
$cobrador_query = mysql_query($cobrador_sql);
$cob = mysql_fetch_array($cobrador_query);

//echo '<br />'.$cobrador_sql.'<br />';

$copago_sql ="SELECT SUM(copago.importe) AS importe FROM copago WHERE cobrador='".$cob['nro_doc']."' AND f_pago BETWEEN '".$inicio."' AND '".$cierre3."'";
$query_sql = mysql_query($copago_sql);
$total_copago = mysql_fetch_array($query_sql);

//echo '<br />'.$copago_sql.'<br />';

echo '<tr><td><strong>Total Cobrado hasta el '.$f_cierre1.' </strong></td><td>'.number_format(($actual_cierre1 + $pendiente_cierre1),0,',','.').'</td><td>'.number_format((($actual_cierre1 + $pendiente_cierre1)* 100/$total_entregado),0,',','.').'</td><td>%</td><td>'.$bono1.'</td></tr>';
echo '<tr><td><strong>Total Cobrado hasta el '.$f_cierre2.' </strong></td><td>'.number_format(($pendiente_cierre2 + $actual_cierre2),0,',','.').'</td><td>'.number_format(($pendiente_cierre2 + $actual_cierre2)* 100/$total_entregado,0,',','.').'</td><td>%</td><td>'.$bono2.'</td></tr>';
echo '<tr><td><strong>Total Cobrado hasta el '.$f_cierre3.' </strong></td><td>'.number_format($total_cobrado,0,',','.').'</td><td>'.number_format(($total_cobrado * 100/$total_entregado),0,',','.').'</td><td>%</td><td>'.$bono3.'</td></tr>';
echo '<tr><td><strong>Total Entregado Zona </strong></td><td>'.number_format($total_entregado,0,',','.').'</td><td>100</td><td>%</td><td></td></tr>';
echo '<tr><td><strong>Copago</strong></td><td>'.number_format($total_copago['importe'],0,',','.').'</td><td></td><td></td><td></td></tr>';
echo '<tr><td><strong>Total Cobrado Fuera de Zona</strong></td><td>'.number_format($total_fueraZona,0,',','.').'</td><td></td><td></td><td></td></tr>';
echo '<tr><td><strong>Total Cobrado Anticipado</strong></td><td>'.number_format($Total_Anti,0,',','.').'</td><td></td><td></td><td></td></tr>';
echo '</table>';

echo '<br /><br />';

echo '<table border="1" class="table2">';
echo '<tr><td><strong>TOTAL COBRADO</strong></td><td><strong>COMISION</strong></td><td><strong>COPAGO</strong></td><td><strong>PREMIOS</strong></td></tr>';
echo '<tr><td>'.number_format($Total_Anti + $total_fueraZona + $total_cobrado,0,',','.').'</td><td>'.number_format((($Total_Anti + $total_fueraZona + $total_cobrado + $total_copago['importe'])*10/100),0,',','.').'</td><td>'.number_format($total_copago['importe'],0,',','.').'</td><td>'.$bono.'</td></tr>';
echo '</table>';
?>
