<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');


include('DAT/conf.php');
include('DAT/bd.php');
include('CLA/Datos.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SICOREMM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="JS/jquery/jquery.js"></script>
<script type="text/javascript" src="JS/jquery/jqueryRut.js"></script>
<script type="text/javascript" src="JS/jquery/Jquery.Rut.min.js"></script>
<script type="text/javascript" src="JS/DISP.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.datepicker.js"></script>


<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>


<link rel="stylesheet" href="JS/calendar/development-bundle/themes/base/jquery.ui.all.css" />
<link href="CSS/estructura.css" rel="stylesheet" type="text/css" />
<link href="CSS/fuentes.css" rel="stylesheet" type="text/css" />
<link href="CSS/menu.css" rel="stylesheet" type="text/css" />
<link href="CSS/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenedor">


<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('DAT/conf.php');
include_once('DAT/bd.php');
include_once('CLA/Contrato.php');
include_once('CLA/Cta.php');

$sql = "SELECT contratos.num_solici, contratos.titular
          FROM contratos
          WHERE contratos.estado = '3100' AND f_baja='2011-05-01'";

$query = mysql_query($sql);
$contrato = new Contrato();

while ($con = mysql_fetch_array($query)){
    
    echo '<br />';
    echo '<div style="border: solid 1px; padding: 5px;">';
    echo '<h2>Datos del Afiliado</h2>';    
    $contrato->MuestraResumenContrato($con['num_solici']);
    echo '<h2>Detalle</h2>';
    $cta = new Cta();
    $cta->BuscaBoletasCMmoroso($con['num_solici'],$con['titular']);
    echo '</div>';
    echo '<br />';


}

?>
</div>
</div>
</body>
</html>