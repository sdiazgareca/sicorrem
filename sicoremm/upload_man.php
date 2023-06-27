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
<div id="cabezera">

  <table width="100%">
  <tr>
  <td align="left"><img src="IMG/L1.jpg" /></td>
  <td align="right">&nbsp;</td>
  </tr>
</table>

</div><!-- cabezera -->

<div class="usuario">Cargador MED</div><!-- usuario -->

<div id="contenido" style="width:800px; height:500px; overflow:auto;">

<?php
$nombre_archivo = $_FILES['userfile']['name'];
$nombre_archivo = "MED.csv";
$tipo_archivo = $_FILES['userfile']['type'];
$tamano_archivo = $_FILES['userfile']['size'];

	if ( ($tipo_archivo != "application/vnd.ms-excel") && ($tipo_archivo != "text/csv")) {
   		echo "La extensi&oacute;n del archivo no es correcta.<br /><a href='index.php'>Volver</a>";
                exit;
        }

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo)){

		echo '<br />';

                echo '<form action="BIN/PAC_REN.php" method="post" name="PAC">';
                echo'<input style="display:none;"  type="text" value="2" name="carga" />';
                echo '<table class="table">';
                echo '<tr>';
                echo '<th>RUT BANCO</th>';
                echo '<th>MONTO BANCO</th>';
                echo '<th>CONTRATO</th>';
                echo '<th>RUT TITULAR REM</th>';
                echo '<th>RUT CTA</th>';
                echo '<th>MENSUALIDAD</th>';
                echo '<th>BANCO</th>';
                echo '</tr>';

                if (($gestor = fopen($nombre_archivo, "r")) !== FALSE) {

                    while (($datos = fgetcsv($gestor,"10000",";")) !== FALSE) {

                        $fecha = new Datos;
                        $f = $fecha->cambiaf_a_mysql($_POST['fecha_mov']);

                        $nro_doc = $datos[0];
                        $monto = $datos[1];

                        $consulta = "SELECT contratos.num_solici, bancos.descripcion, contratos.titular, doc_f_pago.rut_titular_cta,cta.importe AS valor,contratos.factu, DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS fecha_mov2, cta.comprovante
                                     FROM contratos
                                     INNER JOIN doc_f_pago ON doc_f_pago.numero = contratos.num_solici
                                     INNER JOIN bancos ON doc_f_pago.banco = bancos.codigo
                                     INNER JOIN cta ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici
                                     WHERE doc_f_pago.rut_titular_cta = '".$nro_doc."' AND cta.fecha_mov='".$f."' AND cta.afectacion < 1";

                       $query2 = mysql_query($consulta);

                        $fec = new Datos();

                        $cam = explode('-',$_POST['fecha_f']);

                        $f1 = $cam[2].'-'.$cam[1].'-'.$cam[0];

                        if (checkdate($cam[1], $cam[0], $cam[2]) == false){
                            echo'Error de fecha..';
                            exit;

                        }


                        $num = mysql_num_rows($query2);

                        if ($num > 0){

                        while($val = mysql_fetch_array($query2)){

                            echo '<tr><td>'.$nro_doc.'</td><td>'.$monto.'</td><td>'.$val['num_solici'].'</td><td>'.$val['titular'].'</td><td>'.$val['rut_titular_cta'].'</td><td>'.$val['valor'].'</td><td>'.$val['descripcion'].'</td><td>&zwnj;</td><td><input type="checkbox" name="'.$val['comprovante'].$val['num_solici'].'"  value="'.$val['titular'].'/'.$val['factu'].'/'.$val['comprovante'].'/92/'.$val['fecha_mov2'].'/'.$val['valor'].'/'.$val['num_solici'].'/'.$_POST['rendicion'].'/'.$f1.'" checked></td></tr>';
                        }
                        }
                        else{

                            echo '<tr><td>'.$nro_doc.'</td><td>'.$monto.'</td><td>&zwnj;</td><td>&zwnj;</td><td>&zwnj;</td><td>&zwnj;</td><td>&zwnj;</td><td>&zwnj;</td><td>&zwnj;</td></tr>';

                        }
                    }

                }

                echo '</table>';
                echo '<input type="submit" class="boton" value="Cargar" />';
                echo '</form>';
        }

?>
</div>
</div>
</body>
</html>