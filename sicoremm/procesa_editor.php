<?php

include_once('DAT/conf.php');
include_once('DAT/bd.php');


$nombre_archivo = $_FILES['userfile']['name'];
$nombre_archivo = "correctorMan.csv";
$tipo_archivo = $_FILES['userfile']['type'];
$tamano_archivo = $_FILES['userfile']['size'];

	if ( ($tipo_archivo != "application/vnd.ms-excel") && ($tipo_archivo != "text/csv")) {
   		echo "La extensi&oacute;n del archivo no es correcta.<br /><a href='Editor.php'>Volver</a>";
                exit;
        }

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo)){

            echo '<table border="1"><tr><th>RUT BANCO</th><th>IMPORTE BANCO</th><th>CONTRATO</th><th>RUT SICOREMM</th><th>FECHA SICOREMM</th><th>RENDICION</th><th>COD_MOV</th><th>COMP</th><th>IMPORTE SICOREMM</th><th>PERIODO</th></tr>';

            if (($gestor = fopen($nombre_archivo, "r")) !== FALSE) {

                    while (($datos = fgetcsv($gestor,"10000",";")) !== FALSE) {
                        
                        //$sql ="SELECT debe,comprovante,cod_mov,rendicion,nro_doc, haber, fecha
                          //     FROM cta
                            //   WHERE cta.nro_doc='".$datos[0]."' AND cta.fecha_mov='".$_POST['periodo']."'";


                        $sql ="SELECT contratos.num_solici

                        ,cta.debe,cta.comprovante,cta.cod_mov,cta.rendicion,cta.nro_doc, cta.haber, cta.fecha, cta.fecha_mov

                        FROM contratos
INNER JOIN doc_f_pago ON doc_f_pago.numero = contratos.doc_pago
INNER JOIN bancos ON bancos.codigo = doc_f_pago.banco
INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
 WHERE doc_f_pago.rut_titular_cta='".$datos[0]."' AND cta.fecha_mov='".$_POST['periodo']."' AND cod_mov != 1";

echo '<tr><td><strong>'.$datos[0].'</td><td>'.$datos[1].'</strong></td>';


                        $query = mysql_query($sql);
                        
                        //echo '<br />'.$sql.'<br />';

                        $num = mysql_num_rows($query);

       
                        if($num > 0){
                   
                        $info = mysql_fetch_array($query);
                            
                        echo '<td>'.$info['num_solici'].'</td><td>'.$info['nro_doc'].'</td><td>'.$info['fecha'].'</td><td>'.$info['rendicion'].'</td><td>'.$info['cod_mov'].'</td><td>'.$info['comprovante'].'</td><td>'.$info['haber'].'</td><td>'.$info['fecha_mov'].'</td>';
                        echo '<td><input type="checkbox" name="'.$datos[0].'" value="Butter" /></td>';                    
                        }

                    }

                    echo'</tr>';


            }
            echo '</table>';
        }

?>

