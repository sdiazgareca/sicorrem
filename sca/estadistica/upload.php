<?php
include('DAT/conf.php');
include('DAT/bd.php');
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

$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
$nombre_archivo = "MED.csv";
$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];

//echo $tipo_archivo;


	if ( ($tipo_archivo != "application/vnd.ms-excel") && ($tipo_archivo != "application/octet-stream")) {
   		echo "La extensi&oacute;n del archivo no es correcta.<br /><a href='index.php'>Volver</a>";
                exit;
	}

        else{

            if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $nombre_archivo)){
      	 	
		

                if (($gestor = fopen($nombre_archivo, "r")) !== FALSE) {

                                echo '<br />';
				$tabla= '<table class="table2"><tr><th>ESTADO</th><th>CONTRATO</th><th>RUT</th><th>PLAN</th><th>TIPO PLAN</th></tr>';
    				while (($datos = fgetcsv($gestor,"10000",";")) !== FALSE) {

					switch($datos[15]){case 'SIN ISAPRE':$isapre='7777';break;case 'BANMEDICA':$isapre='123';break;case 'CHUQUICAMATA':$isapre='111';break;case 'COLMENA GOLDEN CROSS':$isapre='949540006';break;case 'CONSALUD':$isapre='96856780';break;case 'FONASA':$isapre='155';break;case 'CRUZ BLANCA':$isapre='96501450';break;case 'VIDA TRES':$isapre='17';break;case 'FUSAT':$isapre='2089';break;case 'MAS VIDA':$isapre='965225005';break;case 'ING':$isapre='666';break;default:$isapre='7777';break;}
					switch($datos[7]){case 'TITULAR':$parentesco='100';break;case 'ESPOSA':$parentesco='200';break;case 'CONVIVIENTE':$parentesco='600';break;case 'HIJASTRO':$parentesco='700';break;case 'HIJO(A)':$parentesco='300';break;case 'HIJO_INV':$parentesco='400';break;case 'MADRE':$parentesco='800';break;case 'MED.PROTEC':$parentesco='500';break;}

                                        	if ($datos[7] =='TITULAR'){

                                                $fechaNAC = explode('/',$datos[8]);
                                                $f_nac =$fechaNAC[2].'-'.$fechaNAC[1].'-'.$fechaNAC[0];

                                                //echo 'Nueva Fecha '.$f_nac.'<br />';

                                                $com_num_solici_sql ="SELECT COUNT(contratos.titular) AS num, num_solici FROM contratos WHERE contratos.titular='".$datos[0]."' AND num_solici >= 70000";
                                                
                                                //echo $com_num_solici_sql.'<br />';

                                                $com_num_solici_query = mysql_query($com_num_solici_sql);
                                                $com_num_solici = mysql_fetch_array($com_num_solici_query);



                                                    if($com_num_solici['num'] > 0){

                                                        $cambia_isapre = 'UPDATE afiliados SET obra_numero="'.$isapre.'", fecha_nac="'.$f_nac.'" WHERE nro_doc="'.$datos[0].'"';
                                                        
                                                        
                                                        if (mysql_query($cambia_isapre)){
                                                            $tabla = $tabla.'<tr><td>EXISTE</td><td>'.$com_num_solici['num_solici'].'</td><td>'.$datos[0].'</td><td>W71</td><td>2</td></tr>';
                                                        }
                                                        else{
                                                            $tabla = $tabla.'<tr><td>ERROR</td><td>'.$com_num_solici['num_solici'].'</td><td>'.$datos[0].'</td><td>'.$com['cod_plan'].'</td><td>PLAN '.$com['tipo_plan'].'</td></tr>';
                                                        }
                                                    }

                                                    if($com_num_solici['num'] < 1){

                                                        //numero maximo de contrato
                                                        $contrato_sql = "SELECT MAX(contratos.num_solici) as contrato FROM contratos WHERE cod_plan ='W71' AND tipo_plan='2'";
                                                        $contrato_query = mysql_query($contrato_sql);
                                                        $contrato = mysql_fetch_array($contrato_query);

                                                        echo 'contrato = '.$contrato['contrato'].'<br />';

                                                        if ($contrato['contrato'] < 70000){
                                                            $conMED = 70000;
                                                        }

                                                        else{
                                                        $conMED = $contrato['contrato'] + 1;
                                                        }

                                                        echo '<br />'.$conMED.'<br />';



                                                        $titu = "INSERT INTO titulares (nro_doc,apellido,nombre1,nombre2,fecha_nac,sexo, profesion,civil,ciudad) VALUES('".$datos[0]."','".$datos[2]."','".$datos[3]."','".$datos[4]."','".$f_nac."','".$datos[5]."', '300','".$datos[6]."','606')";
                                                        $cont = "INSERT INTO contratos (num_solici,estado,titular,f_pago,cod_plan,tipo_plan,ZO,SE,MA, d_pago,f_ingreso,empresa) VALUES('".$conMED."','500','".$datos[0]."','600','W71','2','111','111','111','10', '".date("Y-m-d")."','15004439')";
                                                        $agregarTITULAR = "INSERT INTO afiliados (apellido,nombre1,nombre2,sexo,fecha_alta, fecha_act,fecha_ing,fecha_nac,nro_doc,pais,cod_parentesco,cod_baja, categoria,num_solici,titular,cod_plan,tipo_plan,obra_numero) VALUES('".$datos[2]."','".$datos[3]."','".$datos[4]."','".$datos[5]."','".date("Y-m-d")."', '".date("Y-m-d")."','".date("Y-m-d")."','".$f_nac."','".$datos[0]."','600','100','00','1','".$conMED."','".$datos[9]."', 'W71','2','".$isapre."')";

                                                        $titu_query = mysql_query($titu);
                                                        $cont_query = mysql_query($cont);

                                                        if (mysql_query($agregarTITULAR)){
                                                            $tabla = $tabla.'<tr><td>GUARDADO </td><td>'.$conMED.'</td><td>'.$datos[0].'</td><td>'.$com['cod_plan'].'</td><td>PLAN '.$com['tipo_plan'].'</td></tr>';
                                                        }
                                                        else{
                                                            $tabla = $tabla.'<tr><td>ERROR </td><td>'.$conMED.'</td><td>'.$datos[0].'</td><td>'.$com['cod_plan'].'</td><td>PLAN '.$com['tipo_plan'].'</td></tr>';
                                                        }
                                                }



                                }


                                }







        }




                      if (($gestor = fopen($nombre_archivo, "r")) !== FALSE) {


				//echo '<table class="table2"><tr><th>ESTADO</th><th>CONTRATO</th><th>RUT</th><th>PLAN</th><th>TIPO PLAN</th></tr>';
    				while (($datos = fgetcsv($gestor,"10000",";")) !== FALSE) {

					switch($datos[15]){case 'SIN ISAPRE':$isapre='7777';break;case 'BANMEDICA':$isapre='123';break;case 'CHUQUICAMATA':$isapre='111';break;case 'COLMENA GOLDEN CROSS':$isapre='949540006';break;case 'CONSALUD':$isapre='96856780';break;case 'FONASA':$isapre='155';break;case 'CRUZ BLANCA':$isapre='96501450';break;case 'VIDA TRES':$isapre='17';break;case 'FUSAT':$isapre='2089';break;case 'MAS VIDA':$isapre='965225005';break;case 'ING':$isapre='666';break;default:$isapre='7777';break;}
					switch($datos[7]){case 'TITULAR':$parentesco='100';break;case 'ESPOSA':$parentesco='200';break;case 'CONVIVIENTE':$parentesco='600';break;case 'HIJASTRO':$parentesco='700';break;case 'HIJO(A)':$parentesco='300';break;case 'HIJO_INV':$parentesco='400';break;case 'MADRE':$parentesco='800';break;case 'MED.PROTEC':$parentesco='500';break;}

                                                $fechaNAC = explode('/',$datos[8]);
                                                $f_nac =$fechaNAC[2].'-'.$fechaNAC[1].'-'.$fechaNAC[0];




        if ($datos[7] !='TITULAR'){

                                   $com_num_solici_sql2 ="SELECT num_solici FROM contratos WHERE contratos.titular='".$datos[9]."' AND num_solici >= 70000";
                                   $com_num_solici_query2 = mysql_query($com_num_solici_sql2);
                                   $com_num_solici2 = mysql_fetch_array($com_num_solici_query2);

                                   $agregarTITULAR = "INSERT INTO afiliados (apellido,nombre1,nombre2,sexo,fecha_alta,fecha_act,fecha_ing,fecha_nac,nro_doc,pais,cod_parentesco,cod_baja,categoria,num_solici,titular,cod_plan,tipo_plan,obra_numero) VALUES('".$datos[2]."','".$datos[3]."','".$datos[4]."','".$datos[5]."','".date("Y-m-d")."','".date("Y-m-d")."','".date("Y-m-d")."','".$f_nac."','".$datos[0]."','600','".$parentesco."','00','2','".$com_num_solici2['num_solici']."','".$datos[9]."','W71','2','".$isapre."')";

                                   if (mysql_query($agregarTITULAR)){
                                                $tabla = $tabla.'<tr><td>C GUARDADO </td><td>'.$com_num_solici2['num_solici'].'</td><td>'.$datos[0].'</td><td>W71</td><td>2</td></tr>';
                                            }
                                            else{
                                                $tabla = $tabla.'<tr><td>C EXISTE </td><td>'.$com_num_solici2['num_solici'].'</td><td>'.$datos[0].'</td><td>W71</td><td>2</td></tr>';
                                                $cambia_isapre = 'UPDATE afiliados SET obra_numero="'.$isapre.'", fecha_nac="'.$f_nac.'" WHERE nro_doc="'.$datos[0].'"';
                                                //echo $cambia_isapre.'<br />';
                                            }$query2 = mysql_query($cambia_isapre);
          }




                                }

                                $tabla = $tabla.'</table>';





        }
}

$sql =" SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
        FROM afiliados
        WHERE afiliados.cod_baja='00'  ||  '05'  ||  'AJ' || 'AZ'  ||  '04' AND cod_plan='W71' AND tipo_plan='2'
        GROUP BY num_solici";

$query = mysql_query($sql);

while ($secuencia = mysql_fetch_array($query) ){

    $con = 'UPDATE sicoremm.contratos SET secuencia="'.$secuencia['secuencia'].'"
        WHERE num_solici="'.$secuencia['num_solici'].'"';


    if (mysql_query($con)){

        echo '';

    }
    else{
        echo '<br />ERROR<br />';
    }
}

?>
    <div style=" font-size: 20px; font-weight: bold;">CARGA REALIZADA =)</div>
<br /><br />



<?php
echo $tabla;


}

 ?>

</div>
</div>
</body>
</html>